<?php

namespace Rxlisbest\SliceUpload\Tests\Qiniu;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Qiniu\Request;

class RequestTest extends TestCase
{
    public function testGetChunk()
    {
        $_GET['chunk'] = 3;
        $double = \Mockery::mock(Request::class . '[]');
        $double->allows()->andReturnNull();
        $this->assertEquals(3, $double->getChunk());
    }

    public function testSetChunk()
    {
        $_GET['name'] = 'test.jpg';
        $request = new Request();
        $this->assertEquals('test.jpg', $request->getName());
    }

//    public function testSetStream()
//    {
//
//    }
}