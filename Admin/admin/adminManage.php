<?php
/*
* �ļ���:adminManage.php
* ����:�������Ա�Ĺ���ģ��
* ��������:
* ������־:
* 2012.11.12	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
  <tr>
    <td class="head" colspan="9"><b>�༭����Ա</b></td>
  </tr>
  <tr align="center" class="b">
    <td>�û���</td>
    <td>��ʵ����</td>
    <td>Email</td>
    <td>Ȩ��</td>
    <td>����</td>
    <td>�ϴε�¼ʱ��</td>
    <td>�ϴε�¼IP</td>
    <td>�༭</td>
    <td>ɾ��</td>
  </tr>
<?php 
	//��ʾԶ�̹���Ա��Ϣ
  	if(@$_GET['admin'] == "yes" && $administrator->get("admin_rights") == 3){
		$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= 3 ORDER BY `admin_rights` DESC,`id` ASC";
		$query = $db->query($sql);
		while($rs = $db->fetch_object($query)) {
			//���Ҳ���
			$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
			$query2 = $db->query($sql2);
			$rs2 = $db->fetch_object($query2);
?>
  <tr align="center" class="b">
	<td><?php echo $rs->admin_name;?></td>
	<td><?php echo $rs->admin_real_name;?></td>
	<td><a href="mailto:<?php echo $rs->admin_email;?>"><?php echo $rs->admin_email;?></a></td>
	<td><?php if (3 == $rs->admin_rights) echo "��վ������";elseif (2 == $rs->admin_rights) echo "��������Ա";else echo "��ͨ����Ա";?></td>
	<td><?php echo $rs2->name;?></td>
	<td><?php echo $rs->admin_last_loaded_time==0?"��δ��¼��":date("Y/m/d H:i:s", $rs->admin_last_loaded_time);?></td>
	<td><?php echo $rs->admin_last_loaded_ip;?></td>
	<td><a href="./admin.php?action=admin/adminEdit&job=edit&cid=<?php echo $rs->id?>">�༭</a></td>
	<td><a href="#" onclick="return checkset('./admin.php?action=admin/adminEdit&job=delete&cid=<?php echo $rs->id;?>')">ɾ��</a></td>
  </tr>
<?php
		}
	}

	$sql = "SELECT * FROM `admin` WHERE `admin_rights` <= '".$administrator->get("admin_rights")."' ORDER BY `admin_rights` DESC,`id` ASC";
	$query = $db->query($sql);
	while($rs = $db->fetch_object($query)) {
		//	���Ҳ���
		$sql2 = "SELECT * FROM `dep` WHERE `id` = '".$rs->dep."'";
		$query2 = $db->query($sql2);
		$rs2 = $db->fetch_object($query2);
?>
  <tr align="center" class="b">
    <td><?php echo $rs->admin_name;?></td>
    <td><?php echo $rs->admin_real_name;?></td>
    <td><a href="mailto:<?php echo $rs->admin_email;?>"><?php echo $rs->admin_email;?></a></td>
    <td><?php if (3 == $rs->admin_rights) echo "��վ������";elseif (2 == $rs->admin_rights) echo "��������Ա";else echo "��ͨ����Ա";?></td>
    <td><?php echo $rs2->name;?></td>
    <td><?php echo $rs->admin_last_loaded_time==0?"��δ��¼��":date("Y/m/d H:i:s", $rs->admin_last_loaded_time);?></td>
    <td><?php echo $rs->admin_last_loaded_ip;?></td>
    <td><a href="./admin.php?action=admin/adminEdit&job=edit&cid=<?php echo $rs->id?>">�༭</a></td>
    <td><a href="#" onclick="return checkset('./admin.php?action=admin/adminEdit&job=delete&cid=<?php echo $rs->id;?>')">ɾ��</a></td>
  </tr>
  <?php
	}
?>
</table>
<br>
<script language='JavaScript'>
function checkset(chars)
{	
	if(!confirm("ȷʵҪɾ�����û���"))
		return false;
	location.href = chars;
}
</script>
