<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Library\AdminFunction\Define;
use Illuminate\Support\Facades\Redirect;

/*
 * Encrypt given string using AES encryption standard
 */
function getEncrypt($secret)
{
    if (!strlen(trim($secret))) return $secret;

    $key = substr(hash('sha256', env('CYPHER_KEY', '$;cnqvM]A2}.zB:$gX#,Lt*Q@<+]v9F')), 0, 32);
    $iv = substr(hash('sha256', env('CYPHER_IV', '7Tj?k&Xyn')), 0, 16);
    $method = env('CYPHER_METHOD', "AES-256-CFB");
    $blocksize = env('CYPHER_BLOCK_SIZE', 32);
    $padwith = env('CYPHER_PAD_WITH', '`');

    try {
        $padded_secret = $secret . str_repeat($padwith, ($blocksize - strlen($secret) % $blocksize));
        $encrypted_string = openssl_encrypt($padded_secret, $method, $key, OPENSSL_RAW_DATA, $iv);
        $encrypted_secret = base64_encode($encrypted_string);

        return $encrypted_secret;
    } catch (Exception $e) {
        throw $e;
    }
}

/*
 * Decrypt given string using AES standard
 */
function getDecrypt($secret)
{
    if (!strlen(trim($secret))) return $secret;

    $key = substr(hash('sha256', env('CYPHER_KEY', '$;cnqvM]A2}.zB:$gX#,Lt*Q@<+]v9F')), 0, 32);
    $iv = substr(hash('sha256', env('CYPHER_IV', '7Tj?k&Xyn')), 0, 16);
    $method = env('CYPHER_METHOD', "AES-256-CFB");
    $padwith = env('CYPHER_PAD_WITH', '`');

    try {
        $decoded_secret = base64_decode($secret);
        $decrypted_secret = openssl_decrypt($decoded_secret, $method, $key, OPENSSL_RAW_DATA, $iv);
        return rtrim($decrypted_secret, $padwith);
    } catch (Exception $e) {
        throw $e;
    }
}

function myDebug($data, $is_die = true)
{
    echo '<pre>';
    array_map(function ($data) {
        print_r($data);
    }, func_get_args());
    echo '</pre>';

    if ($is_die) {
        die('This is data current');
    }
}

function myLiveDebug($data, $is_die = true)
{
    $env = Config::get('IS_LIVE');
    $is_debug = Request::get('is_debug', 0);
    if($env && $is_debug == STATUS_INT_MUOI_BA){
        echo 'Data live:';
        myDebug($data, $is_die);
    }
}

