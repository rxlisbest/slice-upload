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
    private $chunk = 0; // 当前chunk数
    private $chunks = 1; // chunk总数
    private $temp_dir; // 临时目录
    private $stream; // 文件流

    /**
     * Storage constructor.
     */
    public function __construct(){}

    /**
     * 设置chunk
     * @name: setChunk
     * @param $chunk
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setChunk($chunk){
        if($chunk){
            $this->chunk = $chunk;
        }
        return $this;
    }

    /**
     * 设置chunks
     * @name: setChunks
     * @param $chunks
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setChunks($chunks){
        if($chunks){
            $this->chunks = $chunks;
        }
        return $this;
    }

    /**
     * 设置文件名称
     * @name: setName
     * @param $name
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setName($name){
        if(!$name){
            throw new \Exception("Name can not be empty.");
        }
        $this->name = $name;
        return $this;
    }

    /**
     * 设置临时目录
     * @name: setTempDir
     * @param $temp_dir
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setTempDir($temp_dir){
        if(!$temp_dir){
            throw new \Exception("Temp dir can not be empty.");
        }
        $this->temp_dir = $temp_dir;
        return $this;
    }

    /**
     * 设置流
     * @name: setStream
     * @param $stream
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setStream($stream){
        if(!$stream){
            throw new \Exception("Stream can not be empty.");
        }
        $this->stream = $stream;
        return $this;
    }

    /**
     * 保存文件
     * @name: save
     * @param $filename
     * @return void
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function save($filename){
        $merge = true;
        // 遍历检查分片是否全部上传
        for($i = 0; $i < $this->chunks; $i ++){
            if($this->chunk == $i){
                continue;
            }

            $slice_file = $this->getSliceFile($i);
            if(!is_file($slice_file)){ // 如果分片没有全部上传，则不合并文件
                $merge = false;
                break;
            }
        }

        if($merge){
            $full_file = $this->getFullFile();
            for($i = 0; $i < $this->chunks; $i ++){
                if($this->chunk == $i){ // 当前分片直接合并
                    $stream0 = $this->stream;
                    file_put_contents($full_file, $stream0, FILE_APPEND);
                }
                else{ // 非当前分片读取后合并
                    $slice_file = $this->getSliceFile($i);
                    $stream0 = file_get_contents($slice_file);
                    file_put_contents($full_file, $stream0, FILE_APPEND);
                    unlink($slice_file);
                }

            }
            $result = copy($full_file, $filename);
            unlink($full_file); // 删除合并后的文件
        }
        else{
            $slice_file = $this->getSliceFile($this->chunk);
            file_put_contents($slice_file, $this->stream);
        }
    }

    /**
     * 获取文件
     * @name: getFullFile
     * @return string
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function getFullFile(){
        return sprintf("%s%s", $this->temp_dir, $this->name);
    }

    /**
     * 获取分片文件
     * @name: getSliceFile
     * @param $chunk
     * @return string
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function getSliceFile($chunk){
        return sprintf("%s%s_%s", $this->temp_dir, $this->name, $chunk);
    }
}