<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 11:46 PM
 */

namespace PingCheng\ApiResponse\Packet;

abstract class PacketBase
{
    // contains all the status description
    protected $statusCodes = [];

    // the response data part
    protected $code = 0;
    protected $status = '';
    protected $data = null;
    protected $extra_attributes = [];

    // the key names
    protected $code_name = 'code';
    protected $status_name = 'status';
    protected $data_name = 'data';

    public $send_header = true;
    public $send_code = true;

    /**
     * process the data to the specific data format
     * @param $data
     * @return mixed
     */
    abstract protected function processData($data);

    /**
     * set up the html header if necessary
     */
    abstract protected function setHeader();

    function __construct($options)
    {
        $this->applyOptions($options);
        $this->statusCodes = require(__DIR__.'/statusCodes.php');
    }

    /**
     * set up the status code
     * @param $code
     * @return $this
     */
    public function code($code) {
        $this->code = $code;
        $this->status = $this->getStatus($code);
        return $this;
    }

    /**
     * set up the status description
     * @param $status
     * @return $this
     */
    public function status($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * set up the data (payload or message)
     * @param $data
     * @return $this
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * add an extra property
     * @param $name
     * @param $data
     * @return $this
     */
    public function addProperty($name, $data) {
        $this->extra_attributes[$name] = $data;
        return $this;
    }

    /**
     * remove a property
     * @param $name
     * @return $this
     */
    public function removeProperty($name) {
        if (isset($this->extra_attributes[$name])) {
            unset($this->extra_attributes[$name]);
        }
        return $this;
    }

    /**
     * output the final data
     * @return mixed
     */
    public function output() {
        if ($this->send_code) {
            http_response_code($this->code);
        }

        if ($this->send_header) {
            header($this->setHeader());
        }

        return $this->processData($this->data);
    }

    protected function initResponse() {
        $result = [
            $this->code_name => $this->code,
            $this->status_name => $this->status,
            $this->data_name => $this->data,
        ];

        foreach ($this->extra_attributes as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * get the status description based on the status code
     * @param $code
     * @return mixed|string
     */
    protected function getStatus($code) {
        if (isset($this->statusCodes[$code])) {
            return $this->statusCodes[$code];
        }
        return 'unknown';
    }

    /**
     * apply the option
     * @param $options
     */
    protected function applyOptions($options) {
        $this->send_header = isset($options['send_header']) ? $options['send_header'] : $this->send_header;
        $this->send_code = isset($options['send_code']) ? $options['send_code'] : $this->send_code;
    }
}