function limit_text_word($text, $limit = 250)
{
    $text = trim(strip_tags($text));
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

/**
 * build html select option
 *
 * @param array $options_array
 * @param int $selected
 * @param array $disabled
 */
function getOption($options_array, $selected, $disabled = array())
{
    $input = '';
    if ($options_array)
        foreach ($options_array as $key => $text) {
            $input .= '<option value="' . $key . '"';
            if (!in_array($selected, $disabled)) {
                if ($key === '' && $selected === '') {
                    $input .= ' selected';
                } else
                    if ($selected !== '' && $key == $selected) {
                        $input .= ' selected';
                    }
            }
            if (!empty($disabled)) {
                if (in_array($key, $disabled)) {
                    $input .= ' disabled';
                }
            }
            $input .= '>' . $text . '</option>';
        }
    return $input;
}

/**
 * build html select option mutil
 *
 * @param array $options_array
 * @param array $arrSelected
 */
function getOptionMultil($options_array, $arrSelected)
{
    $input = '';
    if ($options_array)
        foreach ($options_array as $key => $text) {
            $input .= '<option value="' . $key . '"';
            if ($key === '' && empty($arrSelected)) {
                $input .= ' selected';
            } else
                if (!empty($arrSelected) && in_array($key, $arrSelected)) {
                    $input .= ' selected';
                }
            $input .= '>' . $text . '</option>';
        }
    return $input;
}

function sortArrayASC(&$array, $key)
{
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}

function safe_title($text, $kytu = '-')
{
    if (trim($text) == '') return '';

    $text = post_db_parse_html($text);
    $text = stripUnicode($text);
    $text = _name_cleaner($text, $kytu);
    $text = str_replace("----", $kytu, $text);
    $text = str_replace("---", $kytu, $text);
    $text = str_replace("--", $kytu, $text);
    $text = trim($text, $kytu);

    return ($text) ? $text : "vaymuon_code";

}

//cackysapxepgannhau
function stringtitle($text)
{
    $text = post_db_parse_html($text);
    $text = stripUnicode($text);
    $text = _name_cleaner($text, "-");
    $text = str_replace("----", "-", $text);
    $text = str_replace("---", "-", $text);
    $text = str_replace("--", "-", $text);
    $text = str_replace("-", "", $text);
    $text = trim($text);

    if ($text) {
        return $text;
    } else {
        return "shop";
    }
}

function post_db_parse_html($t = "")
{
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

    $t = preg_replace("/javascript/i", "j&#097;v&#097;script", $t);
    $t = preg_replace("/alert/i", "&#097;lert", $t);
    $t = preg_replace("/about:/i", "&#097;bout:", $t);
    $t = preg_replace("/onmouseover/i", "&#111;nmouseover", $t);
    $t = preg_replace("/onmouseout/i", "&#111;nmouseout", $t);
    $t = preg_replace("/onclick/i", "&#111;nclick", $t);
    $t = preg_replace("/onload/i", "&#111;nload", $t);
    $t = preg_replace("/onsubmit/i", "&#111;nsubmit", $t);
    $t = preg_replace("/applet/i", "&#097;pplet", $t);
    $t = preg_replace("/meta/i", "met&#097;", $t);

    return $t;
}

function stripUnicode($str)
{
    if (!$str)
        return false;
    $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
        "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
    , "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
    , "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
    , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
    , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ");

    $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
    , "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
    , "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
    , "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
    , "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D");

    $str = str_replace($marTViet, $marKoDau, $str);
    return $str;
}

function _name_cleaner($name, $replace_string = "_")
{
    return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
}

/**
 * convert from str to array
 *
 * @param string $str_item
 */
function standardizeCartStr($str_item)
{
    if (empty($str_item))
        return 0;
    $str_item = trim(preg_replace('#([\s]+)|(,+)#', ',', trim($str_item)));
    $data = explode(',', $str_item);
    $arrItem = array();
    foreach ($data as $item) {
        if ($item != '')
            $arrItem[] = $item;
    }
    if (empty($arrItem))
        return 0;
    else
        return $arrItem;
}

function numberFormat($number = 0, $decimal = ".", $thousand_point = ".", $per = 0)
{
    $number = (float)$number;
    return number_format($number, $per, $decimal, $thousand_point);
}

function checkRegexEmail($str = '')
{
    if ($str != '') {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regex, $str)) {
            return false;
        }
        return true;
    }
    return false;
}

function substring($str, $length = 250, $replacer = '...')
{
    $str = strip_tags($str);
    if (strlen($str) <= $length) {
        return $str;
    }
    $str = trim(@substr($str, 0, $length));
    $posSpace = strrpos($str, ' ');
    $replacer = "...";
    return substr($str, 0, $posSpace) . $replacer;
}

function viewLanguage($key)
{
    $lang = Session::get('languageSite');
    $lang = ((int)$lang > 0) ? $lang : VIETNAM_LANGUAGE;
    $path = storage_path() . "/language/" . Define::$arrLanguage[$lang] . ".json";
    $json = file_get_contents($path);
    $json = mb_convert_encoding($json, 'UTF8', 'auto');
    $language = json_decode($json, true);
    return isset($language[$key]) ? $language[$key] : $key;
}

function khoangcachngay($p_strngay1, $p_strngay2, $p_strkieu = 'ngay')
{
    $m_arrngay1 = explode('/', $p_strngay1);
    $m_arrngay2 = explode('/', $p_strngay2);
    $m_intngay1 = mktime(0, 0, 0, $m_arrngay1[1], $m_arrngay1[0], $m_arrngay1[2]);
    $m_intngay2 = mktime(0, 0, 0, $m_arrngay2[1], $m_arrngay2[0], $m_arrngay2[2]);

    $m_int = abs($m_intngay1 - $m_intngay2);
    switch ($p_strkieu) {
        case 'ngay':
            $m_int /= 86400;
            break;
        case 'gio' :
            $m_int /= 3600;
            break;
        case 'phut':
            $m_int /= 60;
            break;
        default :
            break;
    }
    return $m_int;
}

