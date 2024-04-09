<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\PushQ;
use App\Models\AuthToken;
use Google\Client as Google_Client;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // NOTICE: 푸시 스케쥴링
        $schedule->call(function () {
             
            if(!in_array(date('s'), ['10', '20', '30', '40', '50', '0', '00'])) {
                return;
            }
            // pending push
            $pushQueue = PushQ::where('send_type', '=', 'P')->get();
            
            foreach($pushQueue as $pushq) {
                $pushq->send_date = date('Y-m-d H:i:s');
                $pushq->send_type = 'S';
                $pushq->save();

                $targets = explode(',', $pushq->send_target);
                for($idx = 0; $idx < count($targets); $idx++) {
                    $userIdx = $targets[$idx];
                    if(empty($userIdx)) {
                        continue;
                    }
                    $authToken = AuthToken::where('user_idx', '=', $userIdx)->orderBy('register_time', 'DESC')->first();

                    if(empty($authToken)) {
                        continue;
                    }
                    
                    $scope = 'https://www.googleapis.com/auth/firebase.messaging';

                    $client = new Google_Client();
                    $client->setAuthConfig('/var/www/allfurn-web/fcm.json');
                    $client->setScopes($scope);
                    $auth_key = $client->fetchAccessTokenWithAssertion();

                    $data = [
                        "message" => [
                            "token" => $authToken->token,
                            "notification"=> [
                                "title"=> $pushq->title,
                                "body"=> $pushq->content
                            ],
                            "data"=> [
                                "scheme" => $pushq->app_link,
                                "weburl" => $pushq->web_link,
                                "title"  => $pushq->title,
                                "body"  => $pushq->content,
                                "content" => $pushq->content
                            ],
                            "android"=> [
                                "notification"=> [
                                    "click_action"=> "TOP_STORY_ACTIVITY"
                                ]
                            ],
                            "apns"=> [
                                "payload"=> [
                                    "aps"=> [
                                        "category" => "NEW_MESSAGE_CATEGORY"
                                    ]
                                ]
                            ]
                        ]
                    ];
                
                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/allfurn-e0712/messages:send');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_POST, 1);
                
                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: Bearer ' . $auth_key['access_token'];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                    $result = curl_exec($ch);
                    
                    $sendLog = new PushSendLog();
                    $sendLog->user_idx = $userIdx;
                    $sendLog->push_idx = $pushMessage->idx;
                    $sendLog->push_type = $pushMessage->type;
                    $sendLog->is_send = 1;
                    $sendLog->is_check = 0;
                    $sendLog->send_date = date('Y-m-d H:i:s');
                    $sendLog->response = $result;
                    $sendLog->save();

                    curl_close ($ch);
                }
            }
        })->cron('* * * * *')->appendOutputTo('/var/www/allfurn-web/logs/batch.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
