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
    protected $storage; // 存储类

    /**
     * SliceUpload constructor.
     * @param bool $request
     */
    public function __construct($directory)
    {
        if (!$directory) {
            throw new \Exception("Directory can not be empty.");
        }
        $this->storage = $this->initStorage();
        $this->request = $this->initRequest();
    }

    protected function initStorage()
    {
        return new Storage($directory);
    }

    protected function initRequest()
    {
        $factory = new RequestFactory();
        return $factory->create($key);
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
        return $this->storage
            ->setKey($this->request->getKey())
            ->setName($this->request->getName())
            ->setChunk($this->request->getChunk())
            ->setChunks($this->request->getChunks())
            ->setTempDir($this->request->getTempDir())
            ->setStream($this->request->getStream())
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
        return $this->storage->rename($old_key, $key);
    }
}