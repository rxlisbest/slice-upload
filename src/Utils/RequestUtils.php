<?php
namespace Rxlisbest\SliceUpload\Utils;

class RequestUtils
{
    /**
     * @return array
     */
    public static function getHeaders(): array
    {
        $headers = [];

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            } else {
                $headers[$name] = $value;
            }
        }
        return $headers;
    }
}