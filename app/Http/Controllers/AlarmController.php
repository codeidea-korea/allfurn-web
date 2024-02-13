<?php

namespace App\Http\Controllers;

use App\Service\AlarmService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class AlarmController extends BaseController
{
    private $alarmService;
    private $limit = 20;

    public function __construct(AlarmService $alarmService)
    {
        $this->alarmService = $alarmService;
    }

    /**
     * 알람 리스트
     * @param Request $request
     * @param string|null $type
     * @return View
     */
    public function index(Request $request, string $type = null): View
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['type'] = $params['type'] = $type;
        $data = array_merge($data, $this->alarmService->getList($params));
        return view('alarm.index', $data);
    }


    /**
     * 알람 보내기
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        return response()->json($this->alarmService->sendAlarm($request->all()));
    }

}
