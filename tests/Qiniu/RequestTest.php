<?php

namespace Rxlisbest\SliceUpload\Tests\Qiniu;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Request\QiniuRequest;

class RequestTest extends TestCase
{
//    public function testGetChunk()
//    {
//        $_GET['chunk'] = 3;
//        $double = \Mockery::spy(Request::class);
//        $double->allows()->andReturnNull();
//        $double->shouldAllowMockingProtectedMethods()->setChunk();
//        $this->assertEquals(3, $double->getChunk());
//    }

    public function testSetChunk()
    {
        $_GET['name'] = 'test.jpg';
        $request = new QiniuRequest();
        $this->assertEquals('test.jpg', $request->getName());
    }

//    public function testSetStream()
//    {
//
//    }
}