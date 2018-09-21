# slice-upload
- 安装
```
composer require rxlisbest/slice-upload=~0.1.0
```
- Html
```
<html>
    <head>
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.bootcss.com/webuploader/0.1.1/webuploader.css" rel="stylesheet">
        <!--引入JS-->
        <script src="https://cdn.bootcss.com/webuploader/0.1.1/webuploader.js"></script>
    </head>
    <body>
        <div id="uploader" class="wu-example">
            <!--用来存放文件信息-->
            <div id="thelist" class="uploader-list"></div>
            <div class="btns">
                <div id="picker">选择文件</div>
                <button id="ctlBtn" class="btn btn-default">开始上传</button>
            </div>
        </div>
        <script>
            var uploader = WebUploader.create({
                // swf文件路径
                swf: '/static/Uploader.swf',

                // 文件接收服务端。
                server: '',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#picker',
                chunked : true,
                chunkSize : 4 * 1024 * 1024,
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false
            });
            $("#ctlBtn").on('click', function(){
                uploader.upload();
            });

        </script>
    </body>
</html>
```
- php
```
use Rxlisbest\SliceUpload\SliceUpload;

$upload = new SliceUpload($_SERVER['DOCUMENT_ROOT']);
$upload->saveAs($_POST['name']);
```
