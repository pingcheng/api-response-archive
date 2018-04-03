<?php

use PHPUnit\Framework\TestCase;
use PingCheng\ApiResponse\ApiResponse;

/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 3/4/18
 * Time: 11:29 PM
 */

class statusTraitTest extends TestCase
{
    private $data = [
        'data' => 'ok',
        'target' => 'test'
    ];

    private $status;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->status = require __DIR__.'/../src/Packet/statusCodes.php';
    }

    public function testAll() {
        $this->examJSON(ApiResponse::json()->success($this->data), 200);
        $this->examJSON(ApiResponse::json()->created($this->data), 201);
        $this->examJSON(ApiResponse::json()->error($this->data), 400);
        $this->examJSON(ApiResponse::json()->unauthorized($this->data), 401);
        $this->examJSON(ApiResponse::json()->forbidden($this->data), 403);
        $this->examJSON(ApiResponse::json()->notfound($this->data), 404);
        $this->examJSON(ApiResponse::json()->fatal($this->data), 500);
    }

    private function examJSON($result, $code) {
        $this->assertJson((string)$result);

        $result = json_decode($result);
        $this->assertEquals($result->code, $code);
        $this->assertEquals($result->status, $this->status[$code]);
        $this->assertEquals($result->data, (object)$this->data);
    }
}