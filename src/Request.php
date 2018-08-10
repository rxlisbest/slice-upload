<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload;


class Request
{
    public $name; // 文件名称
    public $chunk; // 当前chunk数
    public $chunks; // chunk总数
    public $temp_dir;
    public $stream;


    public function __construct(){
    }

    public function setChunk(){
        $this->chunk = $_GET['chunk'];
        return $this;
    }

    public function setChunks(){
        $this->chunks = $_GET['chunks'];
        return $this;
    }

    public function setName(){
        $this->name = $_GET['name'];
        return $this;
    }

    public function setTempDir(){
        $this->temp_dir = sys_get_temp_dir();
        return $this;
    }

    public function setStream(){
        $this->stream = file_get_contents("php://input");
        return $this;
    }
}