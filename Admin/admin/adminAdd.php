<?php
/*
* 文件名:adminAdd.php
* 功能:添加管理员的功能模块
* 更新日志:
* 2012.11.02	黄劼	在小康和小安的友情提示下，恢复了对 admin/check.php 的包含
* 2012.11.01	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");

	if(@$_POST['adminAdd']){
		$name = addslashes($_POST['name']);
		$rName = addslashes($_POST['rName']);
		$key = md5($_POST['key']);
		$rights	= addslashes($_POST['rights']);
		$email = addslashes($_POST['email']);
		$dep = addslashes($_POST['dep']);

		if(!(is_numeric($rights)) || $rights > 2 || $rights < 1){
			$message = "非法操作";
			printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			exit();
		}
		//检测当前管理员的权限
		$id	= $administrator->getAdminId();

		if($administrator->get("admin_rights") > $rights){

			//根据填写的管理员用户名，去数据库判断是否有该用户
			$sql = "SELECT count(`id`) AS `num` FROM `admin` WHERE `admin_name` = '".$name."'";
			$query = $db->query($sql);
			$row = $db->fetch_object($query);
			$resultNum = $row->num;	//将结果保存到 $resultNum, 如果为 0 则表示没有这个新添的用户名

			if($resultNum > 0){	//判断用户是否存在
			//存在的情况
				$message = "操作失败，原因：用户 ".$name." 已经存在";
				printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
				exit();
			}else{
			//不存在的情况
				$sql = "INSERT INTO `admin` (`admin_name`, `admin_real_name`, `admin_password`, `admin_email`, `admin_rights`, `dep`) 
					VALUES 
					('".$name."', '".$rName."', '".$key."', '".$email."', '".$rights."', '".$dep."')";
				$query = $db->query($sql);
				$message = "操作成功";
				printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			}
		}else{
			$message = "操作失败，原因：您不能添加和您等级相同或者比您等级高的管理员";
			printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			exit();
		}
	}
?>
<script language="javascript">
	function check(){
		if (adminAdd.name.value == ""){
			alert("请输入用户名");
			adminAdd.name.focus();
			return false;
		}
		if (adminAdd.key.value == ""){
			alert("请输入密码");	
			adminAdd.key.focus();		
			return false;
		}
		if (adminAdd.rights.value == 0){
			alert("请选择管理权限");
			return false;
		}		
		if (adminAdd.dep.value == 0){
			alert("请选择所属部门");			
			return false;
		}
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminAdd" method="post" name="adminAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan=2>
				<b>添加管理员</b>
			</td>
		</tr>
		<tr class="b">
			<td>用户名：</td>
			<td>
				<input type="text" name="name" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>真实姓名：</td>
			<td>
				<input type="text" name="rName" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>密码：</td>
			<td>
				<input type="password" name="key" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>Email：</td>
			<td>
				<input type="text" name="email" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>管理权限：</td>
			<td>
				<select name="rights">
					<option value="0">请选择...</option>
					<option value="1" selected="selected">普通管理员</option>
					<option value="2">超级管理员</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>所属部门：</td>
			<td>
				<select name="dep">
					<option value="0">请选择...</option>
					<?php
						$sql = "SELECT * FROM `dep`";
						$query = $db->query($sql);
						while ($rs = $db->fetch_object($query)){
							echo "<option value=\"".$rs->id."\">".$rs->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<br />
	<center>
		<input type="submit" value="提 交" onclick="return check()" name="adminAdd">&nbsp;&nbsp;<input type="reset" value="重 置">
	</center>
</form>