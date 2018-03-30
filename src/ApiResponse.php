<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 12:00 AM
 */

namespace PingCheng\ApiResponse;

use PingCheng\ApiResponse\Packet\JsonResponse;

class ApiResponse
{
    protected static $send_header = true;
    protected static $send_code = true;

    /**
     * return the result in json format
     * @return JsonResponse
     */
    public static function json() {
        return new JsonResponse(static::initOptions());
    }

    public static function send_header($trueOrfalse = true) {
        static::$send_header = $trueOrfalse;
    }

    public static function send_status_code($trueOrfalse = true) {
        static::$send_header = $trueOrfalse;
    }

    /**
     * init the option based on the setting
     * @return array
     */
    protected static function initOptions() {
        return [
            'send_header' => static::$send_header,
            'send_code' => static::$send_code,
        ];
    }
}