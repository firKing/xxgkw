<?php
/*
* 文件名:meueAdd.php
* 功能:添加菜单的功能模块
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");

	if(@$_POST['menuAdd']){
		$name = addslashes($_POST['name']);
		$url = addslashes($_POST['url']);
		$rights	= addslashes($_POST['rights']);
		$fatherId =	addslashes($_POST['father_id']);
		
		//检测url是否存在
		$sql = "SELECT * FROM `menu` WHERE `url` = '".$url."'";
		$query = $db->query($sql);
		if (0 != $fatherId && $db->num_rows($query) == 1) {
			$message = "添加菜单失败，原因：菜单的路径已经存在";
			printMessage($message, "./admin.php?action=admin.php?action=admin/menuAdd");
			exit();
		}
		$sql = "INSERT INTO `menu`(`name`, `url`, `father_id`, `rights_level`) VALUES ('".$name."', '".$url."', '".$fatherId."', '".$rights."')";
		$query = $db->query($sql);
		$id = $db->insert_id($query);
		$sql = "SELECT * FROM `menu` WHERE `father_id` = '".$fatherId."' ORDER BY `order` DESC LIMIT 0,1";
		$query = $db->query($sql);
		$rs	= $db->fetch_object($query);
		$rs->order++;
		$sql = "UPDATE `menu` SET `order` = '".$rs->order."' WHERE `id` = '".$id."'";
		$db->query($sql);
		
		//将一级菜单的权限降为其子菜单中最低
		if($fatherId != 0){
			$sql = "SELECT * FROM `menu` WHERE `father_id` = '".$fatherId."' ORDER BY `right_level` ASC";	
			$query = $db->query($sql);
			$rs	= $db->fetch_object($query);
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$fatherId."'";
			$db->query($sql);
		}		
		$message = "添加菜单成功";
		printMessage($message, "./admin.php?action=admin/menuAdd",1);
		exit();
	}
	
?>
<script language="javascript">
	function check(){
		if (menuAdd.name.value == ""){
			alert("请输入菜单名称");
			menuAdd.name.focus();
			return false;
		}
		if (menuAdd.fatherId.value == -1){
			alert("请选择菜单位置");			
			return false;
		}
		if (menuAdd.rights.value == 0){
			alert("请选择菜单权限");			
			return false;
		}		
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/menuAdd" method="post" name="menuAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>添加菜单</b>
			</td>
		</tr>
		<tr class="b">
			<td>菜单名称：</td>
			<td><input type="text" name="name" size="70" ></td>
		</tr>
		<tr class="b">
			<td>菜单位置：</td>
			<td>
				<select name="fatherId">
					<option value="-1">请选择菜单位置</option>
					<option value="0" selected="selected">一级菜单</option>
					<?php
						$sql = "SELECT * FROM `menu` WHERE `father_id` = '0' ORDER BY  `order` ASC";
						$query = $db->query($sql);
						while($rs = $db->fetch_object($query)){
							echo "<option value=".$rs->id.">".$rs->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>菜单权限：</td>
			<td>
				<select name="rights">
					<option value="0">请选择权限</option>
					<option value="1">普通管理员</option>
					<option value="2" selected="selected">系统管理员</option>
					<option value="3">网站开发者</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>菜单路径：</td>
			<td><input type="text" name="url" size=70 >&nbsp;不要带扩展名，默认扩展名&nbsp;.php</td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="提 交" onclick="return check()" name="menuAdd">&nbsp;&nbsp;<input type="reset" value="重 置">
	</center>
</form>