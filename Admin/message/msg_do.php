<?php
/*
* 文件名:msg_do.php
* 功能:添加留言的功能
* 更新日志:
* 2012.11.12	黄劼	代码整理
*/
	require_once(ROOT_PATH."inc/table_config.php");

	if(@is_numeric($_GET['del'])){
		$sqlDelArt = "DELETE FROM `".$messagetable."` WHERE `mid` = '".$_GET['del']."'";
		$resDelArt = $db->query($sqlDelArt);

		if($resDelArt <= 0){
			printMessageself("删除文章出错", "./admin.php?action=".$messagefolder."/msg_manage", "返回");
			exit();
		}

		printMessageself("删除文章成功", "./admin.php?action=".$messagefolder."/msg_manage", "返回");
		exit();
	}
?>