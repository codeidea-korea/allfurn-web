<?php


namespace App\Service;


use App\Models\Attachment;
use App\Models\Push;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlarmService
{
    private $prevContent = "";
    
    
    /**
     * 알람 리스트 가져오기
     * @param array $params
     * @return array
     * 쿼리 실행 속도 개선 : 백업 테이블 생성 1달(매월 1일기준) 백업 이벤트 진행
     *                  최근 3개월 데이터만 남기고 나머진 백업 테이블로 이동
     *                  관련 프로시저, 이벤트 명
     *                  procedure : notification_backup
     *                  event : notificaton_backup_and_delete_event
     */
    public function getList(array $params): array {

        /*DB::listen(function ($query) {
            dd("Query executed in {$query->time}ms: {$query->sql}");
        });*/

        //DB::enableQueryLog();
        $offset = isset($params['offset']) && $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $logs = Push::select('AF_notification.*'
                , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS log_image')
                , DB::raw("CASE WHEN TIMESTAMPDIFF(SECOND ,AF_notification.send_date, now()) < 86400 THEN DATE_FORMAT(AF_notification.send_date, '%H:%i')
                   WHEN TIMESTAMPDIFF(SECOND ,AF_notification.send_date, now()) < 259200 THEN '어제'
                   ELSE DATE_FORMAT(AF_notification.send_date, '%m월 %d일')
                END send_date")
            )
            ->leftJoin('AF_attachment', 'AF_attachment.idx', 'AF_notification.attachment_idx');
        $logs->where('AF_notification.target_company_type', Auth::user()['type']);
        $logs->where('AF_notification.target_company_idx', Auth::user()['company_idx']);
        
        if (isset($params['type'])) {
            switch($params['type']) {
                case 'order':
                    $logs->where('AF_notification.type', 'order');
                    break;
                case 'active':
                    $logs->where('AF_notification.type', 'active');
                    break;
                case 'news':
                    $logs->whereIn('AF_notification.type', ['event','normal','notice','ad']);
                    break;
            }
        }

        
        /*$query = "";
        if (isset($params['type'])) {
            switch($params['type']) {
                case 'order':
                    $query = 'AND type = "order"';
                    break;
                case 'active':
                    $query = 'AND type = "active"';
                    break;
                case 'news':
                    $query = 'AND type IN ("event", "normal", "notice", "ad")';
                    break;
            }
        }


        $logs = DB::table(DB::raw('
                (
                    SELECT * FROM AF_notification
                    WHERE target_company_type = "'. Auth::user()['type'] .'" 
                    AND target_company_idx = "'. Auth::user()['company_idx'] .'"
                    '. $query .'
                ) AS AF_notification'
            ))
            ->leftJoin('AF_attachment', 'AF_attachment.idx', 'AF_notification.attachment_idx')
            ->select('AF_notification.*'
                , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS log_image')
                , DB::raw("CASE WHEN TIMESTAMPDIFF(SECOND ,AF_notification.send_date, now()) < 86400 THEN DATE_FORMAT(AF_notification.send_date, '%H:%i')
                    WHEN TIMESTAMPDIFF(SECOND ,AF_notification.send_date, now()) < 259200 THEN '어제'
                    ELSE DATE_FORMAT(AF_notification.send_date, '%m월 %d일')
                END send_date")
            );*/


        $data['count'] = $logs->count();
        $data['list'] = $logs->orderBy('AF_notification.idx', 'desc')->offset($offset)->limit($limit)->get();
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        
        //dd(DB::getQueryLog());

        Push::where([
            'target_company_type' => Auth::user()['type'],
            'target_company_idx' => Auth::user()['company_idx']
            ])
            ->update(['is_alert' => 0]);

        return $data;

    }

    public function sendAlarm($params)
    {
        $depth1 = strtoupper($params['depth1']);
        $depth2 = strtoupper($params['depth2']);
        $depth3 = strtoupper($params['depth3']);

        $attachment_idx = null;
        if (isset($_FILES) && !empty($_FILES['name'])) {
            $path = 'alarm';
            $attachment_idx = $this->uploadImage($_FILES, $path);
        }

        $content = "";
        if (!empty(config("constants.ALARM.{$depth1}.{$depth2}.{$depth3}.CONTENT"))) {
            $constantsContent = config("constants.ALARM.{$depth1}.{$depth2}.{$depth3}.CONTENT");
            if (isset($params['variables']) && !empty($params['variables'])) {
                $count = count($params['variables']);
                for($i = 0; $i < $count; $i++) {
                    $content .= str_replace('{VAR'.($i+1).'}', $params['variables'][$i], $constantsContent);
                }
            } else {
                $content = $constantsContent;
            }
        } else {
            $content = isset($params['content']) ? $params['content'] : $this->prevContent;
        }
        $this->prevContent = $content;

        $push = new Push;
        $push->type = $params['depth1'];
        $push->title = config("constants.ALARM.{$depth1}.{$depth2}.{$depth3}.TITLE");
        $push->content = $content;
        $push->attachment_idx = $attachment_idx;
        $push->target_company_type = $params['target_company_type'];
        $push->target_company_idx = $params['target_company_idx'];
        $push->send_date = Carbon::now()->format('Y-m-d H:i:s');
        $push->link_url = $params['link_url'];
        $push->web_url = $params['web_url'];
        $push->save();
    }

    public function uploadImage($image, $path)
    {
        $stored = Storage::disk('vultr')->put($path, $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        $attach = new Attachment();
        $attach->folder = $path;
        $attach->filename = $fileName;
        $attach->save();
        return $attach->idx;
    }
}
