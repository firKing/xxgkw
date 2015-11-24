<?php
/*
* 文件名:menuManage.php
* 功能:菜单管理
* 更新日志:
* 2012.12.04	黄劼	将location.href(chars)修改为location.href = chars
* 2012.11.03    黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if(@$_POST['job'] == "vieworder"){
		$sql = "SELECT * FROM `menu`";
		$query = $db->query($sql);
		while($rs = $db->fetch_object($query)){
			$order = $_POST['order'][$rs->id];	
			if(!(is_numeric($order))){
				$order = 0;	
			}
			$sql2 = "UPDATE `menu` SET `order` = '".$order."' WHERE `id` = '".$rs->id."'";
			$db->query($sql2);
		}			
		$message = "操作成功";	
		printMessage($message, "./admin.php?action=admin/menuManage",1);
	}
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/menuManage" method=POST>
	<input type="hidden" name="job" value='vieworder'>
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" colspan="5">
				<b>管理菜单</b>
			</td>
		</tr>
		<tr align="center">
			<td class="b">菜单名称</td>
			<td class="b">顺序</td>
			<td class="b">权限</td>
			<td class="b">编辑</td>
			<td class="b">删除</td>
		</tr>
		<?php
			$sql = "SELECT * FROM `menu` WHERE `father_id` = '0' ORDER BY `order` ASC";
			$query = $db->query($sql);
			while($rs = $db->fetch_object($query)){
		?>
		<tr>
			<td class="b"><b><?php echo $rs->name;?></b></td>
			<td align=center class="b"><input type="text" name="order[<?php echo $rs->id;?>]" value="<?php echo $rs->order;?>" size="5"></td>
			<td align="center" class="b"><?php if($rs->rights_level == 3) echo "网站开发者";elseif ($rs->rights_level == 2) echo "系统管理员";else echo "普通管理员";?></td>
			<td align=center class="b"><a href="./admin.php?action=admin/menuEdit&job=edit&cid=<?php echo $rs->id;?>">编辑</a></td>
			<td align=center class="b"><a href="#" onclick="return checkset('./admin.php?action=admin/menuEdit&job=delete&cid=<?php echo $rs->id;?>')">删除</a></td>
		</tr>
		<?php
				$sql2 = "SELECT * FROM `menu` WHERE `father_id` = '".$rs->id."' ORDER BY `order` ASC";
				$query2	= $db->query($sql2);
				while($rs2 = $db->fetch_object($query2)){
		?>
		<tr>
			<td class="b">> <?php echo $rs2->name;?>
			<td align=center class="b"><input type="text" name="order[<?php echo $rs2->id;?>]" value="<?php echo $rs2->order;?>" size="5"></td>
			<td align="center" class="b"><?php if($rs2->rights_level == 3) echo "网站开发者";elseif ($rs2->rights_level == 2) echo "系统管理员";else echo "普通管理员";?></td>
			<td align=center class="b"><a href="./admin.php?action=admin/menuEdit&job=edit&cid=<?php echo $rs2->id;?>">编辑</a></td>
			<td align=center class="b"><a href="./admin.php?action=admin/menuEdit&job=delete&cid=<?php echo $rs2->id;?>" onclick="return checkset('./admin.php?action=admin/menuEdit&job=delete&cid=<?php echo $rs2->id;?>')">删除</a></td>
		</tr>
		<?php
				}//	end while $rs2

			}//	end while $rs
		?>
	</table>
	<br />
	<center><input type=submit value="提 交"></center>
</form>
<script language='javascript'>
function checkset(chars)
{	
	if(!confirm("确实要删除该菜单？"))
		return false;
	location.href = chars;
}
</script>