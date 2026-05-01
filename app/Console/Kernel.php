<?php

namespace App\Console;

use App\Models\ApiLogs;
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
        Commands\Queue::class, 
        Commands\UpdateTransactions::class, 
        Commands\UpdateCards::class, 
        Commands\UpdateAirtimeOperators::class, 
        Commands\UpdateDataOperators::class, 
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:queue')->everyFiveMinutes();
        $schedule->command('update:transactions')->everyTenMinutes();
        $schedule->command('update:cards')->everyThreeMinutes();
        $schedule->command('update:airtime:operators')->everyThreeMinutes();
        $schedule->command('update:data:operators')->everyThreeMinutes();
        $schedule->call(fn () => ApiLogs::where('created_at', '<', now()->subDays(90))->delete())
            ->daily();
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
