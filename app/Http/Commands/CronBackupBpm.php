<?php
/**
 * QuynhTM
 */

namespace App\Http\Commands;

use App\Services\ServiceCurl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;


class CronBackupBpm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:CronBackupBpm';

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
        $serviceCurl = new ServiceCurl();
        //get token
        $url_token = 'http://dev-bpm.mcredit.com.vn/workflow/oauth2/token';
        $token = $serviceCurl->getTokenBpm($url_token, 'JTBHJHSTKFRZHXASCBXRCHEJCEDPVHOF', '6267128015cd14e3cac5ce6092742384', 'userBackup', 'userBackup@1234');

        $arrBpm = [
            '46997778359b23c7d855ce6051135589' => 'ConcentratingDataEntry',   //tiền mặt
            '92489624057e0e0abafb278083044537' => 'InstallmentLoan'           //trả góp
        ];
        foreach ($arrBpm as $keyId => $nameBpm) {
            //lấy nội dung export
            $url_export = 'http://dev-bpm.mcredit.com.vn/api/1.0/workflow/project/' . $keyId . '/export';
            $headers = [
                "Content-Type: application/x-www-form-urlencoded",
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
            ];
            $xmlString = $serviceCurl->getApi($url_export, [], $token, $headers);
            if (!empty($xmlString)) {
                $path_folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . env('APP_PATH_UPLOAD_MIDDLE', 'backupBpm') : Config::get('config.DIR_ROOT') . env('APP_PATH_UPLOAD_MIDDLE', 'backupBpm');
                $dirFile = $nameBpm . date('m-Y', time());
                $nameFile = 'backup' . $nameBpm . getParamDate('d') . '.xml';
                $folder_upload = $path_folder_upload . '/backupBpm/' . $dirFile . '/';
                if (!is_dir($folder_upload)) {
                    @mkdir($folder_upload, 0777, true);
                    chmod($folder_upload, 0777);
                }
                $dom = new \DOMDocument();
                $dom->preserveWhiteSpace = FALSE;
                $dom->loadXML($xmlString);
                $dom->save($folder_upload . $nameFile);
                echo('Đã backup xong ' . $nameBpm . ' <br/>');
            }
        }
        $serviceCurl->closeConnect();
        die('done');
    }
}

?>