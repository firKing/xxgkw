<?php
/*
* 文件名:table_config.php
* 功能:关于文章添加时使用的表名的配置
* 工作流程:
* 1.配置一些表名
* 更新日志:
* 2012.11.12	黄劼	从 article 文件夹移动到 inc 文件夹中
* 2012.10.31	黄劼	代码整理
*/

	$prefix		=	"";		//表名前缀

	$pictable =	$prefix."pic";		//图片表
	$annextable	= $prefix."annex";	//附件表
	$typetable = $prefix."type";
	
	//article 中的表名
	$arttable =	$prefix."article";  //文章表
	$folder = "article";

	//message 中的表名
	$messagetable =	$prefix."message";  //留言表
	$messagefolder = "message";
?>