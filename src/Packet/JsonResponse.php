<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 29/3/18
 * Time: 11:49 PM
 */

namespace PingCheng\ApiResponse\Packet;

class JsonResponse extends PacketBase
{

    protected function processData($data)
    {
        $result = [
            $this->code_name => $this->code,
            $this->status_name => $this->status,
            $this->data_name => $this->data,
        ];

        foreach ($this->extra_attributes as $key => $value) {
            $result[$key] = $value;
        }

        return json_encode($result);
    }

    protected function setHeader()
    {
        header('Content-Type: application/json');
    }
}