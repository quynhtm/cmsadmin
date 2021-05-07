<?php
/**
 * QuynhTM
 */

namespace App\Http\Commands;

use App\Http\Models\SalesNetwork\SaleStaff;
use App\Http\Models\SalesNetwork\SaleStaffPositionHistory;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\DB;

class CronUpdateDeactiveDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:CronUpdateDeactiveDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob cập nhật Deactive chuyển batch, chức vụ';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function set($key, $value, $default = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        } else {
            $this->$key = $default;
        }
    }

    public function get($key, $default = null)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        } else {
            return $default;
        }
    }

    public function handle()
    {
        $data = ['chua co gi'];
        $name_file_log = 'log_cronjob.log';
        $name_folder = 'cronjobLog';
        debugLog($data,$name_file_log,$name_folder);
        endLog($name_file_log,$name_folder);
        die('Không có user VH online');
    }
}

?>