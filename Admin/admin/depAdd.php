<?php
/*
* �ļ���:depAdd.php
* ����:�������
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");
	if(@$_POST['depAdd']){
		$name = addslashes($_POST['name']);
		$sql = "SELECT * FROM `dep` WHERE `name` = '".$name."'";
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0){
			$message = "�����Ѿ�����";
			printMessage($message, "./admin.php?action=admin/depAdd");
			exit();
		}
		$sql = "INSERT INTO `dep` (`name`) VALUES ('".$name."')";
		$query = $db->query($sql);
		$message = "�����ɹ�";
		printMessage($message,"./admin.php?action=admin/depAdd");
		exit();	
	}
?>

<script language="javascript">
	function check(){
		if (depAdd.name.value == ""){
			alert("�����벿����");
			depAdd.name.focus();
			return false;
		}			
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/depAdd" method="post" name="depAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>��Ӳ���</b>
			</td>
		</tr>
		<tr class="b">
			<td>��������</td>
			<td><input type="text" name="name" size=70 ></td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="�� ��" onclick="return check()" name="depAdd">&nbsp;&nbsp;<input type="reset" value="�� ��">
	</center>
</form>