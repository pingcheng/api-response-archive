<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 11:46 PM
 */

namespace PingCheng\ApiResponse\Packet;

use PingCheng\ApiResponse\Traits\statusShortcuts;

abstract class PacketBase
{

    use statusShortcuts;

    // settings
    public $send_header = true;
    public $send_code = true;


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

    // headers
    protected $headers = [];

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
     * add a new header
     * @param $name
     * @param $value
     * @return $this
     */
    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * remove a header
     * @param $name
     * @return $this
     */
    public function removeHeader($name) {
        if (isset($this->headers[$name])) {
            unset($this->headers[$name]);
        }
        return $this;
    }

    /**
     * remove all headers
     * @return $this
     */
    public function removeAllHeaders() {
        $this->headers = [];
        header_remove();
        return $this;
    }

    /**
     * output the final data
     * @return mixed
     */
    public function output() {
        $this->initResponseCode();
        $this->initHeaders();

        return $this->processData($this->data);
    }

    /**
     * prepare the response code
     */
    protected function initResponseCode() {
        if ($this->send_code) {
            http_response_code($this->code);
        }
    }

    /**
     * prepare the response headers
     */
    protected function initHeaders() {
        if ($this->send_header) {
            // setup the default headers
            header($this->setHeader());

            // setup other headers
            if (!empty($this->headers)) {
                foreach ($this->headers as $name => $value) {
                    header("$name: $value");
                }
            }
        } else {
            // remove headers
            header_remove();
        }
    }

    /**
     * init the response body
     * @return array
     */
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
        $this->headers = isset($options['headers']) ? $options['headers'] : $this->headers;
    }

    /**
     * Magic method
     * to parse this object to a text response
     * automatically call the output method
     * @return mixed
     */
    public function __toString()
    {
        return $this->output();
    }

    /**
     * send the message and die
     */
    public function send() {
        die($this->output());
    }
}