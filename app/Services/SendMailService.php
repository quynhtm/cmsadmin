<?php
namespace App\Services;

use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

/**
 * QuynhTM
 * Class SendMailService
 * @package App\Services
 * Các function liên quan đến gửi mail
 */
class SendMailService
{
    protected $EMAIL_SEND = '';
    public function __construct(){
        $this->EMAIL_SEND = Config::get('config.MAIL_USERNAME');
    }

    public function sentMailExcelInsmart($dataSend = []){
        $subject = 'Danh sách cấp đơn HDI';
        if(!empty($dataSend) && isset($dataSend['email_receive']) && trim($dataSend['email_receive']) != ''){
            $email = $dataSend['email_receive'];
            $name = $dataSend['name'];
            $file_attack = $dataSend['file_attack'];
            $linkDowloadFile = URL::route('hdi.sentEmailInsmart');

            Mail::send('mail.mailSendExcelInsmart', ['name' => $name, 'linkDowloadFile' => trim($linkDowloadFile)],
                function ($mail) use ($email, $name,$file_attack, $subject) {
                    $mail->from($this->EMAIL_SEND, $subject);
                    $mail->to($email, $name);
                    $mail->attach($file_attack);
                    $mail->subject($subject.' '.getCurrentDateTime());
                });

            //gửi cc cho tech
            $mail_test = CGlobal::mail_test;
            $mail_cc = 'khanhpt@hdinsurance.com.vn';
            Mail::send('mail.mailSendExcelInsmart', ['name' => $name, 'linkDowloadFile' => trim($linkDowloadFile)],
                function ($mail) use ($mail_test, $name,$mail_cc,$file_attack, $subject) {
                    $mail->from($this->EMAIL_SEND, $subject);
                    $mail->attach($file_attack);
                    $mail->to($mail_test, $name);
                    $mail->cc($mail_cc, $name);
                    $mail->subject($subject.' '.getCurrentDateTime());
                });

            if (is_file($file_attack)) {
                unlink($file_attack);
            }
            return true;
        }
        return false;
    }

    /**
     * QuynhTM: send Email quên mật khẩu
     * @param array $dataSend
     * @return bool
     */
    public function sentEmailForgotPassword($dataSend = []){

        $subject = 'Quên mật khẩu ';
        if(!empty($dataSend) && isset($dataSend['EMAIL']) && trim($dataSend['EMAIL']) != ''){
            $email = $dataSend['EMAIL'];
            $name = $dataSend['FULL_NAME'];
            //gửi mail cho đối tượng thay đổi pass
            Mail::send('mail.mailForgotPassword', ['data'=>$dataSend],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from($this->EMAIL_SEND, $subject);
                    $mail->to($email, $name);
                    $mail->subject($subject.' '.getCurrentDateTime());
                });

            //check xem có ai đổi mật khẩu
            $mail_test = CGlobal::mail_test;
            $subject2 = 'User HDI Quên mật khẩu';
            Mail::send('mail.mailForgotPassword', ['data'=>$dataSend],
                function ($mail) use ($mail_test, $name, $subject2,$email) {
                    $mail->from($this->EMAIL_SEND, $subject2);
                    $mail->to($mail_test, $name);
                    $mail->subject($subject2);
                });
            return true;
        }
        return false;
    }

    public function sentEmailCreaterUser($dataSend = []){

        $subject = 'Tạo mới Accoount trên HDI ';
        if(!empty($dataSend) && isset($dataSend['EMAIL']) && trim($dataSend['EMAIL']) != ''){
            $email = $dataSend['EMAIL'];
            $name = $dataSend['FULL_NAME'];
            //gửi mail cho đối tượng thay đổi pass
            if(trim($email) != ''){
                Mail::send('mail.mailCreaterUser', ['data'=>$dataSend],
                    function ($mail) use ($email, $name, $subject) {
                        $mail->from($this->EMAIL_SEND, $subject);
                        $mail->to($email, $name);
                        $mail->subject($subject.' '.getCurrentDateTime());
                    });
            }

            //check xem có ai đổi mật khẩu
            $mail_test = CGlobal::mail_test;
            $subject2 = 'User HDI mới được tạo';
            Mail::send('mail.mailCreaterUser', ['data'=>$dataSend],
                function ($mail) use ($mail_test, $name, $subject2,$email) {
                    $mail->from($this->EMAIL_SEND, $subject2);
                    $mail->to($mail_test, $name);
                    $mail->subject($subject2);
                });
            return true;
        }
        return false;
    }

    public function sentEmailError($dataSend = []){
        if(Config::get('config.ENVIRONMENT') == 'LIVE'){
            $subject = 'Bug HDI';
            if(!empty($dataSend) && isset($dataSend['content_error']) && trim($dataSend['content_error']) != ''){
                //check xem có ai đổi mật khẩu
                $mail_test = CGlobal::mail_test;
                $name = 'HDI system';
                Mail::send('mail.mailErrorSystem', ['data'=>$dataSend],
                    function ($mail) use ($mail_test, $name, $subject) {
                        $mail->from($this->EMAIL_SEND, $subject);
                        $mail->to($mail_test, $name);
                        $mail->subject($subject);
                    });
                return true;
            }
        }
        return false;
    }

}