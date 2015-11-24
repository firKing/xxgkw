<?php
/*
* 文件名:login.php
* 功能:显示登录界面，并对登录成功与否的情况作出判断，登录成功后将跳转至 admin.php 进行操作
* 工作流程:
* 1.由 html 代码显示出一个登录界面
* 更新日志:
* 2012.11.12	黄劼	将 adminPasswordRemainTimes 改为 adminKeyRemainTimes
* 2012.10.28	黄劼	代码整理
*/

	if(isset($_POST['submit'])){	//当按下 提交 按钮的时候

		$adminName = addslashes($_POST['admin_name']);
		$adminPassword = md5(addslashes($_POST['admin_pwd']));

		//根据输入的用户名从数据库取得记录数，用来判断是否存在该用户
		$sql = "SELECT `id` FROM `admin` WHERE `admin_name` = '".$adminName."'";
		$query = mysql_query($sql);
		$resultNum = mysql_num_rows($query);

		if ($resultNum != 0){	//检查用户是否存在
		//用户存在的情况

			$administrator->setAdminName($adminName);	//设置好 Admin 对象的 adminName
			$administrator->setAdminId();	//设置好 Admin 对象的 adminId


			if($administrator->get("admin_locked") == 1){	//检查帐户是否已经被锁定
				$administrator->destroySession();
				$message = "您的帐户已经被锁定，请与管理员联系";				
				printMessage($message, "admin.php");
				exit();
			}
			if($administrator->get("admin_password") == $adminPassword){	//检查密码是否正确
			//密码正确的情况

				$administrator->setSESSION();	//登录成功，把用户的 ID 存进 SESSION 中

				//登录成功后，将上次登录的 时间 与 IP 取出来存进 SESSION
				$admin_last_loaded_time = $administrator->get("admin_last_loaded_time");
				$admin_last_loaded_ip = $administrator->get("admin_last_loaded_ip");
				$_SESSION['admin_last_loaded_time'] = date("Y-m-d H:i:s", $admin_last_loaded_time);
				$_SESSION['admin_last_loaded_ip'] = $admin_last_loaded_ip;

				$IP	= $_SERVER['REMOTE_ADDR'];
				$time = time();

				$administrator->set("admin_password_remain_times", "15");	//清除以前的错误登录次数信息，将登录次数恢复到 15 次
				$administrator->set("admin_last_loaded_ip", $IP);		//更新最后一次登录的 IP地址
				$administrator->set("admin_last_loaded_time", $time);	//更新最后一次登录的时间

				

				header("location:./admin.php");	//登录成功后跳转到 admin.php 页面
			}else{

				$num = $administrator->get("admin_password_remain_times") - 1;	//如果密码错误，剩余登录次数减一
				
				if($num < 1){	//检查是否应该锁定帐户
					$administrator->set("admin_password_remain_times", 0);
					$administrator->set("admin_locked", "1");
					$administrator->destroySession();
					$message = "您的帐户已经被锁定，请与管理员联系";
					printMessage($message, "admin.php");
					exit();
				}else{
					$administrator->set("admin_password_remain_times", $num);
					$administrator->destroySession();
					$message = "用户名/密码错误，您还可以尝试".$num."次";
					printMessage($message, "admin.php");
					exit();
				}
			}			
		}else{	
		//用户不存在的情况

			$administrator->destroySession();
			$message = "用户名不存在，请重新输入";
			printMessage($message, "admin.php");
			exit();			
		}
	}
?>

<html>
	<head>
		<title>::<?php echo $webName;?>-后台管理系统::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
		<link rel="stylesheet" type="text/css" href="./css/main.css">
	</head>
	
	<body class="head_2" topmargin=5 leftmargin=5>
		<br><br><br><br><br><br><br>
		<form action="" method="post">
			<table width="50%" cellpadding="0" cellspacing="1" border="0" align="center" class="i_table">
				<tr><td valign="middle" align="center" class="b">
				<br><br><b>请输入您的管理员用户名和密码</b><br><br>
				<table width="350" align="center" cellspacing="1" cellpadding="0" class="i_table">
				<tr>
				<td>
				<table width="100%"  cellspacing="0" cellpadding="3">
				<tr bgcolor='#ffffff'>
				<td valign="middle" width="40%" align="right">
				请输入管理员ID
				</td>
				<td valign="middle">
				<input type="text" size="20" name="admin_name" >
				</td>
				</tr>
				<tr bgcolor='#ffffff'>
				<td valign="middle" width="40%" align="right">
				请输入管理员密码
				</td>
				<td valign=middle>
				<input type="password" size="21" name="admin_pwd">
				</td>
				</tr>
				</table></td></tr></table><br><input type="submit" name="submit" value="提 交" class="BigButton" >
				<br><br>
				<br>
				<br>
				</td></tr>
			</table>
		</form>
	</body>
</html>