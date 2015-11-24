<?php
/*
* �ļ���:adminAdd.php
* ����:��ӹ���Ա�Ĺ���ģ��
* ������־:
* 2012.11.02	�Ƅ�	��С����С����������ʾ�£��ָ��˶� admin/check.php �İ���
* 2012.11.01	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");

	if(@$_POST['adminAdd']){
		$name = addslashes($_POST['name']);
		$rName = addslashes($_POST['rName']);
		$key = md5($_POST['key']);
		$rights	= addslashes($_POST['rights']);
		$email = addslashes($_POST['email']);
		$dep = addslashes($_POST['dep']);

		if(!(is_numeric($rights)) || $rights > 2 || $rights < 1){
			$message = "�Ƿ�����";
			printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			exit();
		}
		//��⵱ǰ����Ա��Ȩ��
		$id	= $administrator->getAdminId();

		if($administrator->get("admin_rights") > $rights){

			//������д�Ĺ���Ա�û�����ȥ���ݿ��ж��Ƿ��и��û�
			$sql = "SELECT count(`id`) AS `num` FROM `admin` WHERE `admin_name` = '".$name."'";
			$query = $db->query($sql);
			$row = $db->fetch_object($query);
			$resultNum = $row->num;	//��������浽 $resultNum, ���Ϊ 0 ���ʾû�����������û���

			if($resultNum > 0){	//�ж��û��Ƿ����
			//���ڵ����
				$message = "����ʧ�ܣ�ԭ���û� ".$name." �Ѿ�����";
				printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
				exit();
			}else{
			//�����ڵ����
				$sql = "INSERT INTO `admin` (`admin_name`, `admin_real_name`, `admin_password`, `admin_email`, `admin_rights`, `dep`) 
					VALUES 
					('".$name."', '".$rName."', '".$key."', '".$email."', '".$rights."', '".$dep."')";
				$query = $db->query($sql);
				$message = "�����ɹ�";
				printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			}
		}else{
			$message = "����ʧ�ܣ�ԭ����������Ӻ����ȼ���ͬ���߱����ȼ��ߵĹ���Ա";
			printMessage($message, ROOT_PATH."admin.php?action=admin/adminAdd");
			exit();
		}
	}
?>
<script language="javascript">
	function check(){
		if (adminAdd.name.value == ""){
			alert("�������û���");
			adminAdd.name.focus();
			return false;
		}
		if (adminAdd.key.value == ""){
			alert("����������");	
			adminAdd.key.focus();		
			return false;
		}
		if (adminAdd.rights.value == 0){
			alert("��ѡ�����Ȩ��");
			return false;
		}		
		if (adminAdd.dep.value == 0){
			alert("��ѡ����������");			
			return false;
		}
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminAdd" method="post" name="adminAdd">
	<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
		<tr>
			<td class="head" align="center" colspan=2>
				<b>��ӹ���Ա</b>
			</td>
		</tr>
		<tr class="b">
			<td>�û�����</td>
			<td>
				<input type="text" name="name" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>��ʵ������</td>
			<td>
				<input type="text" name="rName" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>���룺</td>
			<td>
				<input type="password" name="key" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>Email��</td>
			<td>
				<input type="text" name="email" size=70 >
			</td>
		</tr>
		<tr class="b">
			<td>����Ȩ�ޣ�</td>
			<td>
				<select name="rights">
					<option value="0">��ѡ��...</option>
					<option value="1" selected="selected">��ͨ����Ա</option>
					<option value="2">��������Ա</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>�������ţ�</td>
			<td>
				<select name="dep">
					<option value="0">��ѡ��...</option>
					<?php
						$sql = "SELECT * FROM `dep`";
						$query = $db->query($sql);
						while ($rs = $db->fetch_object($query)){
							echo "<option value=\"".$rs->id."\">".$rs->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<br />
	<center>
		<input type="submit" value="�� ��" onclick="return check()" name="adminAdd">&nbsp;&nbsp;<input type="reset" value="�� ��">
	</center>
</form>