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
        $mock->shouldReceive('setChunk')->andReturn($mock);
        $mock->shouldReceive('setName')->andReturn($mock);
        $mock->shouldReceive('setChunks')->andReturn($mock);
        $mock->shouldReceive('setTempDir')->andReturn($mock);
        $mock->shouldReceive('setStream')->andReturn($mock);

        $requestMock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\Request\WebUploaderRequest');
        $requestMock->shouldReceive('getChunk')->once()->andReturn(0);
        $requestMock->shouldReceive('getChunks')->once()->andReturn(1);
        $requestMock->shouldReceive('getKey')->once()->andReturn('test.png');
        $requestMock->shouldReceive('getName')->andReturn('test.png');
        $requestMock->shouldReceive('getTempDir')->once()->andReturn('test.png');
        $requestMock->shouldReceive('getStream')->once()->andReturn('test.png');
        $requestMock->shouldReceive('setChunk')->once()->andReturn($requestMock);

        $mock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\RequestFactory');
        $mock->shouldAllowMockingProtectedMethods()->allows('getContentType')->andReturn('multipart/form-data');
        $mock->allows('create')->andReturn($requestMock);

        $sliceUpload = new SliceUpload('test');
        $this->assertEquals('a', $sliceUpload->save('1'));
    }
}