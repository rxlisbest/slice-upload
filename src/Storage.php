<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午1:52
 */

namespace Rxlisbest\SliceUpload;


class Storage
{
    private $name; // 文件名称
    private $chunk; // 当前chunk数
    private $chunks; // chunk总数
    private $temp_dir;
    private $stream;

    public function __construct(){}

    public function setChunk($chunk){
        $this->chunk = $chunk;
        return $this;
    }

    public function setChunks($chunks){
        $this->chunks = $chunks;
        return $this;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setTempDir($temp_dir){
        $this->temp_dir = $temp_dir;
        return $this;
    }

    public function setStream($stream){
        $this->stream = $stream;
        return $this;
    }

    public function save($filename){
        if($this->chunk + 1 == $this->chunks){ // 最后一个chunk
            $full_file = $this->getFullFile();
            for($i = 0; $i < $this->chunks - 1; $i ++){
                $slice_file = $this->getSliceFile($i);
                $stream0 = file_get_contents($slice_file);
                file_put_contents($full_file, $stream0, FILE_APPEND);
                unlink($slice_file);
            }
            file_put_contents($full_file, $stream, FILE_APPEND);
            move_uploaded_file($full_file, $filename);
            unlink($full_file);
        }
        else{
            $slice_file = $this->getSliceFile($this->chunk);
            file_put_contents($slice_file, $stream);
        }
    }

    private function getFullFile(){
        return sprintf("%s%s", $this->temp_dir, $this->name);
    }

    private function getSliceFile($chunk){
        return sprintf("%s%s_%s", $this->temp_dir, $this->name, $chunk);
    }

    public function getStream(){
        return file_get_contents("php://input");
    }
}