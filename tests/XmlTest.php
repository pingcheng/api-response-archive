<?php

use PHPUnit\Framework\TestCase;
use PingCheng\ApiResponse\ApiResponse;

/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 31/3/18
 * Time: 11:48 PM
 */

class XmlTest extends TestCase
{
    protected $testing_data = [
        'key' => 'testing',
        'collection' => [
            'line1',
            'line2'
        ]
    ];
    protected $expected_xml = "<?xml version=\"1.0\"?><root><code>200</code><status>OK!</status><data></data><extrastatus>ok</extrastatus></root>";

    /**
     *  TODO, this test need to be refined
     */
    public function testXML() {
        $result = ApiResponse::xml()
            ->code(200)
            ->status('OK!')
            ->addProperty('extrastatus', 'ok')
            ->addProperty('extra', '')
            ->removeProperty('extra')
            ->output();
        $this->assertXmlStringEqualsXmlString($this->expected_xml, $result);
    }
}