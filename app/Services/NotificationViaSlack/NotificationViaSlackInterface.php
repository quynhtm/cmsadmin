<?php

namespace App\Services\NotificationViaSlack;

interface NotificationViaSlackInterface
{

    /**
     * @param $exception
     * @param $exceptionType
     * @return mixed
     */
    public function SendAttachmentFields($exception, $exceptionType);

    /**
     * @param $exceptionType
     * @param $chanel
     * @return mixed
     */
    public function connect($exceptionType, $chanel);
}