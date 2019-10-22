<?php

namespace Rxlisbest\SliceUpload\Tests\Qiniu;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Request\QiniuRequest;

class WebUploaderRequestTest extends TestCase
{

    public function testGetChunk()
    {
        $double = \Mockery::mock(QiniuRequest::class);
        $double->shouldAllowMockingProtectedMethods()->allows('getChunk');
        $this->assertEquals(null, $double->getChunk());
    }

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