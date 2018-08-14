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
        // 判断文件是否存在
        if(is_file($filename)){
            throw new \Exception("File already exist.");
        }
        // upload
        $slice_file = $this->getSliceFile($filename, $this->chunk);
        $result = file_put_contents($slice_file, $this->stream);
        if(!$result){
            return $result;
        }
        else{
            if(!$result = $this->createVerifyFile($slice_file)){
                return $result;
            }
        }

        // 遍历检查分片是否全部上传
        $merge = true;
        for($i = 0; $i < $this->chunks; $i ++){
            $slice_file = $this->getSliceFile($filename, $i);
            if(!is_file($slice_file) || !($md5 = $this->getVerifyFileContent($slice_file)) || md5_file($slice_file) != $md5){ // 如果分片没有全部上传，则不合并文件
                $merge = false;
                break;
            }
        }

        if($merge){
            $result = true; // 返回值
            // 增加并发状态的文件锁
            $lock_file = $this->getLockFile();
            $fp = fopen($this->getLockFile(), 'w+');
            if(flock($fp, LOCK_EX | LOCK_NB)){
                for($i = 0; $i < $this->chunks; $i ++){
                    $slice_file = $this->getSliceFile($filename, $i);
                    $stream0 = file_get_contents($slice_file);
                    $result = $result && file_put_contents($filename, $stream0, FILE_APPEND);
                    if($result){
                        $this->deleteVerifyFile($slice_file);
                        unlink($slice_file);
                    }
                }
                flock($fp, LOCK_UN);
                fclose($fp);
                unlink($lock_file);
                return $result;
            }
            fclose($fp);
        }
        return $result;
    }

    /**
     * 获取分片文件
     * @name: getSliceFile
     * @param $chunk
     * @return string
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function getSliceFile($filename, $chunk){
        return sprintf("%s_%s", $filename, $chunk);
    }

    /**
     * 获取文件锁
     * @name: getLockFile
     * @return string
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function getLockFile(){
        return sprintf("%s%s.lock", $this->temp_dir, md5($this->name));
    }

    /**
     * 获取验证文件
     * @name: getVerifyFileContent
     * @param $filename
     * @return bool|string
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function getVerifyFileContent($filename){
        $md5 = md5_file($filename);
        $md5_filename = sprintf("%smd5_%s", $this->temp_dir, $md5);
        if($result = is_file($md5_filename)){
            return file_get_contents($md5_filename);
        }
        return $result;
    }

    /**
     * 创建验证文件
     * @name: createVerifyFile
     * @param $filename
     * @return bool|int
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function createVerifyFile($filename){
        $md5 = md5_file($filename);
        $md5_filename = sprintf("%smd5_%s", $this->temp_dir, $md5);
        return file_put_contents($md5_filename, $md5);
    }

    /**
     * 删除验证文件
     * @name: deleteVerifyFile
     * @param $filename
     * @return bool
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    private function deleteVerifyFile($filename){
        $md5 = md5_file($filename);
        $md5_filename = sprintf("%smd5_%s", $this->temp_dir, $md5);
        return unlink($md5_filename);
    }
}