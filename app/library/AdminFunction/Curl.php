<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 7/9/14
 * Time: 10:55 AM
 */

namespace App\Library\AdminFunction;

class Curl
{
    protected static $ch = null;
    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$ch === null) {
            self::$instance = new self();
            self::init();
            return self::$instance;
        } else {
            return self::$instance;
        }
    }

    public static function init()
    {
        try {
            if (!isset(self::$ch)) {
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,     // return web page
                    CURLOPT_HEADER => 0,    // don't return headers
                    CURLOPT_FOLLOWLOCATION => 1,     // follow redirects
                    CURLOPT_ENCODING => "",       // handle all encodings
                    CURLOPT_AUTOREFERER => true,     // set referer on redirect
                    CURLOPT_CONNECTTIMEOUT => 60,      // timeout on connect
                    CURLOPT_TIMEOUT => 60,      // timeout on response
                    CURLOPT_MAXREDIRS => 10       // stop after 10 redirects
                );
                self::$ch = curl_init();
                curl_setopt_array(self::$ch, $options);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $url
     * @param string $userToken
     * @param bool $flagHttps
     * @param array $headers
     * @return bool|string
     */
    public function get($url, $userToken = '', $flagHttps = false, $headers = [])
    {
        if (isset(self::$ch)) {
            curl_setopt(self::$ch, CURLOPT_URL, $url);
            curl_setopt(self::$ch, CURLOPT_HTTPGET, 1);
            //token
            if ($userToken != '') {
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $userToken));
            }
            if (!empty($header)) {
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $headers);
            }
            if ($flagHttps) {
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            $data = curl_exec(self::$ch);
            return $data;
        }
    }

    public function execUrlOnsite($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $url
     * @param $vars
     * @param string $userToken
     * @param bool $flagHttps
     * @param bool $flgJson
     * @return bool|string
     */
    public function post($url, $vars, $userToken = '', $flagHttps = false, $flgJson = true)
    {
        if (isset(self::$ch)) {
            curl_setopt(self::$ch, CURLOPT_URL, $url);
            curl_setopt(self::$ch, CURLOPT_POST, 1);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, json_encode($vars));
            curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Token: '.$userToken,
                    'Content-Length: ' . strlen(json_encode($vars)))
            );
            if ($flagHttps) {
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            $data = curl_exec(self::$ch);
            return $data;
        }
    }

    public function post2222($url, $vars, $userToken = '', $flagHttps = false, $flgJson = true)
    {
        if (isset(self::$ch)) {
            curl_setopt(self::$ch, CURLOPT_URL, $url);
            curl_setopt(self::$ch, CURLOPT_POST, 1);
            //neu yeu cau
            if ($userToken != '') {
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $userToken));
            }
            if ($flgJson) {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, json_encode($vars));
                curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen(json_encode($vars)))
                );
            } else {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $vars);
            }
            if ($flagHttps) {
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            $data = curl_exec(self::$ch);
            return $data;
        }
    }

    /**
     * @param $url
     * @param $vars
     * @param string $userToken
     * @param bool $flagHttps
     * @param bool $flgJson
     * @return bool|string
     */
    public function put($url, $vars, $userToken = '', $flagHttps = false, $flgJson = false)
    {
        if (isset(self::$ch)) {
            curl_setopt(self::$ch, CURLOPT_URL, $url);
            curl_setopt(self::$ch, CURLOPT_POST, 1);
            curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            //token
            if ($userToken != '') {
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $userToken));
            }
            if ($flgJson) {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, json_encode($vars));
                curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen(json_encode($vars)))
                );
            } else {
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $vars);
            }

            if ($flagHttps) {
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            $data = curl_exec(self::$ch);
            return $data;
        }
    }

    private function close()
    {
        if (isset(self::$ch)) {
            curl_close(self::$ch);
            //curl_reset(self::$ch);
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}