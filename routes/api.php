<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('rooms')->group(function() {
    // NOTICE: rooms 목록 조회
    Route::get('/', [MessageController::class, 'getRooms']);
    // NOTICE: room 채팅 내용 조회
    Route::get('/{idx}', [MessageController::class, 'getRoomByIdx']);

    // NOTICE: 존재하는 room 에 채팅 발송
    Route::post('/{idx}/send', [MessageController::class, 'sendMessage']);

    // NOTICE: room 신고 처리
    Route::post('/{idx}/report', [MessageController::class, 'reportRoom']);
    // NOTICE: room 알림 설정 토글 (push 설정 여부)
    Route::post('/{idx}/config/notification', [MessageController::class, 'toggleNotificationConfig']);
}
