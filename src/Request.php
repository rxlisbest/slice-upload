<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/21
 * Time: 上午10:21
 */

namespace Rxlisbest\SliceUpload;

abstract class Request
{
    /**
     * 设置chunk
     * @name: setChunk
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract protected function setChunk();

    /**
     * 设置chunks
     * @name: setChunks
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract protected function setChunks();

    /**
     * 设置文件存储名称
     * @name: setKey
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract public function setKey($key);

    /**
     * 设置文件名称
     * @name: setName
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract protected function setName();

    /**
     * 设置临时目录
     * @name: setTempDir
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract protected function setTempDir();

    /**
     * 设置上传流
     * @name: setStream
     * @return mixed
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    abstract protected function setStream();
}