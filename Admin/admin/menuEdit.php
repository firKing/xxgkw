<?php
/*
* 文件名:menuEdit.php
* 功能:菜单功能编辑模块
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	整理代码
* 2012.11.02	黄劼	在小康和小安的友情提示下，恢复了对 admin/check.php 的包含
*/
	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights($_GET['cid'], "")){		

		$message = "操作失败。原因:权限不够";
		printMessage($message, "./admin.php?action=admin/menuManage");
		die();

	}	
	//检测删除菜单	
	if(isset($_GET['job']) && $_GET['job'] == "delete"){	
		$id	= $_GET['cid'];	
		$sql = "DELETE FROM `menu` WHERE `id` = '".$id."' OR `father_id` = '".$id."'";
		$db->query($sql);
		$message = "操作成功";
		printMessage($message, "./admin.php?action=admin/menuManage", 1);
		die();
	}else if(isset($_GET['job']) && isset($_GET['step']) && $_GET['job'] == "edit" && $_GET['step'] == '2'){ 
		$cid = $_GET['cid'];
		$name =	addslashes($_POST['name']);
		$url = addslashes($_POST['url']);
		$rights	= addslashes($_POST['rights']);
		$fatherId = addslashes($_POST['father_id']);		
		$sql = "UPDATE `menu` SET 
			`name` = '".$name."',
			`url` = '".$url."', 
			`father_id` = '".$fatherId."', 
			`rights_level` = '".$rights."' 
			WHERE `id` = '".$cid."'";
		
		$query = $db->query($sql);
		
		//将一级菜单的权限降为其子菜单中最低
		if($fatherId != 0){
			$sql = "SELECT * FROM `menu` WHERE `father_id` = '".$fatherId."' ORDER BY `rights_level` ASC";
		}else{
			$sql = "SELECT * FROM `menu` WHERE `id` = '".$cid."' ORDER BY `rights_level` ASC";
		}
			$query = $db->query($sql);
			$rs	= $db->fetch_object($query);
		
		if($fatherId != 0){
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$fatherId."'";
		}else{ 	
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$cid."'";
		}
			$db->query($sql);
			$message = "修改成功";
			printMessage($message, "./admin.php?action=admin/menuManage", 1);
			die();
	}else if(isset($_GET['job']) && $_GET['job'] == "edit"){
		$id	= $_GET['cid'];
		$sql = "SELECT * FROM `menu` WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$rs = $db->fetch_object($query);
		
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
<form action="./admin.php?action=admin/menuEdit&job=edit&step=2&cid=<?php echo $id;?>" method="post" name="menuAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>添加菜单</b>
			</td>
		</tr>
		<tr class="b">
			<td>菜单名称：</td>
			<td>
				<input type="text" name="name" size=70 value="<?php echo $rs->name;?>">
			</td>
		</tr>
		<tr class="b">
			<td>菜单位置：</td>
			<td>
				<select name="fatherId">
					<option value="-1">请选择菜单位置</option>
					<option value="0" <?php if (0==$rs->father_id)echo "selected=\"selected\"";?>>一级菜单</option>
					<?php
						$sql = "SELECT * FROM `menu` WHERE `father_id` = '0' ORDER BY `order` ASC";
						$query = $db->query($sql);
						while($rs2 = $db->fetch_object($query)) {
							echo "<option value=".$rs2->id." ";
							if ($rs->father_id == $rs2->id) echo "selected=\"selected\"";
							echo ">".$rs2->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>菜单权限：</td>
			<td>
				<select name="rights">
					<option value="0" >请选择权限</option>
					<option value="1"<?php if ($rs->rights_level == 1) echo "selected=\"selected\""; ?>>普通管理员</option>
					<option value="2" <?php if ($rs->rights_level == 2) echo "selected=\"selected\""; ?>>系统管理员</option>
					<option value="3"<?php if ($rs->rights_level == 3) echo "selected=\"selected\""; ?>>网站开发者</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>菜单路径：</td>
			<td>
				<input type="text" name="url" size=70 value="<?php echo $rs->url;?>" >&nbsp;不要带扩展名，默认扩展名&nbsp;.php
			</td>
		</tr>
	</table>
	<br />
	<center>
		<input type=submit value="提 交" onclick="return check()" name="menuAdd">&nbsp;&nbsp;<input type=reset value="重 置">
	</center>
</form>
<?php
	}
?>