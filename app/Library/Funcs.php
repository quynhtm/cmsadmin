<?php


namespace App\Library;

use Illuminate\Support\Facades\Route;

class Funcs
{
    static $holidays = [ '02-09-2020' ];

    public static function guidv4()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function debug($e) {
        echo '<pre>';
        print_r($e);
        die;
    }

    public static function days($date_1, $date_2) {
        $time = $date_2 - $date_1;
        if(date('w', $date_2) == 5) {
            return (round($time / (24*60*60))) + 3;
        }
        return round($time / (24*60*60));
    }

    public static function toArray($data) {
        return json_decode(json_encode($data), true);
    }

    public static function getPaymentDeadlineThanTwoWeeks($time) {
        $days = round(abs($time - time())/60/60/24);
        if($days >= 28) {
            $time -= (14*24*60*60);
        } else {
            $time = time() + (14*24*60*60);
        }
        if(date('N', $time) == 6) {
            $time += (2*24*60*60);
        } elseif (date('N', $time) == 7) {
            $time += (24*60*60);
        }
        if(in_array(date('d-m-Y', $time), self::$holidays)) {
            $time += (24*60*60);
        }
        return $time;
    }

    public static function getPaymentDeadlineThanTwoWeeks_old($time) {
        $time -= (14*24*60*60);
        if(date('N', $time) == 6) {
            $time += (2*24*60*60);
        } elseif (date('N', $time) == 7) {
            $time += (24*60*60);
        }
        if(in_array(date('d-m-Y', $time), self::$holidays)) {
            $time += (24*60*60);
        }
        return $time;
    }

    public static function getPaymentDeadlineInTwoWeeks($time) {
        $time += (14*24*60*60);
        if(date('N', $time) == 6) {
            $time += (2*24*60*60);
        } elseif (date('N', $time) == 7) {
            $time += (24*60*60);
        }
        if(in_array(date('d-m-Y', $time), self::$holidays)) {
            $time += (24*60*60);
        }
        return $time;
    }

    public static function getPaymentDeadlineExpiredDate($time) {
        $time += (7*24*60*60);
        if(date('N', $time) == 6) {
            $time += (2*24*60*60);
        } elseif (date('N', $time) == 7) {
            $time += (24*60*60);
        }
        if(in_array(date('d-m-Y', $time), self::$holidays)) {
            $time += (24*60*60);
        }
        return $time;
    }

    public static function checkHowTime($time, $time_to) {
        if($time <= $time_to) {
            if( ($time_to - $time) >= (14*24*60*60) ) {
                return 1;
            } elseif ( ($time_to - $time) < (14*24*60*60) ) {
                return 2;
            }
        } else {
            return 3;
        }
    }


    public static function getPaymentDeadline($time) {
        if(date('N', $time) == 6) {
            $time += (2*24*60*60);
        } elseif (date('N', $time) == 7) {
            $time += (24*60*60);
        }
        if(in_array(date('d-m-Y', $time), self::$holidays)) {
            $time += (24*60*60);
        }
        return $time;
    }


    static function safe_title($text, $lower = true) {
        if ($lower) {
            $text = strtolower(mb_strtolower($text));
        }
        $text = self::post_db_parse_html($text);
        $text = self::stripUnicode($text);
        $text = self::_name_cleaner($text, "-");
        $text = str_replace("----", "-", $text);
        $text = str_replace("---", "-", $text);
        $text = str_replace("--", "-", $text);
        $text = trim($text, '-');
        return $text;
    }

    static function post_db_parse_html($t = "") {
        if ($t == "") {
            return $t;
        }
        $t = str_replace("&#39;", "'", $t);
        $t = str_replace("&#33;", "!", $t);
        $t = str_replace("&#036;", "$", $t);
        $t = str_replace("&#124;", "|", $t);
        $t = str_replace("&amp;", "&", $t);
        $t = str_replace("&gt;", ">", $t);
        $t = str_replace("&lt;", "<", $t);
        $t = str_replace("&quot;", '"', $t);

        //-----------------------------------------
        // Take a crack at parsing some of the nasties
        // NOTE: THIS IS NOT DESIGNED AS A FOOLPROOF METHOD
        // AND SHOULD NOT BE RELIED UPON!
        //-----------------------------------------

        $t = preg_replace("/javascript/i", "j&#097;v&#097;script", $t);
        $t = preg_replace("/alert/i", "&#097;lert", $t);
        $t = preg_replace("/about:/i", "&#097;bout:", $t);
        $t = preg_replace("/onmouseover/i", "&#111;nmouseover", $t);
        $t = preg_replace("/onmouseout/i", "&#111;nmouseout", $t);
        $t = preg_replace("/onclick/i", "&#111;nclick", $t);
        $t = preg_replace("/onload/i", "&#111;nload", $t);
        $t = preg_replace("/onsubmit/i", "&#111;nsubmit", $t);
        $t = preg_replace("/object/i", "&#111;bject", $t);
        $t = preg_replace("/frame/i", "fr&#097;me", $t);
        $t = preg_replace("/applet/i", "&#097;pplet", $t);
        $t = preg_replace("/meta/i", "met&#097;", $t);

        return $t;
    }

