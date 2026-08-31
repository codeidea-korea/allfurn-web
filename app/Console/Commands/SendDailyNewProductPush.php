<?php

namespace App\Console\Commands;

use App\Models\PushQ;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendDailyNewProductPush extends Command
{
    private const TIMEZONE = 'Asia/Seoul';
    private const LINK_TYPE = 1;

    /**
     * @var string
     */
    protected $signature = 'push:daily-new-products
                        {--date= : 기준일 YYYY-MM-DD}
                        {--dry-run : 푸시 큐를 생성하지 않고 조회 결과만 확인}
                        {--force : 이미 생성된 신상품 푸시가 있어도 새 큐를 생성}';

    /**
     * @var string
     */
    protected $description = '전날 17시부터 당일 16시 59분까지 등록된 신상품 수와 최근 신상품 이미지로 전체 회원 푸시를 생성합니다.';

    /**
     * @return int
     */
    public function handle()
    {
        try {
            $baseDate = $this->resolveBaseDate();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $startAt = $baseDate->copy()->subDay()->setTime(17, 0, 0);
        $endAt = $baseDate->copy()->setTime(17, 0, 0);
        $marker = 'daily-new-products:' . $baseDate->format('Y-m-d');

        $alreadyQueued = $this->alreadyQueued($marker);

        if ($alreadyQueued && ! $this->option('dry-run') && ! $this->option('force')) {
            $this->info('이미 생성된 신상품 푸시입니다. marker=' . $marker);
            return 0;
        }

        if ($alreadyQueued && $this->option('dry-run')) {
            $this->warn('이미 생성된 신상품 푸시가 있지만 dry-run 조회를 계속합니다. marker=' . $marker);
        }

        if ($alreadyQueued && $this->option('force')) {
            $this->warn('이미 생성된 신상품 푸시가 있지만 --force 옵션으로 새 큐를 생성합니다. marker=' . $marker);
        }

        $count = DB::query()
            ->fromSub($this->newProductQuery($startAt, $endAt), 'new_products')
            ->count(DB::raw('distinct idx'));

        if ($count < 1) {
            $this->info(sprintf(
                '신상품이 없어 푸시를 생성하지 않습니다. (%s ~ %s)',
                $startAt->format('Y-m-d H:i:s'),
                $endAt->copy()->subSecond()->format('Y-m-d H:i:s')
            ));
            return 0;
        }

        $latestProduct = DB::query()
            ->fromSub($this->newProductQuery($startAt, $endAt), 'new_products')
            ->orderBy('sold_at', 'desc')
            ->orderBy('sort_idx', 'desc')
            ->first();

        if ($latestProduct === null) {
            $this->error('신상품 개수는 확인되었지만 최근 상품을 찾지 못했습니다.');
            return 1;
        }

        $attachmentIdx = $this->representativeAttachmentIdx($latestProduct->attachment_idx);
        $productLink = $this->productDetailLink($latestProduct->idx);
        $title = '오늘 신상품 ' . number_format($count) . '건이 등록되었습니다.';
        $content = '지금 바로 확인하고 트랜드를 선점하세요!';

        if ($this->option('dry-run')) {
            $this->line('[DRY RUN] 신상품 푸시 생성 예정');
            $this->line('기간: ' . $startAt->format('Y-m-d H:i:s') . ' ~ ' . $endAt->copy()->subSecond()->format('Y-m-d H:i:s'));
            $this->line('개수: ' . number_format($count));
            $this->line('최근 상품 idx: ' . $latestProduct->idx);
            $this->line('판매중 기준: ' . $latestProduct->source);
            $this->line('판매중 전환 이력 idx: ' . ($latestProduct->history_idx ?: '-'));
            $this->line('판매중 기준 시간: ' . $latestProduct->sold_at);
            $this->line('대표 이미지 attachment_idx: ' . $attachmentIdx);
            $this->line('제목: ' . $title);
            $this->line('내용: ' . $content);
            return 0;
        }

        $push = new PushQ();
        $push->type = 'push';
        $push->title = $title;
        $push->content = $content;
        $push->push_info = $marker;
        $push->attachment_idx = $attachmentIdx;
        $push->app_link_type = self::LINK_TYPE;
        $push->app_link = $productLink;
        $push->web_link_type = self::LINK_TYPE;
        $push->web_link = $productLink;
        $push->send_type = 'G';
        $push->send_target = 'A';
        $push->state = 'W';
        $push->send_date = Carbon::now(self::TIMEZONE)->addSeconds(5)->format('Y-m-d H:i:s');
        $push->is_ad = 0;
        $push->is_delete = 0;
        $push->register_time = DB::raw('now()');
        $push->save();

        Log::info('[DailyNewProductPush] push queued', [
            'push_idx' => $push->idx,
            'marker' => $marker,
            'count' => $count,
            'latest_product_idx' => $latestProduct->idx,
            'latest_history_idx' => $latestProduct->history_idx,
            'latest_source' => $latestProduct->source,
            'latest_sold_at' => $latestProduct->sold_at,
            'attachment_idx' => $attachmentIdx,
            'link' => $productLink,
            'start_at' => $startAt->format('Y-m-d H:i:s'),
            'end_at' => $endAt->format('Y-m-d H:i:s'),
        ]);

        $this->info('신상품 푸시 큐를 생성했습니다. push_idx=' . $push->idx . ', marker=' . $marker);
        return 0;
    }

    /**
     * @param int $productIdx
     * @return string
     */
    private function productDetailLink($productIdx)
    {
        return rtrim((string) config('app.url'), '/') . config('constants.POPUP.TYPE.PRODUCT', '/product/detail/') . $productIdx . '?pushBackHome=Y';
    }

    /**
     * @return \Carbon\Carbon
     * @throws \Exception
     */
    private function resolveBaseDate()
    {
        $date = $this->option('date');

        if ($date === null || $date === '') {
            return Carbon::now(self::TIMEZONE)->startOfDay();
        }

        $baseDate = Carbon::createFromFormat('Y-m-d', $date, self::TIMEZONE);

        if ($baseDate === false || $baseDate->format('Y-m-d') !== $date) {
            throw new \Exception('--date 옵션은 YYYY-MM-DD 형식이어야 합니다.');
        }

        return $baseDate->startOfDay();
    }

    /**
     * @param string $marker
     * @return bool
     */
    private function alreadyQueued($marker)
    {
        return PushQ::where('is_delete', 0)
            ->where('push_info', $marker)
            ->exists();
    }

    /**
     * @param \Carbon\Carbon $startAt
     * @param \Carbon\Carbon $endAt
     * @return \Illuminate\Database\Query\Builder
     */
    private function newProductQuery(Carbon $startAt, Carbon $endAt)
    {
        $startAt = $startAt->format('Y-m-d H:i:s');
        $endAt = $endAt->format('Y-m-d H:i:s');

        $stateChangedProducts = DB::table('AF_product_state_history as h')
            ->join('AF_product as p', 'p.idx', '=', 'h.product_idx')
            ->join('AF_admin as a', 'a.idx', '=', 'h.admin_idx')
            ->select(
                'p.idx',
                'p.attachment_idx',
                'h.idx as history_idx',
                'h.register_time as sold_at',
                DB::raw("'state_history' as source"),
                'h.idx as sort_idx'
            )
            ->where('h.type', 'S')
            ->where('p.is_new_product', 1)
            ->whereIn('p.state', ['S', 'O'])
            ->whereNull('p.deleted_at')
            ->where('h.register_time', '>=', $startAt)
            ->where('h.register_time', '<', $endAt);

        $initialSellingProducts = DB::table('AF_product as p')
            ->select(
                'p.idx',
                'p.attachment_idx',
                DB::raw('NULL as history_idx'),
                'p.register_time as sold_at',
                DB::raw("'product_register' as source"),
                'p.idx as sort_idx'
            )
            ->where('p.is_new_product', 1)
            ->whereIn('p.state', ['S', 'O'])
            ->whereNull('p.deleted_at')
            ->where('p.register_time', '>=', $startAt)
            ->where('p.register_time', '<', $endAt)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('AF_product_state_history as h')
                    ->whereColumn('h.product_idx', 'p.idx')
                    ->where('h.type', 'S');
            });

        return $stateChangedProducts->unionAll($initialSellingProducts);
    }

    /**
     * @param string|null $attachmentIdxes
     * @return int
     */
    private function representativeAttachmentIdx($attachmentIdxes)
    {
        if ($attachmentIdxes === null || trim($attachmentIdxes) === '') {
            return 0;
        }

        $attachmentIdxes = explode(',', $attachmentIdxes);

        foreach ($attachmentIdxes as $attachmentIdx) {
            $attachmentIdx = trim($attachmentIdx);
            if ($attachmentIdx !== '' && ctype_digit($attachmentIdx) && (int) $attachmentIdx > 0) {
                return (int) $attachmentIdx;
            }
        }

        return 0;
    }

    /**
     * @param string|null $text
     * @param int $limit
     * @return string
     */
    private function limitText($text, $limit)
    {
        $text = trim((string) $text);

        if ($text === '') {
            return '신상품';
        }

        if (function_exists('mb_strlen') && function_exists('mb_substr')) {
            return mb_strlen($text, 'UTF-8') > $limit
                ? mb_substr($text, 0, $limit, 'UTF-8') . '...'
                : $text;
        }

        return strlen($text) > $limit
            ? substr($text, 0, $limit) . '...'
            : $text;
    }
}
