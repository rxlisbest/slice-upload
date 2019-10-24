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
        $mock->allows('save')->once()->andReturn('success');
        $mock->allows('setKey')->andReturn($mock);
        $mock->allows('setChunk')->andReturn($mock);
        $mock->allows('setName')->andReturn($mock);
        $mock->allows('setChunks')->andReturn($mock);
        $mock->allows('setTempDir')->andReturn($mock);
        $mock->allows('setStream')->andReturn($mock);

        $requestMock = \Mockery::mock('\Rxlisbest\SliceUpload\Request\WebUploaderRequest');
        $requestMock->allows('getChunk')->once()->andReturn(0);
        $requestMock->allows('getChunks')->once()->andReturn(1);
        $requestMock->allows('getKey')->once()->andReturn('');
        $requestMock->allows('getName')->once()->andReturn('');
        $requestMock->allows('getTempDir')->once()->andReturn('');
        $requestMock->allows('getStream')->once()->andReturn('');

        $mock = \Mockery::mock('overload:\Rxlisbest\SliceUpload\RequestFactory');
        $mock->allows('create')->andReturn($requestMock);

        $sliceUpload = new SliceUpload('/');
        $this->assertEquals('success', $sliceUpload->save(''));
    }
}