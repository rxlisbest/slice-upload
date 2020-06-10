<?php


namespace Rxlisbest\SliceUpload\Request;

use Psr\Http\Message\UploadedFileInterface;

interface UploadedFileChunkInterface extends UploadedFileInterface
{
    public function getChunk(): int;

    public function getChunks(): int;
}