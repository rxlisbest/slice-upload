<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Request;

use Psr\Http\Message\UploadedFileInterface;

class WebUploaderRequest implements UploadedFileChunkInterface
{
    /**
     * @return string
     */
    public function getStream(): string
    {
        return file_get_contents($_FILES['file']['tmp_name']);
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
        return $_POST['name'];
    }

    /**
     * @return mixed|string|null
     */
    public function getClientMediaType()
    {
        return $_FILES['file']['type'];
    }

    /**
     * @return int|mixed
     */
    public function getError()
    {
        return $_FILES['file']['error'];
    }

    /**
     * @param string $targetPath
     */
    public function moveTo($targetPath)
    {
        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            throw new \InvalidArgumentException('Invalid file');
        }
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)){
            throw new \RuntimeException('Upload failed');
        }
    }

    /**
     * @return int
     */
    public function getChunk(): int
    {
        return $_POST['chunk'] ?? 0;
    }

    /**
     * @return int
     */
    public function getChunks(): int
    {
        return $_POST['chunks'] ?? 1;
    }
}