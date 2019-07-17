<?php

namespace Rxlisbest\SliceUpload\Tests\Qiniu;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Request\QiniuRequest;

class QiniuRequestTest extends TestCase
{
    public function testGetChunk()
    {
//        $_GET['chunk'] = 3;
        $double = \Mockery::mock(QiniuRequest::class);
        $double->shouldAllowMockingProtectedMethods()->allows('getChunk');
//        $double->setChunk();
        $this->assertEquals(null, $double->getChunk());
    }

//    public function testSetChunk()
//    {
//        $_GET['name'] = 'test.jpg';
//        $request = new QiniuRequest();
//        $this->assertEquals('test.jpg', $request->getName());
//    }

//    public function testSetStream()
//    {
//
//    }
}