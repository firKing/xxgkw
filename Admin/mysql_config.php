<?php
/*
* 文件名:mysql_config.php
* 功能:数据库配置文件
* 工作流程:
* 把数据库的配置在这里写好，然后包含此文件，用里面定义的常量传入自己的 mysql 类中
* 更新日志:
* 2012.11.14	黄劼	创建
*/
	$serverName = "localhost";	//服务器名
	$userName = "xxgkw";			//用户名
	$passWord = "hongyanredrock";		//密码
	$databaseName = "xxgkw";  //数据库名
	$charset = "gbk";			//字符集

	define("SERVER", $serverName);
	define("USERNAME", $userName);
	define("PASSWORD", $passWord);
	define("DATABASE_NAME", $databaseName);
	define("CHARSET", $charset);
?>