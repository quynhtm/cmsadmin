<?php
/**
 * Created by PhpStorm.
 * User: Quynhtm
 * Date: 29/05/2015
 * Time: 8:24 CH
 */

namespace App\Http\Controllers\BackendCms;

use App\Http\Controllers\BaseAdminController;
use App\Library\AdminFunction\CGlobal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class BackendDashBoardController extends BaseAdminController
{
    public $dataOut = [];
    public $template = 'index';

    public function __construct()
    {
        parent::__construct();
        /*FunctionLib::link_js(array(
            'HDInsurance/admin/lib/highcharts/highcharts.js',
            'HDInsurance/admin/lib/highcharts/highcharts-3d.js',
            'HDInsurance/admin/lib/highcharts/exporting.js',
        ));*/
    }

    public function dashboard()
    {   //thuộc báo cáo
        //$this->tab_top = 4;//test
        //myDebug($this->testData());
        switch ($this->tab_top) {
            case CGlobal::dms_portal:
                $this->dashboardSystem();
                break;
            case CGlobal::selling:
                $this->dashboardSelling();
                break;
            default:
                $this->template = 'index_default';
                $today = Carbon::now();
                $weekDay = getWeekDay($today);
                $this->dataOut = [
                    'weekDay' => $weekDay,
                    'today' => date('d-m-Y'),
                ];
                break;
        }

        return view('BackendCms.DashBoard.' . $this->template, array_merge([
            'title_dashboard' => CGlobal::web_title_dashboard,
            'lang' => $this->languageSite,
        ], $this->dataOut));
    }

    private function dashboardSystem()
    {
        $this->template = 'index_system';
        $today = Carbon::now();
        $weekDay = getWeekDay($today);
        $this->dataOut = [
            'weekDay' => $weekDay,
            'today' => date('d-m-Y'),
        ];
    }

    private function dashboardSelling()
    {
        $this->template = 'index_selling';
        $today = Carbon::now();
        $weekDay = getWeekDay($today);
        $this->dataOut = [
            'weekDay' => $weekDay,
            'today' => date('d-m-Y'),
        ];
    }
}
