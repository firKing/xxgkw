<?php
/*
* �ļ���:changePwd.php
* ����:����Ա������
* ������־:
* 2012.11.12	�Ƅ�	��������
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if (isset($_GET['step']) && 2 == $_GET['step']) {
		$oldPwd	= md5($_POST['oldPasswd']);
		$newPwd	= md5($_POST['newPasswd']);
		$newPwd2 = md5($_POST['newPasswd2']);
		//	���ԭ����
		if ($administrator->get("admin_password") != $oldPwd) {
			printMessage("ԭ������󣬾ܾ��޸�", "./admin.php?action=admin/changePwd");
			exit();
		}
		if ($newPwd != $newPwd2) {
			printMessage("�����벻һ�£��ܾ��޸�", "./admin.php?action=admin/changePwd");
			exit();
		}
		$administrator->set("admin_password", $newPwd);
		printMessage("�����ɹ�", "./admin.php?action=admin/changePwd");
		exit();
	}
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/changePwd&step=2" method="post" name="changePasswd">
<table cellpadding="0" cellspacing="0" width="70%" align="center" class="i_table">		
	<tr>
		<td class="head" colspan="2"><b>��Ա���� - �޸�����</b></td></tr>		
	<tr>
		<td class="title" align="center">ԭ���룺</td>
		<td class="title"><input type="password" name="oldPasswd" size="30" id="oldPasswd" class="bgcolor" /></td>
	</tr>
	<tr>
		<td class="title" align="center">�����룺</td>
		<td class="title"><input type="password" name="newPasswd" size="30" id="newPasswd" class="bgcolor" /></td>
	</tr>
	<tr>
		<td class="title" align="center">ȷ�������룺</td>
		<td class="title"><input type="password" name="newPasswd2" size="30" id="newPasswd2" class="bgcolor" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="�� ��" class="bgcolor" /></td>
	</tr>
</table>
</form>