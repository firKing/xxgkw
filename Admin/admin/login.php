<?php
/*
* �ļ���:login.php
* ����:��ʾ��¼���棬���Ե�¼�ɹ�������������жϣ���¼�ɹ�����ת�� admin.php ���в���
* ��������:
* 1.�� html ������ʾ��һ����¼����
* ������־:
* 2012.11.12	�Ƅ�	�� adminPasswordRemainTimes ��Ϊ adminKeyRemainTimes
* 2012.10.28	�Ƅ�	��������
*/

	if(isset($_POST['submit'])){	//������ �ύ ��ť��ʱ��

		$adminName = addslashes($_POST['admin_name']);
		$adminPassword = md5(addslashes($_POST['admin_pwd']));

		//����������û��������ݿ�ȡ�ü�¼���������ж��Ƿ���ڸ��û�
		$sql = "SELECT `id` FROM `admin` WHERE `admin_name` = '".$adminName."'";
		$query = mysql_query($sql);
		$resultNum = mysql_num_rows($query);

		if ($resultNum != 0){	//����û��Ƿ����
		//�û����ڵ����

			$administrator->setAdminName($adminName);	//���ú� Admin ����� adminName
			$administrator->setAdminId();	//���ú� Admin ����� adminId


			if($administrator->get("admin_locked") == 1){	//����ʻ��Ƿ��Ѿ�������
				$administrator->destroySession();
				$message = "�����ʻ��Ѿ����������������Ա��ϵ";				
				printMessage($message, "admin.php");
				exit();
			}
			if($administrator->get("admin_password") == $adminPassword){	//��������Ƿ���ȷ
			//������ȷ�����

				$administrator->setSESSION();	//��¼�ɹ������û��� ID ��� SESSION ��

				//��¼�ɹ��󣬽��ϴε�¼�� ʱ�� �� IP ȡ������� SESSION
				$admin_last_loaded_time = $administrator->get("admin_last_loaded_time");
				$admin_last_loaded_ip = $administrator->get("admin_last_loaded_ip");
				$_SESSION['admin_last_loaded_time'] = date("Y-m-d H:i:s", $admin_last_loaded_time);
				$_SESSION['admin_last_loaded_ip'] = $admin_last_loaded_ip;

				$IP	= $_SERVER['REMOTE_ADDR'];
				$time = time();

				$administrator->set("admin_password_remain_times", "15");	//�����ǰ�Ĵ����¼������Ϣ������¼�����ָ��� 15 ��
				$administrator->set("admin_last_loaded_ip", $IP);		//�������һ�ε�¼�� IP��ַ
				$administrator->set("admin_last_loaded_time", $time);	//�������һ�ε�¼��ʱ��

				

				header("location:./admin.php");	//��¼�ɹ�����ת�� admin.php ҳ��
			}else{

				$num = $administrator->get("admin_password_remain_times") - 1;	//����������ʣ���¼������һ
				
				if($num < 1){	//����Ƿ�Ӧ�������ʻ�
					$administrator->set("admin_password_remain_times", 0);
					$administrator->set("admin_locked", "1");
					$administrator->destroySession();
					$message = "�����ʻ��Ѿ����������������Ա��ϵ";
					printMessage($message, "admin.php");
					exit();
				}else{
					$administrator->set("admin_password_remain_times", $num);
					$administrator->destroySession();
					$message = "�û���/��������������Գ���".$num."��";
					printMessage($message, "admin.php");
					exit();
				}
			}			
		}else{	
		//�û������ڵ����

			$administrator->destroySession();
			$message = "�û��������ڣ�����������";
			printMessage($message, "admin.php");
			exit();			
		}
	}
?>

<html>
	<head>
		<title>::<?php echo $webName;?>-��̨����ϵͳ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
		<link rel="stylesheet" type="text/css" href="./css/main.css">
	</head>
	
	<body class="head_2" topmargin=5 leftmargin=5>
		<br><br><br><br><br><br><br>
		<form action="" method="post">
			<table width="50%" cellpadding="0" cellspacing="1" border="0" align="center" class="i_table">
				<tr><td valign="middle" align="center" class="b">
				<br><br><b>���������Ĺ���Ա�û���������</b><br><br>
				<table width="350" align="center" cellspacing="1" cellpadding="0" class="i_table">
				<tr>
				<td>
				<table width="100%"  cellspacing="0" cellpadding="3">
				<tr bgcolor='#ffffff'>
				<td valign="middle" width="40%" align="right">
				���������ԱID
				</td>
				<td valign="middle">
				<input type="text" size="20" name="admin_name" >
				</td>
				</tr>
				<tr bgcolor='#ffffff'>
				<td valign="middle" width="40%" align="right">
				���������Ա����
				</td>
				<td valign=middle>
				<input type="password" size="21" name="admin_pwd">
				</td>
				</tr>
				</table></td></tr></table><br><input type="submit" name="submit" value="�� ��" class="BigButton" >
				<br><br>
				<br>
				<br>
				</td></tr>
			</table>
		</form>
	</body>
</html>