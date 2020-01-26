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
    function getKey(): string;

    function getName(): string;

    function getChunk(): int;

    function getChunks(): int;

    function getTempDir(): string;

    function getStream(): string;

    function setChunk(): self;

    function setChunks(): self;

    function setKey(string $key): self;

    function setName(): self;

    function setTempDir(): self;

    function setStream(): self;
}