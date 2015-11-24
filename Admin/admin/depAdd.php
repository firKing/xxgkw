<?php
/*
* 文件名:depAdd.php
* 功能:部门添加
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
	if(@$_POST['depAdd']){
		$name = addslashes($_POST['name']);
		$sql = "SELECT * FROM `dep` WHERE `name` = '".$name."'";
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0){
			$message = "部门已经存在";
			printMessage($message, "./admin.php?action=admin/depAdd");
			exit();
		}
		$sql = "INSERT INTO `dep` (`name`) VALUES ('".$name."')";
		$query = $db->query($sql);
		$message = "操作成功";
		printMessage($message,"./admin.php?action=admin/depAdd");
		exit();	
	}
?>

<script language="javascript">
	function check(){
		if (depAdd.name.value == ""){
			alert("请输入部门名");
			depAdd.name.focus();
			return false;
		}			
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/depAdd" method="post" name="depAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>添加部门</b>
			</td>
		</tr>
		<tr class="b">
			<td>部门名：</td>
			<td><input type="text" name="name" size=70 ></td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="提 交" onclick="return check()" name="depAdd">&nbsp;&nbsp;<input type="reset" value="重 置">
	</center>
</form>