    static function stripUnicode($str){
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
        $str = preg_replace("/( )/", ' ', $str);
        return $str;
    }

    static function _name_cleaner($name, $replace_string = "_") {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
    }

    static function word_limit($data, $limit=10)
    {
        $string = '';
        if(stripos($data," ")){
            $tmp = explode(" ",$data);
            if(count($tmp) > $limit){
                for($i=0; $i<$limit; $i++){
                    $string .= $tmp[$i]." ";
                }
                return $string . '...';
            }
        }
        return $data;
    }

    static function char_limit($string, $limit=10)
    {
        if(strlen($string) > $limit) {
            return substr($string, 0, $limit) . '...';
        }
        return $string;
    }

    static function callAPI($url, $data){
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => false,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
    }


    static function time_stamp($time_ago, $lang=1)
    {
        $cur_time=time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed ;
        $minutes = round($time_elapsed / 60 );
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400 );
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640 );
        $years = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60)
        {
            echo (($lang == 1) ? " Cách đây $seconds giây " : " $seconds seconds ago ");
        }
        //Minutes
        else if($minutes <=60)
        {
            if($minutes==1)
            {
                echo (($lang == 1) ? " Cách đây 1 phút " : " 1 minute ago ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $minutes phút " : " $minutes minutes ago ");
            }
        }
        //Hours
        else if($hours <=24)
        {
            if($hours==1)
            {
                echo (($lang == 1) ? " Cách đây 1 tiếng " : " 1 hour ago ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $hours tiếng " : " $hours hours ago ");
            }
        }
        //Days
        else if($days <= 7)
        {
            if($days==1)
            {
                echo (($lang == 1) ? " Ngày hôm qua " : " Yesterday ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $days ngày " : " $days days ago ");
            }
        }
        //Weeks
        else if($weeks <= 4.3)
        {
            if($weeks==1)
            {
                echo (($lang == 1) ? " Cách đây 1 tuần " : " 1 week ago ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $weeks tuần " : " $weeks weeks ago ");
            }
        }
        //Months
        else if($months <=12)
        {
            if($months==1)
            {
                echo (($lang == 1) ? " Cách đây 1 tháng " : " 1 month ago ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $months tháng " : " $months months ago ");
            }
        }
        //Years
        else
        {
            if($years==1)
            {
                echo (($lang == 1) ? " Cách đây 1 năm " : " 1 year ago ");
            }
            else
            {
                echo (($lang == 1) ? " Cách đây $years năm " : " $years years ago ");
            }
        }
    }


    static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

   static function url_request($url) {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $response = curl_exec($ch);

       return json_decode($response);
   }

   static function isMobileDevice() {
       return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
   }

    static function email_generated($name) {
        $name = strtolower($name);
        $name = str_replace('  ', ' ', $name);
        $name = str_replace('   ', ' ', $name);

        $expName = explode(' ', $name);

        $email = $temp = '';
        foreach($expName as $k=>$v) {
            if($k != count($expName) - 1) {
                $temp .= substr($v, 0, 1);
            } else {
                $email = $v . '.' . $temp;
            }
        }
        return $email;
    }


    static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    static function randomPassword2($len = 8) {

        //enforce min length 8
        if($len < 8)
            $len = 8;

        //define character libraries - remove ambiguous characters like iIl|1 0oO
        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';

        $password = '';

        //append a character from each set - gets first 4 characters
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        //use all characters to fill up to $len
        while(strlen($password) < $len) {
            //get a random set
            $randomSet = $sets[array_rand($sets)];

            //add a random char from the random set
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        //shuffle the password string before returning!
        return str_shuffle($password);
    }

    static function getRouteNameAction()
    {
        return Route::currentRouteName();
    }
}
