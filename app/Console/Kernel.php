<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\PushQ;

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
                    
                    $data = [
                        "notification" => [
                            "title" => $pushq->title,
                            "body"  => $pushq->content,
                            "content"  => $pushq->content
                        ],
                        "priority" =>  "high",
                        "data" => [
                            "scheme" => $pushq->app_link,
                            "weburl" => $pushq->web_link,
                            "title"  => $pushq->title,
                            "body"  => $pushq->content,
                            "content" => $pushq->content
                        ],
                        "to" => $authToken->token
                    ];
                
                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_POST, 1);
                
                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: key=AAAAz0KBYaw:APA91bHlCV092apNbyHu8u6cM23naPxem-Olb3HFNWGlTYCzMMvYD0qwbXFrytIRmd0h0A1GqjjDm3W4HiCTAkfpbSiz0w2qRuOo7GRV2gbajsBIn67W7_h0w0R8FR7MeHSNJ-t4Au4a';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                    $result = curl_exec($ch);
                    curl_close ($ch);
                }
            }
        })->cron('* * * * *');
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
