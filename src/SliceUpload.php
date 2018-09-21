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
    protected $request; // 请求类
    protected $upload; // 上传类

    /**
     * SliceUpload constructor.
     * @param bool $request
     */
    public function __construct($directory, $key = '')
    {
        if (!$directory) {
            throw new Exception("Directory can not be empty.");
        }

        $header = getallheaders();

        if (strpos($header['Content-Type'], 'multipart/form-data') !== false) {
            $request = new \Rxlisbest\SliceUpload\WebUploader\Request();
        } else if (strpos($header['Content-Type'], 'application/octet-stream') !== false) {

            $request = new \Rxlisbest\SliceUpload\Qiniu\Request();
        } else {
            throw new Exception("Content-Type is not to be supported

.");
        }
        $request->setKey($key);
        $this->request = $request;
        $this->upload = new Storage($directory);
    }

    /**
     * 保存
     * @name: save
     * @param $filename
     * @return void
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function save()
    {
        return $this->upload
            ->setKey($this->request->key)
            ->setName($this->request->name)
            ->setChunk($this->request->chunk)
            ->setChunks($this->request->chunks)
            ->setTempDir($this->request->temp_dir)
            ->setStream($this->request->stream)
            ->save();
    }
}

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}