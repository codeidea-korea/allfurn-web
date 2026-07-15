<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\PushQ;
use App\Models\PushToken;
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
        $schedule->command('reset:aicount')
                 ->timezone('Asia/Seoul')
                 ->dailyAt('24:00');
        
        $schedule->command('ai:clean-temp')
                 ->timezone('Asia/Seoul')
                 ->dailyAt('24:00');

        $schedule->command('push:daily-new-products')
                 ->timezone('Asia/Seoul')
                 ->dailyAt('17:00')
                 ->withoutOverlapping();

        $schedule->command('home:warm-cache')
                 ->timezone('Asia/Seoul')
                 ->cron('*/4 * * * *')
                 ->withoutOverlapping(10);
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
