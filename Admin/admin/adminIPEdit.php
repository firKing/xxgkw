<?php 
/*
* 文件名:adminIPEdit.php
* 功能:管理用户登录IP的设置
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights("", "admin/adminIP")){
		$message = "操作失败  原因：权限不够";
		printMessage($message, "./admin.php?action=admin/adminIP");
		exit();
	}
	if(isset($_GET['job']) && $_GET['job'] == "delete"){
		$id	= $_GET['cid'];
		$uid = $_GET['uid'];
		$sql = "DELETE FROM `adminip` WHERE `id` = '".$uid."'";
		$query = $db->query($sql);
		$message = "操作成功";
		printMessage($message, "./admin.php?action=admin/adminIPEdit&job=edit&cid=".$id."");
		exit();
	}else if(isset($_GET['step']) && $_GET['step'] == 2){
		$id = $_GET['cid'];
		$IP	= addslashes($_POST['IP']);
		$sql = "INSERT INTO `adminip` (`admin_id`,`admin_ip`) VALUES ('".$id."', '".$IP."')";
		$query = $db->query($sql);
		$message = "操作成功";
		printMessage($message, "./admin.php?action=admin/adminIP");
		exit();
	}

	$id	= $_GET['cid'];
	$sql = "SELECT * FROM `admin` WHERE `id` = '".$id."'";
	$query = $db->query($sql);
	$rs	= $db->fetch_object($query);
	$uid = $rs->id;
	
	//查找允许登录的IP地址
	$sql3 = "SELECT * FROM `adminip` WHERE `admin_id` = '".$rs->id."'";
	$query3 = $db->query($sql3);
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminIPEdit&step=2&cid=<?php echo $id;?>" method="post" name="IPAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>修改管理员IP登录信息</b>
			</td>
		</tr>
		<tr class="b">
			<td>用户名：</td><td><?php echo $rs->admin_name;?></td>
		</tr>
		<tr class="b" valign="top">
			<td>允许登录IP：</td>
			<td>
			<?php  
				while($rs3 = $db->fetch_object($query3)){
					echo $rs3->adminIP;
					echo "&nbsp;&nbsp;<a href=\"./admin.php?action=admin/adminIPEdit&job=delete&cid=".$id."&uid=".$rs3->id."\">删除</a><br>";
				}
			?>
			</td>
		</tr>
		<tr class="b">
			<td>添加新IP地址：</td>
			<td><input type="text" name="IP" size="70" /></td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="提 交" name="IPAdd">&nbsp;&nbsp;<input type="reset" value="重 置">&nbsp;&nbsp;<input type="button" value="返 回" onclick="location.href='./admin.php?action=admin/adminIP'" />
	</center>
</form>