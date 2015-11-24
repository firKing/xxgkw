<?php
/*
* 文件名:check.php
* 功能:在加载每个功能模块之前进行判断，是否登录，防止直接从浏览器地址输入文件名
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	if(false == $administrator->isLogin()){
		if(file_exists("quit.php")){
			require_once("quit.php");
		}else{ 
			require_once("./admin/quit.php");
		}
		die();
	}
?>
<script language="javascript">
	if(window == top)
	location.href='./quit.php';		
</script>