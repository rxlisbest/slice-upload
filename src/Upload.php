<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午1:52
 */

namespace Rxlisbest\SliceUpload;


class Upload
{
    private $chunk; // 当前chunk数
    private $chunks; // chunk总数

    public function __construct()
    {

    }

    public function merge(){

    }

    public function getStream(){
        return file_get_contents("php://input");
    }
}