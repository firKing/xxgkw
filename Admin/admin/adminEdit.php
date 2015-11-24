<?php
/*
* �ļ���:adminEdit.php
* ����:����Ա�༭����ģ��
* ��������:
* 1.δ֪
* ������־:
* 2012.11.02	�Ƅ�	��С����С����������ʾ�£��ָ��˶� admin/check.php �İ���
* 2012.11.02	�Ƅ�	��������
*/

	require_once(ROOT_PATH."admin/check.php");

	if(true != $administrator->checkRights("", "admin/adminManage")){
		$message = "����ʧ��  ԭ��Ȩ�޲���";
		printMessage($message, "./admin.php?action=admin/adminManage");
		exit();
	}

	$id	= $_GET['cid'];
	$sql = "SELECT * FROM `admin` WHERE `id` = '".$id."'";
	$query = $db->query($sql);
	$rs2 = $db->fetch_object($query);

	if($administrator->get("admin_rights") > $rs2->admin_rights){
		if(isset($_GET['job']) && $_GET['job'] == "delete"){				
			$sql = "DELETE FROM `admin` WHERE `id` = '".$id."'";
			$db->query($sql);
			$db->query($sql);
			$message = "�����ɹ�";
			printMessage($message, "./admin.php?action=admin/adminManage");
			require_once(ROOT_PATH."foot.php");
			exit();
		}else if(isset($_GET['step']) && $_GET['step'] == 2){			
			$rName	=	addslashes($_POST['rName']);
			$key	=	md5($_POST['key']);
			$rights	=	addslashes($_POST['rights']);
			$email	=	addslashes($_POST['email']);
			$dep = addslashes($_POST['dep']);
			if (!(is_numeric($rights))  or  $rights > 2 or $rights < 1){
				$message	=	"�Ƿ�����";
				printMessage($message, "./admin.php?action=admin/adminManage");				
			}
			if($key == md5("")){
				$sql = "UPDATE `admin` SET 
					`admin_real_name` = '".$rName."',
					`admin_email` = '".$email."',
					`admin_rights` = '".$rights."',
					`dep` = '".$dep."' 
					WHERE `id` = '".$id."'";						
			}else{
				$sql = "UPDATE `admin` SET 
					`admin_real_name` = '".$rName."',
					`admin_password` = '".$key."',
					`admin_email` = '".$email."',
					`admin_rights` = '".$rights."',
					`dep` = '".$dep."',
					`admin_locked` = 'No' 
					WHERE `id` = '".$id."'";			
			}
			$query = $db->query($sql);
			$message = "�����ɹ�";
			printMessage($message, "./admin.php?action=admin/adminManage");			
		}else if(isset($_GETP['job']) && $_GET['job'] == "edit"){	//��������ŵĽ�β�������php������
			$uid = $rs2->id;
?>

<script language="javascript">
function check(){
	if(adminAdd.name.value == ""){
		alert("�������û���");
		adminAdd.name.focus();
		return false;
	}
	if(adminAdd.rights.value == 0){
		alert("��ѡ�����Ȩ��");			
		return false;
	}		
	return true;
}
</script>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/adminEdit&step=2&cid=<?php echo $rs2->id;?>" method="post" name="adminAdd">
	<table width='95%' align="center" cellspacing=1 cellpadding=3 class="i_table">
		<tr>
			<td class=head align=center colspan=2>
				<b>�޸Ĺ���Ա��Ϣ</b>
			</td>
		</tr>
		<tr class="b">
			<td>�û�����</td>
			<td><?php echo $rs2->admin_name;?></td>
		</tr>
		<tr class="b">
			<td>��ʵ������</td>
			<td>
				<input type="text" name="rName" size=70  value="<?php echo $rs2->admin_real_name;?>">
			</td>
		</tr>
		<tr class="b">
			<td>���룺</td>
			<td>
				<input type="password" name="key" size=70>&nbsp;<font color="Red">Ϊ�ձ�ʾ���޸�</font>
			</td>
		</tr>
		<tr class="b">
			<td>Email��</td>
			<td><input type="text" name="email" size=70  value="<?php echo $rs2->admin_email;?>" >
			</td>
		</tr>
		<tr class="b">
			<td>����Ȩ�ޣ�</td>
			<td>
				<select name="rights">
					<option value="1" <?php if (1 == $rs2->admin_rights) echo "selected=\"selected\""?>>��ͨ����Ա</option>
					<option value="2" <?php if (2 == $rs2->admin_rights) echo "selected=\"selected\""?>>ϵͳ����Ա</option>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>�������ţ�</td>
			<td>
				<select name="dep">
					<?php
						$sql = "SELECT `id`, `dep`, `name` FROM `dep`";
						$query = $db->query($sql);
						while ($rs3 = $db->fetch_object($query)){
							echo "<option value=\"".$rs3->id."\"";
							if ($rs3->id == $rs2->dep)
								echo " selected=\"selected\"";
								echo ">".$rs3->name."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="b">
			<td>
				<font color="Red">����Ȩ��:</font>
			</td>
			<td>
				<a href="./admin.php?action=admin/adminEdit2&cid=<?php echo $rs2->id;?>">
					<font color="Red">�����������Ȩ������</font>
				</a>
			</td>
		</tr>
	</table>
	<br>
	<center>
		<input type=submit value="�� ��" onclick="return check()" name="adminAdd">&nbsp;&nbsp;<input type=reset value="�� ��">
	</center>
</form>
<?php
		//���������Ǹ������ŵĽ�β
		}else{
			$message = "�Ƿ�����";
			printMessage($message, "./admin.php?action=admin/adminManage");
			exit();
		}
	}else{
			$message = "����ʧ�ܣ�ԭ��Ȩ�޲���";
			printMessage($message, "./admin.php?action=admin/adminManage");
			exit();
	}		
?>