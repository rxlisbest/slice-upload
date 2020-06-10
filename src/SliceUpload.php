<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload;

use Rxlisbest\SliceUpload\Exception\InvalidArgumentException;
use Rxlisbest\SliceUpload\Request\WebUploaderRequest;

class SliceUpload
{
    protected Storage $storage; // 存储类

    /**
     * SliceUpload constructor.
     * @param string $directory
     * @throws InvalidArgumentException
     */
    public function __construct(string $directory)
    {
        if (!$directory) {
            throw new InvalidArgumentException("Directory can not be empty.");
        }
        $this->storage = $this->initStorage($directory);
    }

    /**
     * @param string $directory
     * @return Storage
     * @throws InvalidArgumentException
     */
    protected function initStorage(string $directory): Storage
    {
        return new Storage($directory);
    }

    public function save($key): string
    {
        $request = RequestFactory::create();
        return $this->storage
            ->setRequest($request)
            ->setKey($key)
            ->save();
    }

    /**
     * @param $oldKey
     * @param $key
     * @return string
     * @throws Exception\StorageException
     * @throws InvalidArgumentException
     */
    public function rename($oldKey, $key): string
    {
        return $this->storage->rename($oldKey, $key);
    }
}