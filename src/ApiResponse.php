<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 12:00 AM
 */

namespace PingCheng\ApiResponse;

use stdClass;

class ApiResponse
{
    private $statusCodes = [];

    public static function response($statusCode, $data) {
        $api = new static();
        $response = $api->initResponse($statusCode);
        $response->data = $data;

        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public static function success($data) {
        return static::response(200, $data);
    }

    public static function created($data) {
        return static::response(201, $data);
    }

    public static function error($data) {
        return static::response(400, $data);
    }

    public static function unauthorized($data) {
        return static::response(401, $data);
    }

    public static function forbidden($data) {
        return static::response(403, $data);
    }

    public static function notfound($data) {
        return static::response(404, $data);
    }

    public static function fatal($data) {
        return static::response(500, $data);
    }

    function __construct() {
        $this->statusCodes = require(__DIR__.'/statusCodes.php');
    }

    protected function initResponse($code) {
        $response = new stdClass();
        $response->statusCode = $code;
        $response->status = $this->getStatus($code);
        $response->data = null;

        return $response;
    }

    protected function getStatus($code) {
        if (isset($this->statusCodes[$code])) {
            return $this->statusCodes[$code];
        }
        return 'unknown';
    }
}