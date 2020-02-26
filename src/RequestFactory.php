<?php


namespace Rxlisbest\SliceUpload;

use Rxlisbest\SliceUpload\Utils\Request;

class RequestFactory
{
    protected $request = [
        'multipart/form-data' => 'Rxlisbest\SliceUpload\Request\WebUploaderRequest',
        'application/octet-stream' => 'Rxlisbest\SliceUpload\Request\QiniuRequest',
    ];

    protected function getContentType(): string
    {
        $header = Request::getHeaders();
        $contentType = '';
        foreach ($header as $k => $v) {
            if (strtolower($k) == 'content-type') {
                $contentTypeArr = array_filter(explode(';', $v));
                $contentType = $contentTypeArr[0];
                break;
            }
        }
        return $contentType;
    }

    public function create(string $key): object
    {
        $contentType = $this->getContentType();
        if (isset($this->request[$contentType])) {
            $request = new $this->request[$contentType];
            return $request
                ->setKey($key)
                ->setName()
                ->setChunk()
                ->setTempDir()
                ->setStream();
        }
        throw new \Exception("Content-Type is not to be supported.");
    }
}