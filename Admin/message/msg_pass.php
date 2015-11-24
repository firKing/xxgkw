<?
/*
* 文件名:msg_pass.php
* 功能:添加留言的功能
* 更新日志:
* 2012.11.12	黄劼	代码整理
*/
	require_once(ROOT_PATH."inc/table_config.php");

	if(@is_numeric($_GET['pass'])){
		$sql = "UPDATE `".$messagetable."` SET `is_locked` = 'no' WHERE `mid` = '".$_GET['pass']."'";
		$query = $db->query($sql);

		if($query <= 0){
			printMessage("操作失败：该留言仍未通过审核", "./admin.php?action=".$messagefolder."/msg_manage", "返回");
			exit();
		}else{
			printMessage("操作成功：该留言已通过审核","./admin.php?action=".$messagefolder."/msg_manage", "返回");
		}
	}
		if(@is_numeric($_GET['unpass'])){
			$sql = "UPDATE `".$messagetable."` SET `is_locked` = 'yes' WHERE `mid` = '".$_GET['unpass']."'";
			$query = $db->query($sql);
			if($query <= 0){
				printMessage("操作失败：隐藏留言出错", "./admin.php?action=".$messagefolder."/msg_manage", "返回");
				exit();
			}else{
				printMessage("操作成功：该留言已被隐藏", "./admin.php?action=".$messagefolder."/msg_manage", "返回");
			}
		}
?>