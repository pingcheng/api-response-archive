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
        return json_encode($this->initResponse());
    }

    protected function setHeader()
    {
        header('Content-Type: application/json');
    }
}