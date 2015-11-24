<?php
/*
* 文件名:adminEdit.php
* 功能:管理员编辑功能模块
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.02	黄劼	在小康和小安的友情提示下，恢复了对 admin/check.php 的包含
* 2012.11.02	黄劼	代码整理
*/

	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights("", "admin/adminManage")){
		$message = "操作失败  原因：权限不够";
		printMessage($message, "./admin.php?action=admin/adminManage");
		exit();
	}

	$id	= $_GET['cid'];
	$sql = "SELECT * FROM `admin` WHERE `id` = '".$id."'";
	$query = $db->query($sql);
	$rs2 = $db->fetch_object($query);

	if($administrator->get("admin_rights") > $rs2->admin_rights){
		if(isset($_GET['job']) && $_GET['job'] == "delete"){				
			$sql = "DELETE FROM `admin` WHERE `id` = '".$id."'";
			$db->query($sql);
			$db->query($sql);
			$message = "操作成功";
			printMessage($message, "./admin.php?action=admin/adminManage");
			require_once(ROOT_PATH."foot.php");
			exit();
		}else if(isset($_GET['step']) && $_GET['step'] == 2){			
			$rName	=	addslashes($_POST['rName']);
			$key	=	md5($_POST['key']);
			$rights	=	addslashes($_POST['rights']);
			$email	=	addslashes($_POST['email']);
			$dep = addslashes($_POST['dep']);
			if (!(is_numeric($rights))  or  $rights > 2 or $rights < 1){
				$message	=	"非法操作";
				printMessage($message, "./admin.php?action=admin/adminManage");				
			}
			if($key == md5("")){
				$sql = "UPDATE `admin` SET 
					`admin_real_name` = '".$rName."',
					`admin_email` = '".$email."',
					`admin_rights` = '".$rights."',
					`dep` = '".$dep."' 
					WHERE `id` = '".$id."'";						
			}else{
				$sql = "UPDATE `admin` SET 
					`admin_real_name` = '".$rName."',
					`admin_password` = '".$key."',
					`admin_email` = '".$email."',
					`admin_rights` = '".$rights."',
					`dep` = '".$dep."',
					`admin_locked` = 'No' 
					WHERE `id` = '".$id."'";			
			}
			$query = $db->query($sql);
			$message = "操作成功";
			printMessage($message, "./admin.php?action=admin/adminManage");			
		}else if(isset($_GETP['job']) && $_GET['job'] == "edit"){	//这个花括号的结尾在下面的php代码中
			$uid = $rs2->id;
?>

<script language="javascript">
function check(){
	if(adminAdd.name.value == ""){
		alert("请输入用户名");
		adminAdd.name.focus();
		return false;
	}
	if(adminAdd.rights.value == 0){
		alert("请选择管理权限");			
		return false;
	}		
	return true;
}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminEdit&step=2&cid=<?php echo $rs2->id;?>" method="post" name="adminAdd">
	<table width='95%' align="center" cellspacing=1 cellpadding=3 class="i_table">
		<tr>
			<td class=head align=center colspan=2>
				<b>修改管理员信息</b>
			</td>
		</tr>
		<tr class="b">
			<td>用户名：</td>
			<td><?php echo $rs2->admin_name;?></td>
		</tr>
		<tr class="b">
			<td>真实姓名：</td>
			<td>
				<input type="text" name="rName" size=70  value="<?php echo $rs2->admin_real_name;?>">
			</td>
		</tr>
		<tr class="b">
			<td>密码：</td>
			<td>
				<input type="password" name="key" size=70>&nbsp;<font color="Red">为空表示不修改</font>
			</td>
		</tr>
		<tr class="b">
			<td>Email：</td>
			<td><input type="text" name="email" size=70  value="<?php echo $rs2->admin_email;?>" >
			</td>
		</tr>
		<tr class="b">
			<td>管理权限：</td>
			<td>
				<select name="rights">
					<option value="1" <?php if (1 == $rs2->admin_rights) echo "selected=\"selected\""?>>普通管理员</option>
					<option value="2" <?php if (2 == $rs2->admin_rights) echo "selected=\"selected\""?>>系统管理员</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>所属部门：</td>
			<td>
				<select name="dep">
					<?php
						$sql = "SELECT `id`, `dep`, `name` FROM `dep`";
						$query = $db->query($sql);
						while ($rs3 = $db->fetch_object($query)){
							echo "<option value=\"".$rs3->id."\"";
							if ($rs3->id == $rs2->dep)
								echo " selected=\"selected\"";
								echo ">".$rs3->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>
				<font color="Red">特殊权限:</font>
			</td>
			<td>
				<a href="./admin.php?action=admin/adminEdit2&cid=<?php echo $rs2->id;?>">
					<font color="Red">点击进入特殊权利配置</font>
				</a>
			</td>
		</tr>
	</table>
	<br>
	<center>
		<input type=submit value="提 交" onclick="return check()" name="adminAdd">&nbsp;&nbsp;<input type=reset value="重 置">
	</center>
</form>
<?php
		//这是上面那个花括号的结尾
		}else{
			$message = "非法操作";
			printMessage($message, "./admin.php?action=admin/adminManage");
			exit();
		}
	}else{
			$message = "操作失败，原因：权限不够";
			printMessage($message, "./admin.php?action=admin/adminManage");
			exit();
	}		
?>