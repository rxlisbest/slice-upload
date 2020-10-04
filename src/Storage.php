<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午1:52
 */

namespace Rxlisbest\SliceUpload;

use Rxlisbest\SliceUpload\Exception\InvalidArgumentException;
use Rxlisbest\SliceUpload\Exception\RuntimeException;
use Rxlisbest\SliceUpload\Exception\StorageException;
use Rxlisbest\SliceUpload\Request\UploadedFileChunkInterface;

define('DS', DIRECTORY_SEPARATOR);

class Storage
{
    const STATUS_SLICE_SUCCESS = 'slice_success';
    const STATUS_SLICE_FAILURE = 'slice_failure';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILURE = 'failure';

    private UploadedFileChunkInterface $request; // 存储目录
    private string $dir; // 存储目录

    /**
     * Storage constructor.
     * @param string $directory
     * @throws InvalidArgumentException
     */
    public function __construct(string $directory)
    {
        if (!$directory) {
            throw new InvalidArgumentException("Directory can not be empty.");
        }
        $this->dir = $directory;
    }

    /**
     * @param string $key
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setKey(string $key): self
    {
        if (!$key) {
            throw new InvalidArgumentException("Key can not be empty.");
        }
        $this->key = $key;
        return $this;
    }

    /**
     * @param UploadedFileChunkInterface $request
     * @return $this
     */
    public function setRequest(UploadedFileChunkInterface $request): self
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return string
     * @throws StorageException
     */
    public function save(): string
    {
        $filename = $this->dir . DS . $this->key;
        // 判断文件是否存在
        if (is_file($filename)) {
            throw new StorageException("File already exist.");
        }
        // upload
        $sliceFile = $this->getSliceFile($filename, $this->request->getChunk());
        try {
            $this->request->moveTo($sliceFile);
        } catch (InvalidArgumentException | RuntimeException $e) {
            if ($this->request->getChunks() > 1) {
                return self::STATUS_FAILURE;
            } else {
                return self::STATUS_SLICE_FAILURE;
            }
        } finally {
            if (!$result = $this->createVerifyFile($sliceFile)) {
                if ($this->request->getChunks() > 1) {
                    return self::STATUS_FAILURE;
                } else {
                    return self::STATUS_SLICE_FAILURE;
                }
            }
        }

        // 遍历检查分片是否全部上传
        $merge = true;
        for ($i = 0; $i < $this->request->getChunks(); $i++) {
            $sliceFile = $this->getSliceFile($filename, $i);
            if (!is_file($sliceFile) || !($md5 = $this->getVerifyFileContent($sliceFile)) || md5_file($sliceFile) != $md5) { // 如果分片没有全部上传，则不合并文件
                $merge = false;
                break;
            }
        }

        if ($merge) {
            $result = true; // 返回值
            // 增加并发状态的文件锁
            $lockFile = $this->getLockFile();
            $fp = fopen($this->getLockFile(), 'w+');
            if (flock($fp, LOCK_EX | LOCK_NB)) {
                for ($i = 0; $i < $this->request->getChunks(); $i++) {
                    $sliceFile = $this->getSliceFile($filename, $i);
                    $stream0 = file_get_contents($sliceFile);
                    $result = $result && file_put_contents($filename, $stream0, FILE_APPEND);
                    if ($result) {
                        $this->deleteVerifyFile($sliceFile);
                        unlink($sliceFile);
                    }
                }
                flock($fp, LOCK_UN);
                fclose($fp);
                unlink($lockFile);

                if ($result) {
                    return self::STATUS_SUCCESS;
                } else {
                    return self::STATUS_FAILURE;
                }
            }
            fclose($fp);
        }

        if ($this->request->getChunks() > 1) {
            return self::STATUS_SLICE_SUCCESS;
        } else {
            return self::STATUS_SUCCESS;
        }
    }

    /**
     * @param string $filename
     * @param int $chunk
     * @return string
     */
    private function getSliceFile(string $filename, int $chunk): string
    {
        return sprintf("%s_%d", $filename, $chunk);
    }

    /**
     * @return string
     */
    private function getLockFile(): string
    {
        return sprintf("%s/%s.lock", $this->dir, md5($this->key));
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getVerifyFileContent(string $filename): string
    {
        $md5 = md5_file($filename);
        $md5Filename = sprintf("%s/md5_%s", $this->dir, $md5);
        if ($result = is_file($md5Filename)) {
            return file_get_contents($md5Filename);
        }
        return $result;
    }

    /**
     * @param string $filename
     * @return string
     */
    private function createVerifyFile(string $filename): string
    {
        $md5 = md5_file($filename);
        $md5Filename = sprintf("%s/md5_%s", $this->dir, $md5);
        return file_put_contents($md5Filename, $md5);
    }

    /**
     * @param string $filename
     * @return string
     */
    private function deleteVerifyFile(string $filename): string
    {
        $md5 = md5_file($filename);
        $md5Filename = sprintf("%s/md5_%s", $this->dir, $md5);
        return unlink($md5Filename);
    }

    /**
     * @param string $oldKey
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     * @throws StorageException
     */
    public function rename(string $oldKey, string $key): string
    {
        if (!$key) {
            throw new InvalidArgumentException("New file name can not be empty.");
        }
        $oldFilename = $this->dir . DS . $oldKey;
        if (!is_file($oldFilename)) {
            throw new StorageException("Source file is not exist.");
        }

        $newFilename = $this->dir . DS . $key;
        if (is_file($newFilename)) {
            throw new StorageException("Renamed file is already exist.");
        }
        return rename($oldFilename, $newFilename);
    }
}