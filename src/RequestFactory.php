<?php


namespace Rxlisbest\SliceUpload;


class RequestFactory
{
    protected $request = [
        'multipart/form-data' => 'Rxlisbest\SliceUpload\Request\WebUploaderRequest',
        'application/octet-stream' => 'Rxlisbest\SliceUpload\Request\QiniuRequest',
    ];

    protected function getContentType()
    {
        $header = getallheaders();
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

    public function create($key)
    {
        $contentType = $this->getContentType();
        if (isset($this->request[$contentType])) {
            $reflection = new \ReflectionClass($this->request[$contentType]);
            $request = $reflection->newInstanceArgs();
            return $request->setKey($key)->setName()->setChunk()->setTempDir()->setStream();
        }
        throw new \Exception("Content-Type is not to be supported.");
    }
}

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}