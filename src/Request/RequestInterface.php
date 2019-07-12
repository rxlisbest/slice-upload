<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/21
 * Time: 上午10:21
 */

namespace Rxlisbest\SliceUpload\Request;

interface RequestInterface
{
    function getKey();

    function getName();

    function getChunk();

    function getChunks();

    function getTempDir();

    function getStream();

    function setChunk();

    function setChunks();

    function setKey($key);

    function setName();

    function setTempDir();

    function setStream();
}