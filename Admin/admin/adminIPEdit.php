<?php 
/*
* �ļ���:adminIPEdit.php
* ����:�����û���¼IP������
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights("", "admin/adminIP")){
		$message = "����ʧ��  ԭ��Ȩ�޲���";
		printMessage($message, "./admin.php?action=admin/adminIP");
		exit();
	}
	if(isset($_GET['job']) && $_GET['job'] == "delete"){
		$id	= $_GET['cid'];
		$uid = $_GET['uid'];
		$sql = "DELETE FROM `adminip` WHERE `id` = '".$uid."'";
		$query = $db->query($sql);
		$message = "�����ɹ�";
		printMessage($message, "./admin.php?action=admin/adminIPEdit&job=edit&cid=".$id."");
		exit();
	}else if(isset($_GET['step']) && $_GET['step'] == 2){
		$id = $_GET['cid'];
		$IP	= addslashes($_POST['IP']);
		$sql = "INSERT INTO `adminip` (`admin_id`,`admin_ip`) VALUES ('".$id."', '".$IP."')";
		$query = $db->query($sql);
		$message = "�����ɹ�";
		printMessage($message, "./admin.php?action=admin/adminIP");
		exit();
	}

	$id	= $_GET['cid'];
	$sql = "SELECT * FROM `admin` WHERE `id` = '".$id."'";
	$query = $db->query($sql);
	$rs	= $db->fetch_object($query);
	$uid = $rs->id;
	
	//���������¼��IP��ַ
	$sql3 = "SELECT * FROM `adminip` WHERE `admin_id` = '".$rs->id."'";
	$query3 = $db->query($sql3);
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminIPEdit&step=2&cid=<?php echo $id;?>" method="post" name="IPAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>�޸Ĺ���ԱIP��¼��Ϣ</b>
			</td>
		</tr>
		<tr class="b">
			<td>�û�����</td><td><?php echo $rs->admin_name;?></td>
		</tr>
		<tr class="b" valign="top">
			<td>�����¼IP��</td>
			<td>
			<?php  
				while($rs3 = $db->fetch_object($query3)){
					echo $rs3->adminIP;
					echo "&nbsp;&nbsp;<a href=\"./admin.php?action=admin/adminIPEdit&job=delete&cid=".$id."&uid=".$rs3->id."\">ɾ��</a><br>";
				}
			?>
			</td>
		</tr>
		<tr class="b">
			<td>�����IP��ַ��</td>
			<td><input type="text" name="IP" size="70" /></td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="�� ��" name="IPAdd">&nbsp;&nbsp;<input type="reset" value="�� ��">&nbsp;&nbsp;<input type="button" value="�� ��" onclick="location.href='./admin.php?action=admin/adminIP'" />
	</center>
</form>