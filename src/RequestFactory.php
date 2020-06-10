<?php


namespace Rxlisbest\SliceUpload;

use Rxlisbest\SliceUpload\Exception\InvalidArgumentException;
use Rxlisbest\SliceUpload\Request\UploadedFileChunkInterface;
use Rxlisbest\SliceUpload\Utils\RequestUtils;

class RequestFactory
{
    protected static $request = [
        'multipart/form-data' => 'Rxlisbest\SliceUpload\Request\WebUploaderRequest',
        'application/octet-stream' => 'Rxlisbest\SliceUpload\Request\QiniuRequest',
    ];

    /**
     * @return string
     */
    protected static function getContentType(): string
    {
        $header = RequestUtils::getHeaders();
        $contentType = '';
        foreach ($header as $k => $v) {
            if (strtolower($k) == 'content-type' || strtolower($k) == 'content_type') {
                $contentTypeArr = array_filter(explode(';', $v));
                $contentType = $contentTypeArr[0];
                break;
            }
        }
        return $contentType;
    }

    /**
     * @return UploadedFileChunkInterface
     * @throws InvalidArgumentException
     */
    public static function create(): UploadedFileChunkInterface
    {
        $contentType = static::getContentType();
        if (!isset(static::$request[$contentType])) {
            throw new InvalidArgumentException("Content-Type is not to be supported.");
        }
        $request = new static::$request[$contentType];
        return $request;
    }
}