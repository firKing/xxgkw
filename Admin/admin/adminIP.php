<?php
/*
* 文件名:adminIP.php
* 功能:管理用户登录IP的设置
* 工作流程:
* 1.未知
* 更新日志:
* 2012.11.03	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
	
	$id	= $administrator->getAdminId();
	$sql = "SELECT * FROM `admin` WHERE `id` = '".$id."' ORDER BY `admin_rights` DESC, `id` ASC";
	$query = $db->query($sql);
	$rs	= $db->fetch_object($query);
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
	<tr>
		<td class="head" colspan="9">
			<b>编辑管理员登录IP</b>
		</td>
	</tr>
	<tr align="center" class="b">
		<td>用户名</td>
		<td>真实姓名</td>
		<td>权限</td>
		<td>部门</td>
		<td>允许IP</td>
		<td>编辑</td>
	</tr>
	<?php 
		$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= '".$rs->admin_rights."' ORDER BY `id` ASC";
		$query = $db->query($sql);
		while($rs = $db->fetch_object($query)){
			//查找部门
			$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
			$query2 = $db->query($sql2);
			$rs2 = $db->fetch_object($query2);
			
			//查找允许登录的IP地址
			$sql3 = "SELECT * FROM `adminip` WHERE `admin_id` = '".$rs->id."'";
			$query3 = $db->query($sql3);
	?>
	<tr align="center" class="b">
		<td><?php echo $rs->admin_name;?></td><td><?php echo $rs->admin_real_name;?></td>
		<td><?php if (3 == $rs->admin_rights) echo "网站开发者";elseif (2 == $rs->admin_rights) echo "超级管理员";else echo "普通管理员";?></td><td><?php echo $rs2->name;?></td><td><?php if ($db->num_rows($query3) == 0) echo "所有IP";else { $rs3 = $db->fetch_object($query3);echo $rs3->adminIP; while ( $rs3 = $db->fetch_object($query3)) echo "<br>".$rs3->adminIP;}?></td>
		<td><a href="./admin.php?action=admin/adminIPEdit&job=edit&cid=<?php echo $rs->id?>">编辑</a></td>
	</tr>
	<?php
		}
	?>
</table>