function khoangcachngay2($p_strngay1, $p_strngay2)
{
    $end = Carbon::parse($p_strngay1);
    $now = $p_strngay2;
    $length = $end->diffInDays($now);
    return $length;
}

/**
 * QuynhTM add
 * @param $id
 * @return string
 */
function setStrVar($string)
{
    return base64_encode(randomString() . '_' . $string . '_' . randomString());
}

function getStrVar($string)
{
    $stringOut = 0;
    if (trim($string) != '') {
        $strId = base64_decode($string);
        $result = explode('_', $strId);
        if (!empty($result)) {
            $stringOut = isset($result[1]) ? (int)$result[1] : 0;
        }
    }
    return $stringOut;
}

function randomString($length = 5)
{
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strLength = strlen($str);
    $random_string = '';
    for ($i = 0; $i <= $length; $i++) {
        $random_string .= $str[rand(0, $strLength - 1)];
    }
    return $random_string;
}

function createSequence($prefix = '', $id = 0)
{
    $str = '';
    if ($id > 0 && $prefix != '') {
        if ($id < 10) {
            $str = $prefix . '00' . $id;
        } elseif ($id >= 10 && $id < 100) {
            $str = $prefix . '0' . $id;
        } else {
            $str = $prefix . '' . $id;
        }
    }
    return $str;
}

//hàm đổi tiếng việt có dấu thành không dấu
function convert_vi_to_en($str)
{
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

//    $str = ucwords($str);
//      $str = str_replace(" ", $replace_with, str_replace("&*#39;","",$str));
    $str = str_replace(" ", '_', strtolower($str));
    return $str;
}

function getSubDate($date, $number)
{
    date_default_timezone_set('Asia/Bangkok');
    $date = date_create($date);
    date_sub($date, date_interval_create_from_date_string($number . ' days'));
    return date_format($date, 'Y-m-d');
}

function getAddDate2($date, $number)
{
    date_default_timezone_set('Asia/Bangkok');
    $date = date_create($date);
    date_add($date, date_interval_create_from_date_string($number . ' days'));
    return date_format($date, 'Y-m-d H:i:s');
}

function clearTextInput($text)
{
    return strip_tags(preg_replace('/<[^>]*>/', '', html_entity_decode($text, ENT_QUOTES, 'UTF-8')));
}

function debugLog($data, $nameFile = 'debug_log_1.log', $name_folder = '')
{
    $folder_logs = (trim($name_folder) != '') ? storage_path() . '/logs/' . $name_folder : storage_path() . '/logs';
    if (!is_dir($folder_logs)) {
        @mkdir($folder_logs, 0755, true);
        @chmod($folder_logs, 0755);
    }
    $csv_filename = $folder_logs . '/' . $nameFile;
    if (!is_file($csv_filename)) {
        $fp = fopen($csv_filename, 'a');
        if ($fp) {
            fclose($fp);
        }
    }
    file_put_contents($csv_filename, print_r(getCurrentDateTime(), true) . "\n", FILE_APPEND);
    file_put_contents($csv_filename, print_r($data, true) . "\n", FILE_APPEND);
}

function endLog($nameFile = 'debug_log_1.log', $name_folder = '')
{
    $folder_logs = (trim($name_folder) != '') ? storage_path() . '/logs/' . $name_folder : storage_path() . '/logs';
    if (!is_dir($folder_logs)) {
        @mkdir($folder_logs, 0755, true);
        @chmod($folder_logs, 0755);
    }
    $csv_filename = $folder_logs . '/' . $nameFile;
    if (!is_file($csv_filename)) {
        $fp = fopen($csv_filename, 'a');
        if ($fp) {
            fclose($fp);
        }
    }
    file_put_contents($csv_filename, "\n=================================================================================End " . getCurrentDateTime() . " =================================================================\n\n", FILE_APPEND);
}

function checkFileExt($str = '')
{
    $ext = '';
    if ($str != '') {
        $ext = @end(explode('.', $str));
    }
    return $ext;
}

