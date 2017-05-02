<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\RegenerateFrequencies::class,
        Commands\CheckGameSessions::class,
        Commands\UpdateGameSession::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('frequencies:regenerate')->cron('0 4-22/6 * * *');

        $schedule->command('gamesessions:check')->everyFiveMinutes();

        // En cada reinicio hacer nuevas sesiones
        $schedule->command('gamesessions:update 04')->dailyAt('03:55');
        $schedule->command('gamesessions:update 10')->dailyAt('09:55');
        $schedule->command('gamesessions:update 16')->dailyAt('15:55');
        $schedule->command('gamesessions:update 22')->dailyAt('21:55');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
