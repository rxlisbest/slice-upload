<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Qiniu;


class Request extends \Rxlisbest\SliceUpload\Request
{
    protected $key; // 文件存储名称
    protected $name; // 文件名称
    protected $chunk = 0; // 当前chunk数
    protected $chunks = 1; // chunk总数
    protected $temp_dir; // 临时目录
    protected $stream; // 文件流

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->setName()
            ->setChunk()
            ->setChunks()
            ->setTempDir()
            ->setStream();
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getChunk()
    {
        return $this->chunk;
    }

    public function getChunks()
    {
        return $this->chunks;
    }

    public function getTempDir()
    {
        return $this->temp_dir;
    }

    public function getStream()
    {
        return $this->stream;
    }

    /**
     * 设置chunk
     * @name: setChunk
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    protected function setChunk()
    {
        if (isset($_GET['chunk'])) {
            $this->chunk = $_GET['chunk'];
        }
        return $this;
    }

    /**
     * 设置chunks
     * @name: setChunks
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    protected function setChunks()
    {
        if (isset($_GET['chunks'])) {
            $this->chunks = $_GET['chunks'];
        }
        return $this;
    }

    /**
     * 设置文件存储名称
     * @name: setKey
     * @param $key
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 设置文件名称
     * @name: setName
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    protected function setName()
    {
        if (isset($_GET['name'])) {
            $this->name = $_GET['name'];
        }
        return $this;
    }

    /**
     * 设置临时目录
     * @name: setTempDir
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    protected function setTempDir()
    {
        $this->temp_dir = sys_get_temp_dir();
        return $this;
    }

    /**
     * 设置上传流
     * @name: setStream
     * @return $this
     * @author: RuiXinglong <ruixl@soocedu.com>
     * @time: 2017-06-19 10:00:00
     */
    protected function setStream()
    {
        $this->stream = file_get_contents("php://input");
        return $this;
    }
}