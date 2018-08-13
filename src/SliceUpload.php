<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload;

use Rxlisbest\SliceUpload\WebUploader\Request;

class SliceUpload
{
    protected $request; // 请求类
    protected $upload; // 上传类

    /**
     * SliceUpload constructor.
     * @param bool $request
     */
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

    /**
     * 保存
     * @name: saveAs
     * @param $filename
     * @return void
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function saveAs($filename){
        return $this->upload->setName($this->request->name)
                    ->setChunk($this->request->chunk)
                    ->setChunks($this->request->chunks)
                    ->setTempDir($this->request->temp_dir)
                    ->setStream($this->request->stream)
                    ->save($filename);
    }
}