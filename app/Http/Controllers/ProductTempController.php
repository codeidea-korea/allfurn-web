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
                CONCAT('\"', group_concat(t.img_url separator '\",\"'), '\"') img_urls,
                group_concat(t.size_100_attach_idx) size_100_attach_idx,
            --    group_concat(t.size_200_attach_idx) size_200_attach_idx,
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
                --  mpg_at.size_200_attach_idx, 
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
            echo '<script src="/js/jquery-1.12.4.js"></script>';
            echo "
                <script>
                    
                    var storedIdx = [];
                    var storedFiles = [];
                    var stored100Files = [];
                    var stored400Files = [];
                    var stored600Files = [];
                    var stored1000Files = [];
                    const fileUrls = [];
                    var fileUrl;
            
                    function clearStored(){
                        storedIdx = [];
                        storedFiles = [];
                        stored100Files = [];
                        stored400Files = [];
                        stored600Files = [];
                        stored1000Files = [];
                    }
                    function saveImage(url) {
                        var readImg = FileReader.readAsDataURL(url);
                        readImg.onload = (function(file) {
                            return function(e) {
                                var image = new Image;
                                image.onload = function() {
                                    file = getThumbFile(image, 500, this.width, this.height);
                                    storedFiles.push(file);
                                };
                                image.src = e.target.result;
            
                                var image100 = new Image;
                                image100.width = 100;
                                image100.height = 100;
                                image100.onload = function() {
                                    const i100 = getThumbFile(image100, 100, this.width, this.height);
                                    stored100Files.push(i100);
                                };
                                image100.src = e.target.result;
            
                                var image400 = new Image;
                                image400.width = 400;
                                image400.height = 400;
                                image400.onload = function() {
                                    const i400 = getThumbFile(image400, 400, this.width, this.height);
                                    stored400Files.push(i400);
                                };
                                image400.src = e.target.result;
            
                                var image600 = new Image;
                                image600.width = 600;
                                image600.height = 600;
                                image600.onload = function() {
                                    const i600 = getThumbFile(image600, 600, this.width, this.height);
                                    stored600Files.push(i600);
                                };
                                image600.src = e.target.result;
            
                                var image1000 = new Image;
                                image1000.width = 1000;
                                image1000.height = 1000;
                                image1000.onload = function() {
                                    const i1000 = getThumbFile(image1000, 1000, this.width, this.height);
                                    stored1000Files.push(i1000);
                                };
                                image1000.src = e.target.result;

                                storedIdx.push(url);
                                if(storedIdx.length < fileUrl.url.length) {
                                    saveImage(fileUrl.url[storedIdx.length]);
                                } else {
                                    saveFiles();
                                }
                            };
                        })(url);
                        readImg.readAsDataURL(url);
                    }
                    function saveFiles(){
                        // submit
                        const form = new FormData();
                        form.append('file_idx', fileUrl.idx);
                        form.append('prod_idx', fileUrl.prod_idx);
                        form.append('files100[]', stored100Files[i]);
                        form.append('files200[]', stored200Files[i]);
                        form.append('files400[]', stored400Files[i]);
                        form.append('files600[]', stored600Files[i]);
                        form.append('files1000[]', stored1000Files[i]);
    
                        $.ajax({
                            url             : '/product-temp/bulk/thumbnail',
                            enctype         : 'multipart/form-data',
                            processData     : false,
                            contentType     : false,
                            data			: form,
                            type			: 'POST',
                            success: function (result) {
                                clearStored();
                                fileUrl = fileUrls.pop();
                                saveImage(fileUrl.url[storedIdx.length]);
                            }, error: function (e) {
                                clearStored();
                                fileUrl = fileUrls.pop();
                                saveImage(fileUrl.url[storedIdx.length]);
                            }
                        });
                    }
                </script>
                ";
            
            for($i = 0; $i < $cnt; $i++) {
                echo "<script>fileUrls.push({idx:[".$imgs[$i]->attachment_idx."], prod_idx: ".$imgs[$i]->idx." ,url:[".$imgs[$i]->img_url."]});</script>";
            }
    }
    
}
?>