function cutPhoneNumber($phone = '')
{
    if ($phone != '') {
        $phone = trim($phone);
        $phone = str_replace(array('^', '$', '\\', '/', '(', ')', '|', '?', '_', '-', '+', '.', ' ', '*', '[', ']', '{', '}', ',', '%', '<', '>', '=', '"', '“', '”', '!', ':', ';', '&', '~', '#', '`', "'", '@'), array(''), $phone);
        if (strlen(trim($phone)) > 10) {
            $phone = str_replace('84', '', $phone);
        }
        if (strlen($phone) == 10) {
            $phone = ltrim($phone, '0');
        }
        if (strlen($phone) == 11) {
            $phone = ltrim($phone, '0');
        }
    }
    return $phone;
}

/**
 * QuynhTM
 * Chuyển đổi chuối thành số, chuyển đổi string tiền thành số
 * @param $subject
 * @param string $search
 * @param string $replace
 * @return int
 */
function getWeekDay($timeDay = null)
{
    $weekDay = [];
    if ($timeDay == null)
        return $weekDay;

    for ($i = 0; $i < 7; $i++) {
        $weekDay[$i]['thu'] = $timeDay->startOfWeek()->addDay($i)->format('l');
        $weekDay[$i]['ngay'] = $timeDay->startOfWeek()->addDay($i)->format('d-m-Y');
    }
    return $weekDay;
}

function convertWeekDayToVN($strWeekday = '')
{
    $thu = $strWeekday;
    if ($strWeekday != '') {
        $strWeekday = strtolower($strWeekday);
        switch ($strWeekday) {
            case 'monday':
                $thu = 'Thứ Hai';
                break;
            case 'tuesday':
                $thu = 'Thứ Ba';
                break;
            case 'wednesday':
                $thu = 'Thứ Tư';
                break;
            case 'thursday':
                $thu = 'Thứ Năm';
                break;
            case 'friday':
                $thu = 'Thứ Sáu';
                break;
            case 'saturday':
                $thu = 'Thứ Bảy';
                break;
            default:
                $thu = 'Chủ nhật';
                break;
        }
    }
    return $thu;
}

function convertNumberFromString($subject, $search = ',', $replace = '')
{
    $number = 0;
    if (trim($subject) != '') {
        $number = (int)str_replace($search, $replace, $subject);;
    }
    return $number;
}

function getCurrentDate()
{
    date_default_timezone_set('Asia/Bangkok');
    return date("Y-m-d");
}

function getParamDate($type = '')
{
    date_default_timezone_set('Asia/Bangkok');
    switch ($type) {
        case 'd':
            $result = date("d");
            break;
        case 'm':
            $result = date("m");
            break;
        case 'Y':
            $result = date("Y");
            break;
        default:
            $result = date("Y-m-d");
            break;
    }
    return $result;
}

function getIntDateYMD()
{
    date_default_timezone_set('Asia/Bangkok');
    return (int)date("Ymd");
}

function convertDate($date)
{
    $step1 = getSubDate($date, 0) . " 00:00:00";
    $step2 = new \DateTime($step1);
    return $step2;
}

function getAddDate($date, $number)
{
    date_default_timezone_set('Asia/Bangkok');
    $date = date_create($date);
    date_add($date, date_interval_create_from_date_string($number . ' days'));
    return date_format($date, 'Y-m-d');
}

function getCurrentDateTime()
{
    date_default_timezone_set('Asia/Bangkok');
    return date("Y-m-d H:i:s");
}

function getAddDate3($date, $number)
{
    date_default_timezone_set('Asia/Bangkok');
    $date = date_create($date);
    date_add($date, date_interval_create_from_date_string($number . ' days'));
    return date_format($date, 'd-m-Y');
}

function convertDateYmd($str_datetime)
{
    return (trim($str_datetime) != '') ? date('Y-m-d', strtotime($str_datetime)) : '';
}

function convertDateDMY($str_datetime)
{
    return (trim($str_datetime) != '') ? date('d/m/Y', strtotime($str_datetime)) : '';
}

function getCurrentDateDMY()
{
    date_default_timezone_set('Asia/Bangkok');
    return date("d-m-Y");
}

function getCurrentDateMY()
{
    date_default_timezone_set('Asia/Bangkok');
    return date("m-Y");
}

function getCurrentFull()
{
    date_default_timezone_set('Asia/Bangkok');
    return date("Y-m-d H:i:s", time());
}

