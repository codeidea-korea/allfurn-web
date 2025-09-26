<?php

namespace App\Http\Controllers;

use App\Service\HomeService;
use App\Service\ProductService;
use App\Service\WholesalerService;
use App\Service\MypageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Session;
use function Symfony\Component\Translation\t;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyAd;
use Intervention\Image\Facades\Image;

class ProductTempController extends BaseController
{
    private $productService;

    public function __construct(
        ProductService    $productService
    )
    {
        $this->productService = $productService;
    }

    /**
     * 상품 매핑 썸네일 이미지 일괄 등록
     * @param Request $request
     * @return JsonResponse
     */
    public function saveBulkProductImage(Request $request)
    {

        $data = $request->all();

        if (isset($data['files'])) {
            $attachmentIdx = '';
            $data['thumb_idx'] = array();
            foreach ($data['files'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $tmpattachmentIdx = $this->productService->saveAttachment($stored);
                    $attachmentIdx .= $tmpattachmentIdx . ',';
                    array_push($data['thumb_idx'], $tmpattachmentIdx);
                }
            }

            if (isset($data['attachmentIdx'])) {
                $data['attachmentIdx'] .= ',' . substr($attachmentIdx, 0, -1);
            } else {
                $data['attachmentIdx'] = substr($attachmentIdx, 0, -1);
            }
        }

        if (isset($data['files100'])) {
            $attachmentIdx = 0;
            foreach ($data['files100'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $attachmentIdx = $this->productService->saveAttachment($stored);
                }

                if (isset($data['thumb100_idx'])) {
                    array_push($data['thumb100_idx'], $attachmentIdx);
                } else {
                    $data['thumb100_idx'] = array();
                    array_push($data['thumb100_idx'], $attachmentIdx);
                }
            }
        }

        if (isset($data['files200'])) {
            $attachmentIdx = 0;
            foreach ($data['files200'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $attachmentIdx = $this->productService->saveAttachment($stored);
                }

                if (isset($data['thumb200_idx'])) {
                    array_push($data['thumb200_idx'], $attachmentIdx);
                } else {
                    $data['thumb200_idx'] = array();
                    array_push($data['thumb200_idx'], $attachmentIdx);
                }
            }
        }

        if (isset($data['files400'])) {
            $attachmentIdx = 0;
            foreach ($data['files400'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $attachmentIdx = $this->productService->saveAttachment($stored);
                }

                if (isset($data['thumb400_idx'])) {
                    array_push($data['thumb400_idx'], $attachmentIdx);
                } else {
                    $data['thumb400_idx'] = array();
                    array_push($data['thumb400_idx'], $attachmentIdx);
                }
            }
        }

        if (isset($data['files600'])) {
            $attachmentIdx = 0;
            foreach ($data['files600'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $attachmentIdx = $this->productService->saveAttachment($stored);
                }

                if (isset($data['thumb600_idx'])) {
                    array_push($data['thumb600_idx'], $attachmentIdx);
                } else {
                    $data['thumb600_idx'] = array();
                    array_push($data['thumb600_idx'], $attachmentIdx);
                }
            }
        }

        if (isset($data['files1000'])) {
            $attachmentIdx = 0;
            foreach ($data['files1000'] as $file) {
                if (is_file($file)) {
                    $stored = Storage::disk('vultr')->put('product', $file);
                    $attachmentIdx = $this->productService->saveAttachment($stored);
                }

                if (isset($data['thumb1000_idx'])) {
                    array_push($data['thumb1000_idx'], $attachmentIdx);
                } else {
                    $data['thumb1000_idx'] = array();
                    array_push($data['thumb1000_idx'], $attachmentIdx);
                }
            }
        }

        $this->productService->saveBulkProductImage($data);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * 상품 매핑 썸네일 이미지 일괄 등록 화면
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadview(Request $request)
    {
        $imgs = DB::select("
            select 
                t.idx,
                group_concat(t.attachment_idx) attachment_idx,
                group_concat(t.img_url separator ',') img_urls,
                group_concat(t.size_100_attach_idx) size_100_attach_idx,
                group_concat(t.size_200_attach_idx) size_200_attach_idx,
                group_concat(t.size_400_attach_idx) size_400_attach_idx,
                group_concat(t.size_600_attach_idx) size_600_attach_idx,
                group_concat(t.size_1000_attach_idx) size_1000_attach_idx
            from
            (
                select 
                    s.idx,
                    s.attachment_idx,
                    CONCAT('".preImgUrl()."', at.folder, '/', at.filename) img_url, 
                    mpg_at.size_100_attach_idx, 
                    mpg_at.size_200_attach_idx, 
                    mpg_at.size_400_attach_idx, 
                    mpg_at.size_600_attach_idx, 
                    mpg_at.size_1000_attach_idx 
                from
                (
                    select 
                        p.idx,
                        substring_index(substring_index(p.attachment_idx, ',', n.r), ',' , -1) as attachment_idx
                    from (
                        select 
                            prod.idx,
                            prod.attachment_idx
                        from AF_product prod 
                        where prod.attachment_idx is not null
                        and prod.deleted_at is null
                    ) as p join (
                        select 1 as r union all
                        select 2 union all
                        select 3 union all
                        select 4 union all
                        select 5 union all
                        select 6 union all
                        select 7 union all
                        select 8
                    ) as n on char_length(p.attachment_idx) - char_length(replace(p.attachment_idx, ',', '')) >= n.r - 1
                ) as s
                join AF_attachment at on s.attachment_idx = at.idx 
                left join AF_mapping_thumb_attachment mpg_at on mpg_at.main_attach_idx = at.idx 
            ) as t
            group by t.idx
            ");
            
            $cnt = count($imgs);

            for($i = 0; $i < $cnt; $i++) {
                echo "<script>fileUrls.push({idx:[".$imgs[$i]->attachment_idx."], prod_idx: ".$imgs[$i]->idx." ,url:[".$imgs[$i]->img_urls."]});</script>";

                $baseAttachmentIdxes = explode(',', $imgs[$i]->attachment_idx);
                $prodIdx = $imgs[$i]->idx;
                $urls = explode(',', $imgs[$i]->img_urls);
                $basePath = 'app/public/';

                $data = array();
                $data['prod_idx'] = $prodIdx;
                $data['thumb_idx'] = array();
                $data['thumb100_idx'] = array();
                $data['thumb200_idx'] = array();
                $data['thumb400_idx'] = array();
                $data['thumb600_idx'] = array();
                $data['thumb1000_idx'] = array();

                for($j = 0; $j < count($urls); $j++) {
                    $data['file_idx'] = $baseAttachmentIdxes[$j];
                    $imageUrl = $urls[$j];
                    $imageData = file_get_contents($imageUrl);

                    $tempFile = 'temp_image_'.$i.'_'.$j.'.jpg';
                    $tempPath = storage_path($basePath . $tempFile);
                    file_put_contents($tempPath, $imageData);

                    $thumbnail100nm = 'thumbnail1_'.$i.'_'.$j.'.jpg';
                    $thumbnailPath100 = storage_path($basePath . $thumbnail100nm);
                    $thumbnail100 = Image::make($tempPath)->resize(100, 100)->encode('jpeg');
                    if (is_file($thumbnail100)) {
                        $stored = Storage::disk('vultr')->put('product', $thumbnail100);
                        $attachmentIdx = $this->productService->saveAttachment($stored);
                        array_push($data['thumb_idx'], $attachmentIdx);
                        array_push($data['thumb100_idx'], $attachmentIdx);
                        if (isset($data['attachmentIdx'])) {
                            $data['attachmentIdx'] .= ',' . $data['file_idx'];
                        } else {
                            $data['attachmentIdx'] = $data['file_idx'];
                        }
                    }

                    $thumbnail200nm = 'thumbnail2_'.$i.'_'.$j.'.jpg';
                    $thumbnailPath200 = storage_path($basePath . $thumbnail200nm);
                    $thumbnail200 = Image::make($tempPath)->resize(200, 200)->encode('jpeg');
                    if (is_file($thumbnail200)) {
                        $stored = Storage::disk('vultr')->put('product', $thumbnail200);
                        $attachmentIdx = $this->productService->saveAttachment($stored);
                        array_push($data['thumb200_idx'], $attachmentIdx);
                    }

                    $thumbnail400nm = 'thumbnail4_'.$i.'_'.$j.'.jpg';
                    $thumbnailPath400 = storage_path($basePath . $thumbnail400nm);
                    $thumbnail400 = Image::make($tempPath)->resize(400, 400)->encode('jpeg');
                    if (is_file($thumbnail400)) {
                        $stored = Storage::disk('vultr')->put('product', $thumbnail400);
                        $attachmentIdx = $this->productService->saveAttachment($stored);
                        array_push($data['thumb400_idx'], $attachmentIdx);
                    }

                    $thumbnail600nm = 'thumbnail6_'.$i.'_'.$j.'.jpg';
                    $thumbnailPath600 = storage_path($basePath . $thumbnail600nm);
                    $thumbnail600 = Image::make($tempPath)->resize(600, 600)->encode('jpeg');
                    if (is_file($thumbnail600)) {
                        $stored = Storage::disk('vultr')->put('product', $thumbnail600);
                        $attachmentIdx = $this->productService->saveAttachment($stored);
                        array_push($data['thumb600_idx'], $attachmentIdx);
                    }

                    $thumbnail1000nm = 'thumbnail10_'.$i.'_'.$j.'.jpg';
                    $thumbnailPath1000 = storage_path($basePath . $thumbnail1000nm);
                    $thumbnail1000 = Image::make($tempPath)->resize(1000, 1000)->encode('jpeg');
                    if (is_file($thumbnail1000)) {
                        $stored = Storage::disk('vultr')->put('product', $thumbnail1000);
                        $attachmentIdx = $this->productService->saveAttachment($stored);
                        array_push($data['thumb1000_idx'], $attachmentIdx);
                    }

                    // 임시 파일 삭제
                    unlink($tempPath);
                }

                $this->productService->saveBulkProductImage($data);
            }
    }
    
}
?>
