<?php

namespace App\Services\NotificationViaSlack;

use Maknz\Slack\Client;
use Illuminate\Support\Facades\Route;

class NotificationViaSlackServices implements NotificationViaSlackInterface
{
    private $client = '';

    public function sendErrorToSlack($text = '')
    {
        $this->sendToSlack($text);
    }

    public function sendToSlack($text = '', $backtrace = null, $channelName = null)
    {
        if (trim($text) != '') {
            if (env('ENVIRONMENT') == 'DEV') {
                $chanel = env('CHANNEL_ERROR_BUG');
                $this->_client = new Client(env('SLACK_WEBHOOK_URL'));
                $data =  "EOP MESSAGE - \r\n ```" . var_export($text, true) . '```';
                $this->_client->send($data);
            } else {
//                \Log::error(print_r($text, true));
            }
        }
    }

    /**
     * NotificationViaSlackServices constructor.
     */

    /**
     * @param $exception
     */
    public function SendAttachmentFields($exception, $exceptionType)
    {
        $chanel = $exceptionType == 'PhpError' ? env('CHANNEL_ERROR_VIEW', '') : env('CHANNEL_ERROR_VIEW', '');
        self::connect($exceptionType, $chanel);
//        $trace = $exception->getTraceAsString();
//        $user = app('App\Models\Admin\User')->user_login();
//        $userEmail = ($user) ? $user['user_email'] : "";
//        $routeName = Route::currentRouteName();
//        $error = $exception->getMessage();
//        $baseLastUrl = basename(\Request::url());
//
//        $this->client->to($chanel)->attach([
//            'fallback' => 'Current server stats',
//            'text' => 'Current server stats',
//            'color' => 'danger',
//            'title' => 'Click here go to url link vaymuon error!!',
//            'title_link' => route($routeName, $baseLastUrl),
//            'fields' => [
//                [
//                    'title' => $userEmail . ' using route name ' . $routeName . ' Something went wrong.',
//                    'value' => '',
//                    'long' => true
//                ],
//                [
//                    'title' => $error,
//                    'value' => $trace,
//                    'long' => true
//                ]
//            ]
//        ])->send('New alert from the monitoring system'); // no message, but can be provided if you'd like
    }

    public function connect($exceptionType, $chanel)
    {
        $settings = [
            'username' => env('USER_NAME_WEBHOOK', ''),
            'channel' => $chanel,
            'link_names' => true,
            'icon' => ':ghost:'
        ];
        $this->client = new Client(env('SLACK_WEBHOOK_URL', ''), $settings);
    }
}
