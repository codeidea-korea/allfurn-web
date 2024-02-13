<?php

namespace App\Http\Controllers;

use App\Service\MagazineService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MagazineController extends BaseController
{
    private $magazineService;
    private $limit = 16;
    public function __construct(MagazineService $magazineService)
    {
        $this->magazineService = $magazineService;
    }

    public function index(Request $request)
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['banners'] = $this->magazineService->banners();
        $data = array_merge($data, $this->magazineService->list($params));
        return view('magazine.list', $data);
    }

    public function detail(int $idx)
    {
        $data['detail'] = $this->magazineService->detail($idx);
        return view('magazine.detail', $data);
    }
}
