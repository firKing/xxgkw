<?php
/*
* �ļ���:adminIP.php
* ����:�����û���¼IP������
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	��������
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
			<b>�༭����Ա��¼IP</b>
		</td>
	</tr>
	<tr align="center" class="b">
		<td>�û���</td>
		<td>��ʵ����</td>
		<td>Ȩ��</td>
		<td>����</td>
		<td>����IP</td>
		<td>�༭</td>
	</tr>
	<?php 
		$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= '".$rs->admin_rights."' ORDER BY `id` ASC";
		$query = $db->query($sql);
		while($rs = $db->fetch_object($query)){
			//���Ҳ���
			$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
			$query2 = $db->query($sql2);
			$rs2 = $db->fetch_object($query2);
			
			//���������¼��IP��ַ
			$sql3 = "SELECT * FROM `adminip` WHERE `admin_id` = '".$rs->id."'";
			$query3 = $db->query($sql3);
	?>
	<tr align="center" class="b">
		<td><?php echo $rs->admin_name;?></td><td><?php echo $rs->admin_real_name;?></td>
		<td><?php if (3 == $rs->admin_rights) echo "��վ������";elseif (2 == $rs->admin_rights) echo "��������Ա";else echo "��ͨ����Ա";?></td><td><?php echo $rs2->name;?></td><td><?php if ($db->num_rows($query3) == 0) echo "����IP";else { $rs3 = $db->fetch_object($query3);echo $rs3->adminIP; while ( $rs3 = $db->fetch_object($query3)) echo "<br>".$rs3->adminIP;}?></td>
		<td><a href="./admin.php?action=admin/adminIPEdit&job=edit&cid=<?php echo $rs->id?>">�༭</a></td>
	</tr>
	<?php
		}
	?>
</table>