function getDateShow($date)
{
    date_default_timezone_set('Asia/Bangkok');
    $date = date_create($date);
    return date_format($date, "d-m-Y");
}

function showMessage($status = 'status', $mess = '')
{
    if ($status != '') {
        if (is_array($mess) && !empty($mess)) {
            $mess = implode('<br>', $mess);
        }
        if ($mess != '') {
            Session::flash($status, $mess);
        }
    }
}

//Get https or http
function getBaseUrl()
{
    return env('APP_URL', '');//QuynhTM đóng lại để dùng https

    /*if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    $base_url = str_replace('\\', '/', $protocol . $_SERVER['HTTP_HOST'] . (dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
    $base_url .= $base_url[strlen($base_url) - 1] != '/' ? '/' : '';
    return $base_url;*/

}

//Get root path
function getRootPath()
{
    $dir_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . (dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
    $dir_root .= $dir_root[strlen($dir_root) - 1] != '/' ? '/' : '';
    return $dir_root;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {

    }
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }
    if ($version == null || $version == "") {
        $version = "?";
    }
    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

/**
 * QuynhTM add
 * @param $table
 * @param $arrInput
 * @return string
 */
function buildSqlInsertMultiple($table, $arrInput)
{
    if (!empty($arrInput)) {
        $arrSql = array();
        $arrField = isset($arrInput[0]) ? array_keys($arrInput[0]) : [];
        if (empty($arrField))
            return '';

        foreach ($arrInput as $k => $row) {
            $strVals = '';
            foreach ($row as $field => $valu) {
                $strVals .= "'" . trim($valu) . '\',';
            }
            if ($strVals != '')
                $strVals = rtrim($strVals, ',');
            if ($strVals != '')
                $arrSql[] = '(' . $strVals . ')';
        }

        $fields = implode(',', $arrField);
        if (!empty($arrSql)) {
            $query = 'INSERT INTO `' . $table . '` (' . $fields . ') VALUES ' . implode(',', $arrSql);
            return $query;
        }
    }
    return '';
}

/**
 * QuynhTM add
 * @param $table
 * @param $data
 * @param $id
 * @return string
 */
function buildSqlUpdate($table, $data, $condition = '')
{
    $setColumn = array();
    foreach ($data as $key => $value) {
        $setColumn[] = "{$key} = '{$value}'";
    }
    $sql = (trim($condition) != '') ? "UPDATE {$table} SET " . implode(', ', $setColumn) . " WHERE {$condition}" : '';
    return $sql;
}

/**
 * @param $data
 * @param string $name_key
 * @return array
 */
function getArrayByKeyToObject($data, $name_key = 'loaner_id')
{
    $result = array();
    if (is_object($data) && $data->count() > 0) {
        foreach ($data as $item) {
            $result[$item->$name_key] = $item->$name_key;
        }
    }
    return $result;
}

function convertToArray($array)
{
    if ($array == null) {
        return "";
    }
    if (is_object($array)) {
        $array = $array->toArray();
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                $value = (array)$value;
            }
            if (is_array($value)) {
                $array[$key] = convertToArray($value);
            } else {
                $array[$key] = (string)$value;
            }
        }
    }
    return $array;
}

/**
 * @param $file_name
 */
