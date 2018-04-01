<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 12:00 AM
 */

namespace PingCheng\ApiResponse;

use PingCheng\ApiResponse\Packet\JsonResponse;
use PingCheng\ApiResponse\Packet\XmlResponse;

class ApiResponse
{
    protected static $send_header = true;
    protected static $send_code = true;
    protected static $headers = [];

    /**
     * return the result in json format
     * @return JsonResponse
     */
    public static function json() {
        return new JsonResponse(static::initOptions());
    }

    /**
     * return the reuslt in xml format
     * @return XmlResponse
     */
    public static function xml() {
        return new XmlResponse(static::initOptions());
    }

    /**
     * set if sending the headers
     * @param bool $trueOrfalse
     */
    public static function send_header($trueOrfalse = true) {
        static::$send_header = $trueOrfalse;
    }

    /**
     * set if send status code
     * @param bool $trueOrfalse
     */
    public static function send_status_code($trueOrfalse = true) {
        static::$send_code = $trueOrfalse;
    }

    /**
     * set up the headers
     * @param array $headers
     */
    public static function headers($headers = []) {
        static::$headers = $headers;
    }

    /**
     * init the option based on the setting
     * @return array
     */
    protected static function initOptions() {
        return [
            'send_header' => static::$send_header,
            'send_code' => static::$send_code,
            'headers' => static::$headers,
        ];
    }
}