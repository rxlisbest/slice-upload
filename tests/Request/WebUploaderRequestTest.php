<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Tests\Request;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Request\WebUploaderRequest;

class WebUploaderRequestTest extends TestCase
{

    public function testGetKey()
    {
        $request = new WebUploaderRequest();
        $request->setKey('test.png');
        $this->assertEquals('test.png', $request->getKey());
    }

    public function testGetName()
    {
        $_POST['name'] = 'test.png';
        $request = new WebUploaderRequest();
        $request->setName();
        $this->assertEquals('test.png', $request->getName());
    }

    public function testGetChunk()
    {
        $_POST['chunk'] = 0;
        $request = new WebUploaderRequest();
        $request->setChunk();
        $this->assertEquals(0, $request->getChunk());
    }

    public function testGetChunks()
    {
        $_POST['chunks'] = 0;
        $request = new WebUploaderRequest();
        $request->setChunks();
        $this->assertEquals(0, $request->getChunks());
    }

    public function testGetTempDir()
    {
        $request = new WebUploaderRequest();
        $request->setTempDir();
        $this->assertEquals(sys_get_temp_dir(), $request->getTempDir());
    }

    public function testGetStream()
    {
        $_FILES['file']['tmp_name'] = '../../../composer.json';
        $request = new WebUploaderRequest();
        $request->setStream();
        $this->assertEquals(file_get_contents($_FILES['file']['tmp_name']), $request->getStream());
    }

    public function testSetKey()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setKey('test.png'));
    }

    public function testSetName()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setName());
    }

    public function testSetChunk()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setChunk());
    }

    public function testSetChunks()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setChunks());
    }

    public function testSetTempDir()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setTempDir());
    }

    public function testSetStream()
    {
        $request = new WebUploaderRequest();
        $this->assertInstanceOf(WebUploaderRequest::class, $request->setStream());
    }
}