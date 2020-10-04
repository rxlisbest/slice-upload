<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Request;

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
     * @return int
     */
    public function getSize(): int
    {
        return $_FILES['file']['size'];
    }

    /**
     * @return string
     */
    public function getClientFilename(): string
    {
        return $_GET['name'];
    }

    /**
     * @return string
     */
    public function getClientMediaType(): string
    {
        return mime_content_type($_GET['name']);
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return UPLOAD_ERR_OK;
    }

    /**
     * @param string $targetPath
     */
    public function moveTo($targetPath)
    {
        if (!file_get_contents("php://input")) {
            throw new \InvalidArgumentException('Invalid file');
        }
        if (!file_put_contents($targetPath, file_get_contents("php://input"))) {
            throw new \RuntimeException('Upload failed');
        }
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