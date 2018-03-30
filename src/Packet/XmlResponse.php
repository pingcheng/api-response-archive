<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 30/3/18
 * Time: 11:25 PM
 */

namespace PingCheng\ApiResponse\Packet;


use Spatie\ArrayToXml\ArrayToXml;

class XmlResponse extends PacketBase
{

    /**
     * process the data to the specific data format
     * @param $data
     * @return mixed
     */
    protected function processData($data)
    {
        return ArrayToXml::convert($this->initResponse());
    }

    /**
     * set up the html header if necessary
     */
    protected function setHeader()
    {
        header("Content-type: text/xml");
    }
}