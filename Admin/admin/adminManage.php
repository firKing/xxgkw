<?php
/*
* 文件名:adminManage.php
* 功能:管理管理员的功能模块
* 工作流程:
* 更新日志:
* 2012.11.12	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
  <tr>
    <td class="head" colspan="9"><b>编辑管理员</b></td>
  </tr>
  <tr align="center" class="b">
    <td>用户名</td>
    <td>真实姓名</td>
    <td>Email</td>
    <td>权限</td>
    <td>部门</td>
    <td>上次登录时间</td>
    <td>上次登录IP</td>
    <td>编辑</td>
    <td>删除</td>
  </tr>
<?php 
	//显示远程管理员信息
  	if(@$_GET['admin'] == "yes" && $administrator->get("admin_rights") == 3){
		$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= 3 ORDER BY `admin_rights` DESC,`id` ASC";
		$query = $db->query($sql);
		while($rs = $db->fetch_object($query)) {
			//查找部门
			$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
			$query2 = $db->query($sql2);
			$rs2 = $db->fetch_object($query2);
?>
  <tr align="center" class="b">
	<td><?php echo $rs->admin_name;?></td>
	<td><?php echo $rs->admin_real_name;?></td>
	<td><a href="mailto:<?php echo $rs->admin_email;?>"><?php echo $rs->admin_email;?></a></td>
	<td><?php if (3 == $rs->admin_rights) echo "网站开发者";elseif (2 == $rs->admin_rights) echo "超级管理员";else echo "普通管理员";?></td>
	<td><?php echo $rs2->name;?></td>
	<td><?php echo $rs->admin_last_loaded_time==0?"从未登录过":date("Y/m/d H:i:s", $rs->admin_last_loaded_time);?></td>
	<td><?php echo $rs->admin_last_loaded_ip;?></td>
	<td><a href="./admin.php?action=admin/adminEdit&job=edit&cid=<?php echo $rs->id?>">编辑</a></td>
	<td><a href="#" onclick="return checkset('./admin.php?action=admin/adminEdit&job=delete&cid=<?php echo $rs->id;?>')">删除</a></td>
  </tr>
<?php
		}
	}

	$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= '".$administrator->get("admin_rights")."' ORDER BY `admin_rights` DESC,`id` ASC";
	$query = $db->query($sql);
	while($rs = $db->fetch_object($query)) {
		//	查找部门
		$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
		$query2 = $db->query($sql2);
		$rs2 = $db->fetch_object($query2);
?>
  <tr align="center" class="b">
    <td><?php echo $rs->admin_name;?></td>
    <td><?php echo $rs->admin_real_name;?></td>
    <td><a href="mailto:<?php echo $rs->admin_email;?>"><?php echo $rs->admin_email;?></a></td>
    <td><?php if (3 == $rs->admin_rights) echo "网站开发者";elseif (2 == $rs->admin_rights) echo "超级管理员";else echo "普通管理员";?></td>
    <td><?php echo $rs2->name;?></td>
    <td><?php echo $rs->admin_last_loaded_time==0?"从未登录过":date("Y/m/d H:i:s", $rs->admin_last_loaded_time);?></td>
    <td><?php echo $rs->admin_last_loaded_ip;?></td>
    <td><a href="./admin.php?action=admin/adminEdit&job=edit&cid=<?php echo $rs->id?>">编辑</a></td>
    <td><a href="#" onclick="return checkset('./admin.php?action=admin/adminEdit&job=delete&cid=<?php echo $rs->id;?>')">删除</a></td>
  </tr>
  <?php
	}
?>
</table>
<br>
<script language='JavaScript'>
function checkset(chars)
{	
	if(!confirm("确实要删除该用户？"))
		return false;
	location.href = chars;
}
</script>
