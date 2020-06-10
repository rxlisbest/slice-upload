<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Request;

use http\Exception\InvalidArgumentException;
use http\Exception\RuntimeException;
use Psr\Http\Message\UploadedFileInterface;

class QiniuRequest implements UploadedFileChunkInterface
{
    /**
     * @return string
     */
    public function getStream(): string
    {
        return file_get_contents("php://input");
    }

    /**
     * @return int|mixed|null
     */
    public function getSize()
    {
        return $_FILES['file']['size'];
    }

    /**
     * @return mixed|string|null
     */
    public function getClientFilename()
    {
        return $_GET['name'];
    }

    /**
     * @return string|null
     */
    public function getClientMediaType()
    {
        return mime_content_type($_GET['name']);
    }

    /**
     * @return int
     */
    public function getError()
    {
        return UPLOAD_ERR_OK;
    }

    /**
     * @param string $targetPath
     * @return false|int
     */
    public function moveTo($targetPath)
    {
        if (!file_get_contents("php://input")) {
            throw new InvalidArgumentException('Invalid file');
        }
        if (!$res = file_put_contents($targetPath, file_get_contents("php://input"))) {
            throw new RuntimeException('Upload failed');
        }
        return $res;
    }

    /**
     * @return int
     */
    public function getChunk(): int
    {
        return $_GET['chunk'] ?? 0;
    }

    /**
     * @return int
     */
    public function getChunks(): int
    {
        return $_GET['chunks'] ?? 1;
    }
}