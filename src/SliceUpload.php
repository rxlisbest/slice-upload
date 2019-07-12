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
    public function __construct($directory)
    {
        if (!$directory) {
            throw new \Exception("Directory can not be empty.");
        }
        $this->upload = new Storage($directory);
    }

    /**
     * 保存
     * @name: save
     * @param $key
     * @return void
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function save($key)
    {
        $factory = new RequestFactory();
        $request = $factory->create($key);
        return $this->upload
            ->setKey($request->getKey())
            ->setName($request->getName())
            ->setChunk($request->getChunk())
            ->setChunks($request->getChunks())
            ->setTempDir($request->getTempDir())
            ->setStream($request->getStream())
            ->save();
    }

    /**
     * 重命名文件
     * @name: rename
     * @param $old_key
     * @param $key
     * @return bool
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function rename($old_key, $key)
    {
        return $this->upload->rename($old_key, $key);
    }
}