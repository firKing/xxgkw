<?php
/*
* 文件名:changePwd.php
* 功能:管理员改密码
* 更新日志:
* 2012.11.12	黄劼	代码整理
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if (isset($_GET['step']) && 2 == $_GET['step']) {
		$oldPwd	= md5($_POST['oldPasswd']);
		$newPwd	= md5($_POST['newPasswd']);
		$newPwd2 = md5($_POST['newPasswd2']);
		//	检测原密码
		if ($administrator->get("admin_password") != $oldPwd) {
			printMessage("原密码错误，拒绝修改", "./admin.php?action=admin/changePwd");
			exit();
		}
		if ($newPwd != $newPwd2) {
			printMessage("新密码不一致，拒绝修改", "./admin.php?action=admin/changePwd");
			exit();
		}
		$administrator->set("admin_password", $newPwd);
		printMessage("操作成功", "./admin.php?action=admin/changePwd");
		exit();
	}
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<form action="./admin.php?action=admin/changePwd&step=2" method="post" name="changePasswd">
<table cellpadding="0" cellspacing="0" width="70%" align="center" class="i_table">		
	<tr>
		<td class="head" colspan="2"><b>人员管理 - 修改密码</b></td></tr>		
	<tr>
		<td class="title" align="center">原密码：</td>
		<td class="title"><input type="password" name="oldPasswd" size="30" id="oldPasswd" class="bgcolor" /></td>
	</tr>
	<tr>
		<td class="title" align="center">新密码：</td>
		<td class="title"><input type="password" name="newPasswd" size="30" id="newPasswd" class="bgcolor" /></td>
	</tr>
	<tr>
		<td class="title" align="center">确认新密码：</td>
		<td class="title"><input type="password" name="newPasswd2" size="30" id="newPasswd2" class="bgcolor" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="提 交" class="bgcolor" /></td>
	</tr>
</table>
</form>