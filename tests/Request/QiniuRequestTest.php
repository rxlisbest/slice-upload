<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Tests\Request;

use PHPUnit\Framework\TestCase;
use Rxlisbest\SliceUpload\Request\QiniuRequest;

class QiniuRequestTest extends TestCase
{

    public function testGetKey()
    {
        $request = new QiniuRequest();
        $request->setKey('test.png');
        $this->assertEquals('test.png', $request->getKey());
    }

    public function testGetName()
    {
        $_GET['name'] = 'test.png';
        $request = new QiniuRequest();
        $request->setName();
        $this->assertEquals('test.png', $request->getName());
    }

    public function testGetChunk()
    {
        $_GET['chunk'] = 0;
        $request = new QiniuRequest();
        $request->setChunk();
        $this->assertEquals(0, $request->getChunk());
    }

    public function testGetChunks()
    {
        $_GET['chunks'] = 0;
        $request = new QiniuRequest();
        $request->setChunks();
        $this->assertEquals(0, $request->getChunks());
    }

    public function testGetTempDir()
    {
        $request = new QiniuRequest();
        $request->setTempDir();
        $this->assertEquals(sys_get_temp_dir(), $request->getTempDir());
    }

    public function testGetStream()
    {
        $request = new QiniuRequest();
        $request->setStream();
        $this->assertEquals(file_get_contents("php://input"), $request->getStream());
    }

    public function testSetKey()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setKey('test.png'));
    }

    public function testSetName()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setName());
    }

    public function testSetChunk()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setChunk());
    }

    public function testSetChunks()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setChunks());
    }

    public function testSetTempDir()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setTempDir());
    }

    public function testSetStream()
    {
        $request = new QiniuRequest();
        $this->assertInstanceOf(QiniuRequest::class, $request->setStream());
    }
}