function link_css($file_name, $position = 1)
{
    if (is_array($file_name)) {
        foreach ($file_name as $v) {
            link_css($v);
        }
        return;
    }
    if (strpos($file_name, 'http://') !== false) {
        $html = '<link rel="stylesheet" href="' . $file_name . ((\App\Library\AdminFunction\CGlobal::$css_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderCSS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterCSS .= $html . "\n";
        return;
    } else {
        $html = '<link type="text/css" rel="stylesheet" href="' . \Illuminate\Support\Facades\Config::get('config.WEB_ROOT') . '/assets/' . $file_name . ((\App\Library\AdminFunction\CGlobal::$css_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$css_ver : '') . '" />' . "\n";
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderCSS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterCSS .= $html . "\n";
    }
}

/**
 * @param $file_name
 */
function link_js($file_name, $position = 1)
{
    if (is_array($file_name)) {
        foreach ($file_name as $v) {
            link_js($v);
        }
        return;
    }
    if (strpos($file_name, 'http://') !== false) {
        $html = '<script type="text/javascript" src="' . $file_name . ((\App\Library\AdminFunction\CGlobal::$js_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$js_ver : '') . '"></script>';
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderJS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterJS .= $html . "\n";
        return;
    } else {
        $html = '<script type="text/javascript" src="' . \Illuminate\Support\Facades\Config::get('config.WEB_ROOT') . '/assets/' . $file_name . ((\App\Library\AdminFunction\CGlobal::$js_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$js_ver : '') . '"></script>';
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderJS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterJS .= $html . "\n";
    }
}

function site_css($file_name, $position = 1)
{
    if (is_array($file_name)) {
        foreach ($file_name as $v) {
            site_css($v);
        }
        return;
    }
    if (strpos($file_name, 'http://') !== false) {
        $html = '<link rel="stylesheet" href="' . $file_name . ((\App\Library\AdminFunction\CGlobal::$css_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderCSS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterCSS .= $html . "\n";
        return;
    } else {
        $html = '<link type="text/css" rel="stylesheet" href="' . url('', array(), \Illuminate\Support\Facades\Config::get('config.SECURE')) . '/assets/' . $file_name . ((\App\Library\AdminFunction\CGlobal::$css_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$css_ver : '') . '" />' . "\n";
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderCSS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterCSS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterCSS .= $html . "\n";
    }
}

/**
 * @param $file_name
 */
function site_js($file_name, $position = 1)
{
    if (is_array($file_name)) {
        foreach ($file_name as $v) {
            link_js($v);
        }
        return;
    }
    if (strpos($file_name, 'http://') !== false) {
        $html = '<script type="text/javascript" src="' . $file_name . ((\App\Library\AdminFunction\CGlobal::$js_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$js_ver : '') . '"></script>';
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderJS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterJS .= $html . "\n";
        return;
    } else {
        $html = '<script type="text/javascript" src="' . url('', array(), \Illuminate\Support\Facades\Config::get('config.SECURE')) . '/assets/' . $file_name . ((\App\Library\AdminFunction\CGlobal::$js_ver) ? '?ver=' . \App\Library\AdminFunction\CGlobal::$js_ver : '') . '"></script>';
        if ($position == \App\Library\AdminFunction\CGlobal::$POS_HEAD && strpos(\App\Library\AdminFunction\CGlobal::$extraHeaderJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraHeaderJS .= $html . "\n";
        elseif ($position == \App\Library\AdminFunction\CGlobal::$POS_END && strpos(\App\Library\AdminFunction\CGlobal::$extraFooterJS, $html) === false)
            \App\Library\AdminFunction\CGlobal::$extraFooterJS .= $html . "\n";
    }
}
/**
 * Build link cho Shop frontend
 */
function buildLinkHome(){
    return \Illuminate\Support\Facades\URL::route('site.home');
}
function buildLinkNewsWithCategory($cat_id = 0,$cat_name = 'danh muc'){
    if($cat_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.indexNewWithCategory', array('cat_id'=>$cat_id,'cat_name'=>strtolower(safe_title($cat_name))));
    }
    return '#';
}
function buildLinkDetailNew($new_id = 0, $new_name = 'tin tức', $cat_id = 0){
    if($new_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.indexDetailNews', array( 'new_id'=>$new_id,'new_name'=>strtolower(safe_title($new_name)),'cat_id'=>$cat_id));
    }
    return '#';
}
function buildLinkDetailProduct($pro_id = 0,$pro_name = 'sản phẩm',$cat_name = 'danh mục'){
    if($pro_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.indexDetailProduct', array('cat_name'=>strtolower(safe_title($cat_name)),'id'=>$pro_id,'name'=>strtolower(safe_title($pro_name))));
    }
    return '#';
}
function buildLinkDetailRecruitment($id = 0,$name = 'sản phẩm',$cat_name = 'tuyen-dung'){
    if($id > 0){
        return \Illuminate\Support\Facades\URL::route('site.indexDetailRecruitment', array('cat_name'=>strtolower(safe_title($cat_name)),'id'=>$id,'name'=>strtolower(safe_title($name))));
    }
    return '#';
}

function buildLinkProductWithDepart($depart_id = 0,$depart_name = 'danh muc'){
    if($depart_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.listProductWithDepart', array('depart_id'=>(int)$depart_id,'depart_name'=>strtolower(safe_title($depart_name))));
    }
    return '#';
}

function buildLinkProductWithCategory($cat_id = 0,$cat_name = 'danh muc'){
    if($cat_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.indexProductWithCategory', array('cat_id'=>(int)$cat_id,'cat_name'=>strtolower(safe_title($cat_name))));
    }
    return '#';
}
function buildLinkProductWithTag($tag_id = 0,$tag_name = 'hashtag'){
    if($tag_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.listProductWithTag', array('tag_id'=>strtolower(safe_title($tag_id)),'tag_name'=>strtolower(safe_title($tag_name))));
    }
    return '#';
}
function buildLinkProductWithCampaign($camp_id = 0,$camp_name = 'campaign'){
    if($camp_id > 0){
        return \Illuminate\Support\Facades\URL::route('site.listProductWithCampaign', array('camp_id'=>strtolower(safe_title($camp_id)),'camp_name'=>strtolower(safe_title($camp_name))));
    }
    return '#';
}
function getLinkImageShow($folder = FOLDER_FILE_DEFAULT, $file_name = '')
{
    $no_image = Config::get('config.WEB_ROOT') . 'assets/backend/img/login/no-image.png';
    if (!preg_match("/.jpg|.jpeg|.JPEG|.JPG|.png|.gif/", strtolower($file_name))) return $no_image;
    $imagSource = Config::get('config.DIR_ROOT') . Config::get('config.DIR_UPLOAD') . $folder. '/' . $file_name;
    $imagUrl = Config::get('config.WEB_ROOT') . Config::get('config.PATH_UPLOAD') . $folder. '/' . $file_name;
    $url_img = (file_exists($imagSource)) ? $imagUrl : $no_image;
    return $url_img;
}

function getDirFile($file_name = '')
{
    if (trim($file_name) != '') {
        $dir_file = Config::get('config.DIR_ROOT') . 'uploads/' . $file_name;
        if (is_file($dir_file)) {
            return $dir_file;
        }
    }
    return '';
}

function getLinkFileToStore($file_id = '', $is_dev = true, $is_download = false)
{
    $is_dev = (Config::get('config.ENVIRONMENT') == 'DEV')? true: false;
    $urlServer = ($is_dev ? Config::get('config.URL_HYPERSERVICES_DEV') : Config::get('config.URL_HYPERSERVICES_LIVE')) . "f/";
    return ($is_download == true) ? $urlServer . $file_id . '?download=true' : $urlServer . $file_id;
}

function removeSpecialSpace($string)
{
    $string = str_replace(array('[\', \']', '\n', '\r', '\r\n'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', ' ', $string);
    $string = html_entity_decode($string, ENT_COMPAT, 'utf-8');
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = (trim(preg_replace('/\s+/', ' ', $string)));
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);

    return (trim($string));
}

function allowedImportMimeType($mime)
{
    $allowedType = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-office',
        'application/octet-stream',
        'application/zip',
    ];

    if (!in_array($mime, $allowedType)) {
        throw new \PDOException('Bad Request: Only xls|xlsx files allowed', 406);
    }
}

function validatePhoneNumber($phone, $local = 'VN')
{
    switch ($local) {
        case 'VN':
            if (!preg_match('/^\+84[\d]{9,10}$|^[\d]{10,11}$/', $phone)) {
                return false;
            }
            return true;
        default:
            return true;
    }
}

function validatePass($subject)
{
    $partten = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){6,31}$/";
    if (!preg_match($partten, $subject)) {
        return false;
    }
    return true;
}

function showBtnAction($line, $code, $btn = '', $is_staff = true)
{
    $arrBtn = ($is_staff) ? \App\Library\AdminFunction\CGlobal::$arrStaffTab : \App\Library\AdminFunction\CGlobal::$arrDepartTab;
    if (!empty($arrBtn)) {
        $arrBtnLine = $arrBtn[$line] ?? [];
        if (!empty($arrBtn)) {
            foreach ($arrBtnLine as $key => $infor) {
                if ($infor['name_tab'] == $code && in_array($btn, $infor['btn_action'])) {
                    return true;
                }
            }
        }
    }
    return false;
}

function convertArrayKeyToUcFirst($args = [])
{
    ksort($args);
    $result = [];
    foreach ($args as $k => $v) {
        $parse = explode('_', $k);
        array_walk($parse, function (&$val) {
            $val = ucfirst(strtolower($val));
        });

        $key = implode('', $parse);
        $result[$key] = is_null($v) ? '' : $v;
    }
    return $result;
}

function vnStrFilter($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}

function returnSuccess($msg = 'Successfully', $data = '')
{
    return ['success' => 1, 'data' => $data, 'message' => $msg];
}

function returnError($msg = 'Error', $data = '')
{
    $strMsg = is_array($msg) ? implode('<br />', $msg) : $msg;
    return ['success' => 0, 'data' => $data, 'message' => $strMsg];
}

function returnErrorSession($url_current = '')
{
    $link_login = '<a href="' . \Illuminate\Support\Facades\URL::route('backend.login') . '">Đăng nhập</a>';
    return ['success' => -1, 'message' => 'Bạn hãy ' . $link_login . ' lại.'];
}

function getPrefixLevelName($level)
{
    $prefix_name = '';
    switch ($level) {
        case 1:
            $prefix_name = '-- ';
            break;
        case 2:
            $prefix_name = '-- -- ';
            break;
        case 3:
            $prefix_name = '-- -- -- ';
            break;
        case 4:
            $prefix_name = '-- -- -- -- ';
            break;
        case 5:
            $prefix_name = '-- -- -- -- -- ';
            break;
        case 6:
            $prefix_name = '-- -- -- -- -- -- ';
            break;
        default:
            break;
    }
    return $prefix_name;
}

/**
 * @param string $strDate = '01/09/2021'
 */
function isValidDateTime($strDate = '')
{
    $strDate = str_replace('-', '/', $strDate);
    $strDate = str_replace('.', '/', $strDate);
    return \DateTime::createFromFormat('d/m/Y', trim($strDate));
}

/*function compareDate($strStart = '',$strEnd = ''){
    $strDate = str_replace('-','/',$strDate);
    $strDate = str_replace('.','/',$strDate);
    $intStart =
}*/

function setEnvironmentValue($envKey, $envValue)
{
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);
    $str = str_replace("{$envKey}=", "{$envKey}={$envValue}\n", $str);
    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
}

function returnFormatMoney($str_money, $ext = '.')
{
    if (trim($str_money) != '') {
        return (int)str_replace($ext, '', $str_money);
    }
    return $str_money;
}

function getArrYear()
{
    $today = Carbon::now();
    $year_current = $today->year;
    $arrYear[$year_current] = $year_current;
    for ($i = 1; $i < 10; $i++) {
        $year = $year_current - $i;
        $arrYear[$year] = $year;
    }
    return $arrYear;
}

function getArrMinuteFull()
{
    for ($i = 0; $i <= 60; $i++) {
        if ($i < 10) {
            $arrMinute['0' . $i] = '0' . $i;
        } else {
            $arrMinute[$i] = $i;
        }
    }
    return $arrMinute;
}

function getDateStartOfMonth(){
    return date('d/m/Y', strtotime(Carbon::now()->startOfMonth()));
}
function getDateNow(){
    return date('d/m/Y', strtotime(Carbon::now()));
}
function getTimeCurrent($type = '')
{
    $type = strtoupper($type);
    $now = Carbon::now();
    switch ($type) {
        case 'D':
            $time = $now->day;
            break;
        case 'M':
            $time = $now->month;
            break;
        case 'Y':
            $time = $now->year;
            break;
        case 'H':
            $time = $now->hour;
            break;
        default:
            $time = date('d/m/Y H:i:s', time());
            break;
    }
    return $time;
}

//str_date = 21/04/2021 00:00:00
function cutStrDate($str_date = '')
{
    $date = trim($str_date);
    if (trim($str_date) != '') {
        $arrDate = explode(' ', $str_date);
        $date = isset($arrDate[0]) ? $arrDate[0] : $str_date;
    }
    return $date;
}

//get array mang con truyền vào
function getArrChild($arrRoot = [], $arrChose = [])
{
    $arrArrChild = [];
    if (!empty($arrRoot) && !empty($arrChose)) {
        foreach ($arrChose as $key_code) {
            if (isset($arrRoot[$key_code])) {
                $arrArrChild[$key_code] = $arrRoot[$key_code];
            }
        }
    }
    return $arrArrChild;
}
