<?php
/*
* �ļ���:meueAdd.php
* ����:��Ӳ˵��Ĺ���ģ��
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");

	if(@$_POST['menuAdd']){
		$name = addslashes($_POST['name']);
		$url = addslashes($_POST['url']);
		$rights	= addslashes($_POST['rights']);
		$fatherId =	addslashes($_POST['father_id']);
		
		//���url�Ƿ����
		$sql = "SELECT * FROM `menu` WHERE `url` = '".$url."'";
		$query = $db->query($sql);
		if (0 != $fatherId && $db->num_rows($query) == 1) {
			$message = "��Ӳ˵�ʧ�ܣ�ԭ�򣺲˵���·���Ѿ�����";
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
		
		//��һ���˵���Ȩ�޽�Ϊ���Ӳ˵������
		if($fatherId != 0){
			$sql = "SELECT * FROM `menu` WHERE `father_id` = '".$fatherId."' ORDER BY `right_level` ASC";	
			$query = $db->query($sql);
			$rs	= $db->fetch_object($query);
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$fatherId."'";
			$db->query($sql);
		}		
		$message = "��Ӳ˵��ɹ�";
		printMessage($message, "./admin.php?action=admin/menuAdd",1);
		exit();
	}
	
?>
<script language="javascript">
	function check(){
		if (menuAdd.name.value == ""){
			alert("������˵�����");
			menuAdd.name.focus();
			return false;
		}
		if (menuAdd.fatherId.value == -1){
			alert("��ѡ��˵�λ��");			
			return false;
		}
		if (menuAdd.rights.value == 0){
			alert("��ѡ��˵�Ȩ��");			
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
				<b>��Ӳ˵�</b>
			</td>
		</tr>
		<tr class="b">
			<td>�˵����ƣ�</td>
			<td><input type="text" name="name" size="70" ></td>
		</tr>
		<tr class="b">
			<td>�˵�λ�ã�</td>
			<td>
				<select name="fatherId">
					<option value="-1">��ѡ��˵�λ��</option>
					<option value="0" selected="selected">һ���˵�</option>
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
			<td>�˵�Ȩ�ޣ�</td>
			<td>
				<select name="rights">
					<option value="0">��ѡ��Ȩ��</option>
					<option value="1">��ͨ����Ա</option>
					<option value="2" selected="selected">ϵͳ����Ա</option>
					<option value="3">��վ������</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>�˵�·����</td>
			<td><input type="text" name="url" size=70 >&nbsp;��Ҫ����չ����Ĭ����չ��&nbsp;.php</td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="�� ��" onclick="return check()" name="menuAdd">&nbsp;&nbsp;<input type="reset" value="�� ��">
	</center>
</form>