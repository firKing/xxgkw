<?php
/*
* �ļ���:depEdit.php
* ����:���ű༭
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if(true != $administrator->checkRights("", "admin/depManage")){
		$message = "����ʧ��  ԭ��Ȩ�޲���";
		printMessage($message, "./admin.php?action=admin/depManage");
		exit();
	}
	
	$id	= $_GET['cid'];	
	if (isset($_GET['job']) && $_GET['job'] == "delete"){				
		$sql = "DELETE FROM `dep` WHERE `id` = '".$id."'";
		$db->query($sql);
		$message = "�����ɹ�";
		printMessage($message, "./admin.php?action=admin/depManage");
		require_once(ROOT_PATH."foot.php");
		exit();
	}else if(isset($_GET['step']) && $_GET['step'] == 2){
		$name = addslashes($_POST['name']);
		$sql = "UPDATE `dep` SET `name` = '".$name."' WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$message = "�����ɹ�";
		printMessage($message,"./admin.php?action=admin/depManage");
		exit();
	}else if(isset($_GET['job']) && $_GET['job'] == "edit"){
		$id	= $_GET['cid'];
		$sql = "SELECT * FROM `dep` WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$rs	= $db->fetch_object($query);
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/depEdit&step=2&cid=<?php echo $id;?>" method="post" name="depEdit">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>�޸Ĳ�����Ϣ</b>
			</td>
		</tr>
		<tr class="b">
			<td>��������</td>
			<td>
				<input type="text" name="name" value="<?php echo $rs->name;?>" size="70" />
			</td>
		</tr>
	</table>
	<br>
	<center>
		<input type="submit" value="�� ��" onclick="return check()" name="depEdit">&nbsp;&nbsp;<input type="reset" value="�� ��">
	</center>
</form>
<?php			
	}
?>