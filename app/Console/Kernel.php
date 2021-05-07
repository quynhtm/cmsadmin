<?php

namespace App\Console;

use App\Http\Commands\CronBackupBpm;
use App\Http\Commands\CronExcelExportInsmart;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *      nano crontab -e
     *      * * * * * php /var/www/html/new_sales_network/artisan schedule:run 2>&1 >> /var/www/html/new_sales_network/storage/logs/cronjob.log
     *      * * * * * php /opt/hdi_source/php/hdi-system-live/artisan schedule:run 2>&1 >> /opt/hdi_source/php/hdi-system-live/storage/logs/cronjob.log
     * @var array
     */
    protected $commands = [
        CronBackupBpm::class,
        CronExcelExportInsmart::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   if(Config::get('config.IS_SCHEDULE')){
            $schedule->command('cronjob:CronExcelExportInsmart')->dailyAt('08:45')->withoutOverlapping();

            //$schedule->command('cronjob:CronBackupBpm')->dailyAt('02:00')->withoutOverlapping();
            //$schedule->command('cronjob:CronExcelExportInsmart')->everyFiveMinutes()->withoutOverlapping();
            //$schedule->command('cronjob:CronSaleNetworkUpsetNetworkT24')->everyFifteenMinutes()->withoutOverlapping();
        }
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
