<?php

namespace App\Http\Controllers;

use App\Service\DownloadService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Controller as BaseController;

class DownloadController extends BaseController
{
    private $downloadService;
    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    public function downloadNameCard($idx)
    {
        $nameCard = $this->downloadService->nameCard($idx);
        $headers = [
            'Content-Type'        => 'application/jpg',
            'Content-Disposition' => 'attachment; filename="'. $nameCard['filename'] .'"',
        ];
        try {
            return response()->make($this->downloadService->image($nameCard['url']), 200, $headers);
        } catch (BindingResolutionException | FileNotFoundException $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

}
