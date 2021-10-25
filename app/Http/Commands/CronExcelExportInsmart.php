<?php
/**
 * QuynhTM
 */

namespace App\Http\Commands;

use App\Models\Report\VouchersReport;
use App\Services\ActionExcel;
use App\Services\SendMailService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;


class CronExcelExportInsmart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:CronExcelExportInsmart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob export excel cho Insmart';

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
        $this->modelObj = new VouchersReport();
        $page_no = STATUS_INT_KHONG;
        $dataList = [];

        $search['page_no'] = $page_no;
        $search['p_from_date'] = date('d/m/Y',strtotime(\Carbon\Carbon::yesterday()));
        $search['p_to_date'] = date('d/m/Y',strtotime(Carbon::now()));

        $result = $this->modelObj->searchInsmart($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['data'] ?? [];
        }
        if(!empty($dataList)){
            $this->actionExcel = new ActionExcel();
            $fileName = 'HDI_POLICY_DATA_'.date('d_m_Y');
            $dataOther['fileName'] = $fileName;
            $this->actionExcel->exportExcel($dataList,ActionExcel::EXPORT_EXCEL_INSMART,$dataOther);

            $path_folder_upload = Config::get('config.DIR_ROOT');
            $url_file = $path_folder_upload.'/'.$fileName.'.xlsx';

            //$dataSend['email_receive'] = 'quynhtm@hdinsurance.com.vn';
            $dataSend['email_receive'] = 'quanlyhopdong@insmart.com.vn';
            $dataSend['name'] = 'Quản lý hợp đồng HĐI';
            $dataSend['file_attack'] = $url_file;
            if(app(SendMailService::class)->sentMailExcelInsmart($dataSend)){
                $arrData['isOk'] = STATUS_INT_MOT;
                $arrData['msg'] = 'Đã gửi mail thành công';
            }else{
                $arrData['msg'] = 'Chưa gửi được mail';
            }
            myDebug($url_file,false);
        }
        myDebug($dataList);
    }
}

?>
