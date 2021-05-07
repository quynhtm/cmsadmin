<?php

namespace App\Http\Controllers;

use App\Http\Models\Report\VouchersReport;
use App\Services\ActionExcel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class MailSendController extends Controller
{
    public function sentEmailInsmart(){
        die('Hiện không có dữ liệu để xuất file excel');
        $this->modelObj = new VouchersReport();
        $page_no = STATUS_INT_KHONG;
        $dataList = [];

        $search['page_no'] = $page_no;
        $search['p_from_date'] = date('d/m/Y',strtotime(Carbon::yesterday()));
        $search['p_to_date'] = date('d/m/Y',strtotime(Carbon::now()));

        $result = $this->modelObj->searchInsmart($search);
        if ($result['Success'] == STATUS_INT_MOT) {
            $dataList = $result['data'] ?? [];
        }
        if(!empty($dataList)){
            $this->actionExcel = new ActionExcel();
            $this->actionExcel->exportExcel($dataList,ActionExcel::EXPORT_EXCEL_INSMART,[]);
        }
        die('Hiện không có dữ liệu để xuất file excel');
    }

    public function sentEmail(){
        $email = 'quynhtm@peacesoft.net';
        $name = 'Quynhtesst';
        $password_new = 'passs';
        $subject ='xem gui dc chua';
        $abc = Mail::send('mail.mailForgotPassword', ['name' => $name, 'password_new' => trim($password_new)],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(env('MAIL_USERNAME','manhquynh1984@gmail.com'), $subject);
                $mail->to($email, $name);
                $mail->subject($subject.' '.getCurrentDateTime());
            });
        vmDebug($abc);

        /*$abc = Mail::to('quynhtm@peacesoft.net')->send(new MailSystem());
        vmDebug($abc);*/
    }
}
