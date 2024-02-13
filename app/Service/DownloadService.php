<?php


namespace App\Service;


use App\Models\Attachment;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class DownloadService
{
    /**
     * 명함 이미지 파일 url, 이미지 파일명 가져오기
     * @param $idx
     * @return array
     */
    public function nameCard($idx): array
    {
        $attachment = Attachment::find($idx);
        $url = $attachment->folder . '/' . $attachment->filename;
        return ['url' => $url, 'filename' => $attachment->filename];
    }

    /**
     * 이미지 다운로드
     * @param $url
     * @return string
     * @throws FileNotFoundException
     */
    public function image($url): string
    {
        return Storage::disk('s3')->get($url);
    }
}
