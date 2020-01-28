<?php
include_once 'autoload.php';
$upload = new Rxlisbest\SliceUpload\SliceUpload('./');
$upload->save('test.png'); // 上传文件
$upload->rename('test.png', 'test1.png'); // 重命名文件