<?php
use PHPUnit\Framework\TestCase;
use PingCheng\ApiResponse\ApiResponse;

class JsonTest extends TestCase
{
    private $testing_data = [
        'key' => 'testing',
        'collection' => [
            'line1',
            'line2'
        ]
    ];

    public function testSuccess() {
        $result = ApiResponse::json()
            ->code(200)
            ->data($this->testing_data)
            ->status('test status')
            ->addProperty('newkey', 'newdata')
            ->addProperty('hello', 'hello')
            ->removeProperty('hello')
            ->output();
        $this->examJsonResult($result, 200, $this->testing_data);
    }

    public function testError() {
        $result = ApiResponse::json()
            ->code(400)
            ->data($this->testing_data)
            ->status('test status')
            ->output();
        $this->examJsonResult($result, 400, $this->testing_data);
    }

    public function testFatal() {
        $result = ApiResponse::json()
            ->code(500)
            ->data($this->testing_data)
            ->status('test status')
            ->output() ;
        $this->examJsonResult($result, 500, $this->testing_data);
    }

    public function testUnknown() {
        $result = ApiResponse::json()
            ->code(900)
            ->data($this->testing_data)
            ->output();
        $result = $this->examJsonResult($result, 900, $this->testing_data);
        $this->assertEquals('unknown', $result->status);
    }

    public function testHeader() {
        ApiResponse::json()
            ->code(200)
            ->addHeader('test', 'testing-header')
            ->addHeader('test-deleted', '-')
            ->removeHeader('test-deleted')
            ->output();

        $headers = xdebug_get_headers();
        $this->assertContains('test: testing-header', $headers);
        $this->assertNotContains('test-deleted: -', $headers);
    }

    public function testSettingHeaders() {
        ApiResponse::send_header(false);
        ApiResponse::json()
            ->code(200)
            ->output();

        $headers = xdebug_get_headers();
        $this->assertEmpty($headers);
    }

    public function testSettingCode() {
        ApiResponse::send_status_code(false);
        ApiResponse::json()
            ->code(300)
            ->output();
        $this->assertFalse(http_response_code());
    }

    protected function examJsonResult($result, $code = false, $data = null) {
        $this->assertJson($result);

        $json = json_decode($result);
        $this->assertObjectHasAttribute('code', $json);
        $this->assertObjectHasAttribute('status', $json);
        $this->assertObjectHasAttribute('data', $json);

        if ($code) {
            $this->assertEquals($code, $json->code);
            $this->assertEquals($code, http_response_code());
        }

        if (!is_null($data)) {
            $this->assertJsonStringEqualsJsonString(json_encode($data), json_encode($json->data));
        }

        return $json;
    }
}