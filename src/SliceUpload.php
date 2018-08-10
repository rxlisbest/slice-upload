<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload;


class SliceUpload
{
    protected $request;
    protected $upload;
    public function __construct($request = false)
    {
        if(!$request){
            $this->request = new Request();
        }
        else{
            $this->request = $request;
        }
        $this->upload = new Storage();
    }

    public function saveAs($filename){
        return $this->upload->setName($this->request->name)
                    ->setChunk($this->request->chunk)
                    ->setChunks($this->request->chunks)
                    ->setTempDir($this->request->temp_dir)
                    ->setStream($this->request->stream)
                    ->save($filename);
    }
}