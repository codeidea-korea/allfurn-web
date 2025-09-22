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

        $this->productService->saveBulkProductImage($data, $request->input('file_idx'));

        return response()->json([
            'success' => true : false,
        ]);
    }
}
?>
