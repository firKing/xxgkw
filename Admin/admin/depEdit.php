<?php
/*
* 文件名:depEdit.php
* 功能:部门编辑
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if(true != $administrator->checkRights("", "admin/depManage")){
		$message = "操作失败  原因：权限不够";
		printMessage($message, "./admin.php?action=admin/depManage");
		exit();
	}
	
	$id	= $_GET['cid'];	
	if (isset($_GET['job']) && $_GET['job'] == "delete"){				
		$sql = "DELETE FROM `dep` WHERE `id` = '".$id."'";
		$db->query($sql);
		$message = "操作成功";
		printMessage($message, "./admin.php?action=admin/depManage");
		require_once(ROOT_PATH."foot.php");
		exit();
	}else if(isset($_GET['step']) && $_GET['step'] == 2){
		$name = addslashes($_POST['name']);
		$sql = "UPDATE `dep` SET `name` = '".$name."' WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$message = "操作成功";
		printMessage($message,"./admin.php?action=admin/depManage");
		exit();
	}else if(isset($_GET['job']) && $_GET['job'] == "edit"){
		$id	= $_GET['cid'];
		$sql = "SELECT * FROM `dep` WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$rs	= $db->fetch_object($query);
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/depEdit&step=2&cid=<?php echo $id;?>" method="post" name="depEdit">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>修改部门信息</b>
			</td>
		</tr>
		<tr class="b">
			<td>部门名：</td>
			<td>
				<input type="text" name="name" value="<?php echo $rs->name;?>" size="70" />
			</td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="提 交" onclick="return check()" name="depEdit">&nbsp;&nbsp;<input type="reset" value="重 置">
	</center>
</form>
<?php			
	}
?>