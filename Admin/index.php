<?php
/*
* 文件名:index.php
* 功能:老后台入口文件，跳转至 admin.php
* 工作流程:
* 1.通过 header() 跳转至 admin.php
* 更新日志:
* 2012.10.28	黄劼	删去开头的 get 数组的显示 phpinfo() 的操作
*/
	header("location:admin.php");
?>