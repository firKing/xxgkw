<?php

	$filePath = "../install";
	$fileNameStep = $filePath . "/index.php";
	$fileNameStep2 = $filePath . "/index2.php";
	if (!file_exists($filePath))
		mkdir($filePath);
	/********************************************/
	/*	把表的结构转换成为SQL						*/
	/********************************************/ 
	function tableToSQL($table){			
		global $db;
		$tabledump[0] = "DROP TABLE IF EXISTS $table;";
		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = mysql_fetch_row($createtable);
		$tabledump[1] = $create[1].";"; 
		return $tabledump;
	}
	
	
	/********************************************/
	/*	把表的结构和数据转换成为SQL					*/
	/********************************************/ 
	function dataToSQL($table){
		global $db;
		$mydata[0] = "DROP TABLE IF EXISTS $table;";
		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_row($createtable);
		$mydata[1] = $create[1].";";

		$rows = $db->query("SELECT * FROM $table");
		$numfields = $db->num_fields($rows);
		$numrows = $db->num_rows($rows);
		$j = 1;
		while ($row = $db->fetch_row($rows)){
  			$comma = "";
			$j++;  	
			$mydata[$j] = "INSERT INTO $table VALUES(";		
  			for($i = 0; $i < $numfields; $i++) {				
   				$mydata[$j] .= $comma . "'" .mysql_escape_string($row[$i]). "'";
				$comma = ",";   				
  			}
  			$mydata[$j] .= ");";
		}		
		return $mydata;
	}
	
	//	写前台文件
	$s = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /><title>安装网站</title><link href=\"../admin/css/main.css\" rel=\"stylesheet\" type=\"text/css\" /></head><script language=\"javascript\">function check(){if (install.dataAddress.value == \"\"){alert(\"请输入数据库服务器地址\");	install.dataAddress.focus();		return false;}if (install.dataAdmin.value == \"\"){alert(\"请输入数据库用户名\");			install.dataAdmin.focus();return false;}if (install.dataName.value == \"\"){alert(\"请输入数据库名\");			install.dataName.focus();return false;}if (install.admin.value == \"\"){alert(\"请输入后台登陆账号\");			install.admin.focus();return false;}		if (install.adminPwd.value == \"\"){alert(\"请输入后台登陆密码\");			install.adminPwd.focus();return false;}	return true;}</script><body><br /><br /><br /><br /><br /><form action=\"index2.php\" method=\"post\" name=\"install\"><table width='50%' align=center cellspacing=1 cellpadding=3 class=\"i_table\"><tr align=\"center\"><td class=head align=center colspan=2><b>安装网站：第一步：网站基本信息</b></td></tr><tr class=\"b\"><td>数据库服务器地址</td><td><input type=\"text\" name=\"dataAddress\" size=70 value=\"localhost\"></td></tr><tr class=\"b\"><td>数据库用户名</td><td><input type=\"text\" name=\"dataAdmin\" size=70></td></tr><tr class=\"b\"><td>数据库密码</td><td><input type=\"password\" name=\"dataPwd\" size=70 ></td></tr><tr class=\"b\"><td>数据库名</td><td><input type=\"text\" name=\"dataName\" size=70 ></td></tr><tr class=\"b\"><td>后台登录账号</td><td><input type=\"text\" name=\"admin\" size=70 ></td></tr><tr class=\"b\"><td>后台登录密码</td><td><input type=\"password\" name=\"adminPwd\" size=70 ></td></tr></table><br><center><input type=submit value=\"下一步\" onclick=\"return check()\" name=\"install\">&nbsp;&nbsp;<input type=reset value=\"重 置\"></center></form></body></html>";
	@$fp = fopen($fileNameStep, "wb");
	if ($fp){
		fwrite($fp,$s);
		fclose($fp);
	}
	else{
		$message = "创建文件失败";
		printMessage($message,"admin.php?action=makeInstall");
		exit();
	}
	
	
	//	写处理文件
	$i=0;
	$table = $db->list_tables();
	while ($rs = $db->fetch_row($table)){
		if ($rs[0] == "admin"  or  $rs[0] == "adminIP"  or $rs[0] == "execLog")
			$sqls[$i] = tableToSQL($rs[0]);
		else
			$sqls[$i] = dataToSQL($rs[0]);
		$i++;
	}
	@$fp = fopen($fileNameStep2, "wb");
	if ($fp){			
		$s = "<?php\n\t\$t = date(\"Y-m-d\");\n\t\$dataAddress = addslashes(\$_POST[\"dataAddress\']);\n\t\$dataAdmin = addslashes(\$_POST[\"dataAdmin\']);\n\t\$dataPwd = addslashes(\$_POST[\"dataPwd\']);\n\t\$dataName = addslashes(\$_POST[\"dataName\']);\n\t\$admin = addslashes(\$_POST[\"admin\']);\n\t\$adminPwd = md5(\$_POST[\"adminPwd\']);\n\tif (\$link = mysql_connect(\$dataAddress, \$dataAdmin, \$dataPwd)){\n\t\tif (mysql_select_db(\$dataName, \$link)){\n\tmysql_query(\"SET NAMES 'GBK'\");";
		foreach ($sqls as $sql){
			foreach ($sql as $sqll)
				$s .= "\n\tmysql_query(\"" . $sqll ."\",\$link);";
		}		
		$s .= "\n\tmysql_query(\"insert into `admin` values(1, '\$admin', '超级管理员', '\$adminPwd', 3, 15, 'No', '','\$t', '', '', 1);\",\$link);\n\techo \"<br><br><br><br><br><center>OK&nbsp;&nbsp;&nbsp;<a href = ../admin/admin.php>Press here to login</a></center>\";\n\t}\n\t else \n\t echo \"<br><br><br><br><br><center>Select database faild&nbsp;&nbsp;&nbsp;<a href = index.php>Press here back</a></center>\";\n\t}\n\t else \n\t echo \"<br><br><br><br><br><center>Connect database faild&nbsp;&nbsp;&nbsp;<a href = index.php>Press here back</a></center>\";";
		$s .= "\n\t\$myarr = file(\"../admin/inc/mysql.php\");\n\t\$myarr[16] = \"		private \\\$dbhost =\\\"\".\$dataAddress.\"\\\";\\n\\t\";\$myarr[18] = \"		private \\\$dbuser =\\\"\".\$dataAdmin.\"\\\";\\n\\t\";\$myarr[20] = \"		private \\\$dbpw =\\\"\".\$dataPwd.\"\\\";\\n\\t\";\$myarr[22] = \"		public \\\$dbname =\\\"\".\$dataName.\"\\\";\\n\\t\";\$data = \"\";\n\t foreach (\$myarr as \$da)\n\t\$data .= \$da;\n\t\$f=@fopen(\"../admin/inc/mysql.php\",\"wb\");\n\t@fputs(\$f,\$data);\n\t@fclose(\$f);";
		$s .= "\n\t\$myarr = file(\"../admin/inc/Administrator.php\");\n\t\$myarr[23] = \"		private \\\$key =\\\"\".\$dataName.\"\\\";\";\n\t\$data = \"\";\n\t foreach (\$myarr as \$da)\n\t\$data .= \$da;\n\t\$f=@fopen(\"../admin/inc/Administrator.php\",\"wb\");\n\t@fputs(\$f,\$data);\n\t@fclose(\$f);";
		$s .= "\n\t?>";
	
		
		//$s = fread($fp, filesize($fileNameStep2));
		fwrite($fp,$s);
		//echo $s;
		fclose($fp);
	}
	else{
		$message = "创建文件失败";
		printMessage($message,"admin.php?action=makeInstall");
	}
	$que=$db->query("SELECT * FROM `menu` WHERE `url`='admin/unlinkInstall';");
	if($db->num_rows($que)==0)
		$db->query("INSERT INTO menu VALUES(null,'删除安装文件','admin/unlinkInstall','1','6','3');");
	$message = "生成安装文件成功！请执行/install/index.php";
	printMessage($message,"admin.php?action=admin/index",1);
?>