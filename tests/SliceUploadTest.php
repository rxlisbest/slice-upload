<?php

namespace Rxlisbest\SliceUpload\Tests;

use PHPUnit\Framework\TestCase;
use Rxlisbest\PhpDate\PhpDate;
use Rxlisbest\SliceUpload\Request\WebUploaderRequest;
use Rxlisbest\SliceUpload\RequestFactory;
use Rxlisbest\SliceUpload\SliceUpload;
use Rxlisbest\SliceUpload\Storage;

class SliceUploadTest extends TestCase
{
    public function testSave()
    {
        $mock = \Mockery::mock('overload:' . Storage::class);
        $mock->allows('setKey')->andReturn($mock);
        $mock->allows('setRequest')->andReturn($mock);
        $mock->allows('save')->once()->andReturn('success');

        $requestMock = \Mockery::mock(WebUploaderRequest::class);

        $mock = \Mockery::mock('alias:' . RequestFactory::class);
        $mock->shouldReceive('create')->andReturn($requestMock);

        $sliceUpload = new SliceUpload('/');
        $this->assertEquals('success', $sliceUpload->save(''));
    }
}