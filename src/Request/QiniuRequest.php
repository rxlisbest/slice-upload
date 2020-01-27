<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/8/10
 * Time: 下午2:57
 */

namespace Rxlisbest\SliceUpload\Request;

class QiniuRequest implements RequestInterface
{
    protected string $key; // 文件存储名称
    protected string $name; // 文件名称
    protected int $chunk = 0; // 当前chunk数
    protected int  $chunks = 1; // chunk总数
    protected string $temp_dir; // 临时目录
    protected string $stream; // 文件流

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChunk(): int
    {
        return $this->chunk;
    }

    public function getChunks(): int
    {
        return $this->chunks;
    }

    public function getTempDir(): string
    {
        return $this->temp_dir;
    }

    public function getStream(): string
    {
        return $this->stream;
    }

    /**
     * 设置chunk
     * @name: setChunk
     * @return $this
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setChunk(): self
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
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setChunks(): self
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
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 设置文件名称
     * @name: setName
     * @return $this
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setName(): self
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
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setTempDir(): self
    {
        $this->temp_dir = sys_get_temp_dir();
        return $this;
    }

    /**
     * 设置上传流
     * @name: setStream
     * @return $this
     * @author: RuiXinglong <rxlisbest@163.com>
     * @time: 2017-06-19 10:00:00
     */
    public function setStream(): self
    {
        $this->stream = file_get_contents("php://input");
        return $this;
    }
}