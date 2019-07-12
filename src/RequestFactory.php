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
        $content_type = '';
        foreach ($header as $k => $v) {
            if (strtolower($k) == 'content-type') {
                $content_type = $v;
                break;
            }
        }
        return $content_type;
    }

    public function create($key)
    {
        $content_type = $this->getContentType();

        if (isset($this->request[$content_type])) {
            $request = new $this->request[$content_type];
            $this->setKey($key)
                ->setName()
                ->setChunk()
                ->setChunks()
                ->setTempDir()
                ->setStream();
            return new $this->request[$content_type];
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