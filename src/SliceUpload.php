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
        $this->storage = $this->initStorage($directory);
    }

    protected function initStorage($directory)
    {
        return new Storage($directory);
    }

    protected function initRequest($key)
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
        $request = $this->initRequest($key);
        return $this->storage
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
        return $this->storage->rename($old_key, $key);
    }
}