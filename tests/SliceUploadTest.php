<?php

namespace Rxlisbest\SliceUpload\Tests;

use PHPUnit\Framework\TestCase;
use Rxlisbest\PhpDate\PhpDate;
use Rxlisbest\SliceUpload\Request\WebUploaderRequest;
use Rxlisbest\SliceUpload\SliceUpload;
use Rxlisbest\SliceUpload\Storage;

class SliceUploadTest extends TestCase
{
    
    public function testSave()
    {
        $mock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\Storage');
        $mock->shouldReceive('save')->once()->andReturn('a');
        $mock->shouldReceive('setKey')->andReturn($mock);
        $mock->shouldReceive('setName');

        $requestMock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\Request\WebUploaderRequest');
        $requestMock->shouldReceive('getChunk')->once()->andReturn(0);
        $requestMock->shouldReceive('getChunks')->once()->andReturn(1);
        $requestMock->shouldReceive('getKey')->once()->andReturn('test.png');
        $requestMock->shouldReceive('getName')->andReturn('test.png');
        $requestMock->shouldReceive('getTempDir')->once()->andReturn('test.png');
        $requestMock->shouldReceive('getStream')->once()->andReturn('test.png');

        $mock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\RequestFactory');
        $mock->shouldAllowMockingProtectedMethods()->allows('getContentType')->andReturn('multipart/form-data');
//        $mock->allows('getContentType')->andReturn('multipart/form-data');
        $mock->shouldReceive('setKey')->andReturn($requestMock);
        $mock->shouldReceive('setName')->andReturn($requestMock);
        $mock->shouldReceive('setChunk')->andReturn($requestMock);
        $mock->shouldReceive('setChunks')->andReturn($requestMock);
        $mock->shouldReceive('setTempDir')->andReturn($requestMock);
        $mock->shouldReceive('setStream')->andReturn($requestMock);
        $mock->allows('create')->andReturn($requestMock);

        $sliceUpload = new SliceUpload('test');
//        $this->assertEquals('a', $sliceUpload->save('1'));
    }
}