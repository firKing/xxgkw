<?php
/*
* �ļ���:menuEdit.php
* ����:�˵����ܱ༭ģ��
* ��������:
* 1.δ֪
* ������־:
* 2012.11.03	�Ƅ�	�������
* 2012.11.02	�Ƅ�	��С����С����������ʾ�£��ָ��˶� admin/check.php �İ���
*/
	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights($_GET['cid'], "")){		

		$message = "����ʧ�ܡ�ԭ��:Ȩ�޲���";
		printMessage($message, "./admin.php?action=admin/menuManage");
		die();

	}	
	//���ɾ���˵�	
	if(isset($_GET['job']) && $_GET['job'] == "delete"){	
		$id	= $_GET['cid'];	
		$sql = "DELETE FROM `menu` WHERE `id` = '".$id."' OR `father_id` = '".$id."'";
		$db->query($sql);
		$message = "�����ɹ�";
		printMessage($message, "./admin.php?action=admin/menuManage", 1);
		die();
	}else if(isset($_GET['job']) && isset($_GET['step']) && $_GET['job'] == "edit" && $_GET['step'] == '2'){ 
		$cid = $_GET['cid'];
		$name =	addslashes($_POST['name']);
		$url = addslashes($_POST['url']);
		$rights	= addslashes($_POST['rights']);
		$fatherId = addslashes($_POST['father_id']);		
		$sql = "UPDATE `menu` SET 
			`name` = '".$name."',
			`url` = '".$url."', 
			`father_id` = '".$fatherId."', 
			`rights_level` = '".$rights."' 
			WHERE `id` = '".$cid."'";
		
		$query = $db->query($sql);
		
		//��һ���˵���Ȩ�޽�Ϊ���Ӳ˵������
		if($fatherId != 0){
			$sql = "SELECT * FROM `menu` WHERE `father_id` = '".$fatherId."' ORDER BY `rights_level` ASC";
		}else{
			$sql = "SELECT * FROM `menu` WHERE `id` = '".$cid."' ORDER BY `rights_level` ASC";
		}
			$query = $db->query($sql);
			$rs	= $db->fetch_object($query);
		
		if($fatherId != 0){
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$fatherId."'";
		}else{ 	
			$sql = "UPDATE `menu` SET `rights_level` = '".$rs->rights_level."' WHERE `id` = '".$cid."'";
		}
			$db->query($sql);
			$message = "�޸ĳɹ�";
			printMessage($message, "./admin.php?action=admin/menuManage", 1);
			die();
	}else if(isset($_GET['job']) && $_GET['job'] == "edit"){
		$id	= $_GET['cid'];
		$sql = "SELECT * FROM `menu` WHERE `id` = '".$id."'";
		$query = $db->query($sql);
		$rs = $db->fetch_object($query);
		
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
<form action="./admin.php?action=admin/menuEdit&job=edit&step=2&cid=<?php echo $id;?>" method="post" name="menuAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan="2">
				<b>��Ӳ˵�</b>
			</td>
		</tr>
		<tr class="b">
			<td>�˵����ƣ�</td>
			<td>
				<input type="text" name="name" size=70 value="<?php echo $rs->name;?>">
			</td>
		</tr>
		<tr class="b">
			<td>�˵�λ�ã�</td>
			<td>
				<select name="fatherId">
					<option value="-1">��ѡ��˵�λ��</option>
					<option value="0" <?php if (0==$rs->father_id)echo "selected=\"selected\"";?>>һ���˵�</option>
					<?php
						$sql = "SELECT * FROM `menu` WHERE `father_id` = '0' ORDER BY `order` ASC";
						$query = $db->query($sql);
						while($rs2 = $db->fetch_object($query)) {
							echo "<option value=".$rs2->id." ";
							if ($rs->father_id == $rs2->id) echo "selected=\"selected\"";
							echo ">".$rs2->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>�˵�Ȩ�ޣ�</td>
			<td>
				<select name="rights">
					<option value="0" >��ѡ��Ȩ��</option>
					<option value="1"<?php if ($rs->rights_level == 1) echo "selected=\"selected\""; ?>>��ͨ����Ա</option>
					<option value="2" <?php if ($rs->rights_level == 2) echo "selected=\"selected\""; ?>>ϵͳ����Ա</option>
					<option value="3"<?php if ($rs->rights_level == 3) echo "selected=\"selected\""; ?>>��վ������</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>�˵�·����</td>
			<td>
				<input type="text" name="url" size=70 value="<?php echo $rs->url;?>" >&nbsp;��Ҫ����չ����Ĭ����չ��&nbsp;.php
			</td>
		</tr>
	</table>
	<br />
	<center>
		<input type=submit value="�� ��" onclick="return check()" name="menuAdd">&nbsp;&nbsp;<input type=reset value="�� ��">
	</center>
</form>
<?php
	}
?>