<?php
/*
* 文件名:function.php
* 功能:函数功能集合
* 更新日志:
* 2012.11.02	黄劼	修复了 printMessage 函数中 $post 变量不是 global 的bug，该bug导致操作成功或失败页面的底部信息，邮政编码找不到变量
*/

//内容过滤
function contentFilter($document, $mod=0){
	$document = htmlspecialchars($document);
	if(0==$mod){
		$search = array(
				"#\s+#",
				"#&lt;script.{0,}?&gt;.{0,}?&lt;/script&gt;#Ui"
			//&lt;script      type=\&quot;text/javascript\&quot;&gt;alert(\&quot;s\&quot;);&lt;/script&gt;
			//&lt;script&nbsp;type=\&quot;text/javascript\&quot;&gt;alert(\&quot;s\&quot;);&lt;/script&gt;
			);
		$replace = array(
				"&nbsp;",
				""
			);
		$document = preg_replace($search, $replace, $document);
	}
	if(0==get_magic_quotes_gpc()){
		$document = addslashes($document);
	}
	return $document;
}
//内容还原
function contentRestore($document){
	$document = str_replace("&nbsp;", " ", $document);
	$document = htmlspecialchars_decode($document);
	return stripslashes($document);
}

function replaceHtmlAndJs($document){
	$document = trim($document);
	if (strlen($document) <= 0)
	{
	  return $document;
	}
	$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
					  "'<[\/\!]*?[^<>]*?>'si",          // 去掉 HTML 标记
					  "'([\r\n])[\s]+'",                // 去掉空白字符
					  "'&(quot|#34);'i",                // 替换 HTML 实体
					  "'&(amp|#38);'i",
					  "'&(lt|#60);'i",
					  "'&(gt|#62);'i",
					  "'&(nbsp|#160);'i"
					  );                    // 作为 PHP 代码运行
	$replace = array ("",
					   "",
					   "\\1",
					   "\"",
					   "&",
					   "<",
					   ">",
					   " "
					   );
	return @preg_replace ($search, $replace, $document);
}
//************************************************************

//函数名称	：	safeVal

//函数功能	：	返回安全的sql值

//参数		：	$val

//返回值	：	

//************************************************************
function safeVal($val){

	if($val=='0')

		return "'0'";

	if($val)

		return "'".addslashes($val)."'";

	else

		return "NULL";

}

//************************************************************

//函数名称	：	getStr

//函数功能	：	返回名为$key的变量的值，GET或POST

//参数		：	$key

//返回值	：	

//************************************************************

function getStr($key){

	return $_GET[$key]?$_GET[$key]:($_POST[$key]?$_POST[$key]:"");

}

//************************************************************

//函数名称	：	getNum

//函数功能	：	返回名为$key的变量的值，GET或POST

//参数		：	$key

//返回值	：	

//************************************************************

function getNum($key){

	return (is_numeric($_GET[$key])&&$_GET[$key])?$_GET[$key]:((is_numeric($_POST[$key])&&$_POST[$key])?$_POST[$key]:0);

}

//************************************************************

//函数名称	：	relativePath

//函数功能	：	

//参数		：	$sql

//返回值	：	

//************************************************************

function relativePath($path){

	global $webRootUrl,$webRootPath,$webDirPath;

	return str_replace($webDirPath,"",str_replace($webRootUrl.$webDirPath,"",str_replace($webRootPath.$webDirPath,"",$path)));

}

//************************************************************

//函数名称	：	addIpLog

//函数功能	：	自动添加用户访问日志

//参数		：	$sql

//返回值	：	无

//************************************************************

function addIpLog($name=""){

	global $db,$pageName;

	$name=$name?$name:($pageName?$pageName:"未命名页面");

	@$sql="INSERT INTO `ip` (ipId,ipTime,ipMessage,ipPage,ipRequirePage,ipPageName) VALUES (null,'".date("Y-m-d H:i:s")."','".$_SERVER['REMOTE_ADDR']."','".relativePath($_SERVER['PHP_SELF'])."','".relativePath($_SERVER['HTTP_REFERER'])."','".$name."')";

	$que=$db->query($sql);

}

//************************************************************

//函数名称	：	getValue

//函数功能	：	返回sql查询语句的结果

//参数		：	$sql

//返回值	：	对象结果数组

//************************************************************

function getValue($sql){

	global $db;

	$rs=array();

	$que=$db->query($sql);

	if($db->num_rows($que)<1){

		$rs=0;

	}else{

		while($rss=$db->fetch_object($que)){

			$rs=array_merge_recursive($rs,array($rss));

		}

	}

	return $rs;

}

//************************************************************

//函数名称	：	alert

//函数功能	：	以js代码弹出一个提示框

//参数		：	$str (源字符串)  

//返回值	：	无

//************************************************************

function alert($str,$type="0"){

	if($type){

		?>alert("<?php echo $str; ?>");<?php

	}else{

		?><script>alert("<?php echo $str; ?>");</script><?php

	}

}



//************************************************************

//函数名称	：	back

//函数功能	：	以js代码返回上一页面

//参数		：	无

//返回值	：	无

//************************************************************

function back($type="0"){

	if($type){

		?>history.go(-1);<?php

	}else{

		?><script>history.go(-1);</script><?php

	}

}



//************************************************************

//函数名称	：	removeHtml

//函数功能	：	去除指定字符串中的html代码、标记

//参数		：	$str (源字符串)  

//返回值	：	$str去除html代码、标记后得到的字符串

//原型 string strip_tags ( string str [, string allowable_tags] )

//************************************************************

function removeHtml($str){

	return strip_tags($str);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript

					 "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记

					 "'([\r\n])[\s]+'",                 // 去掉空白字符

					 "'&(quot|#34);'i",                 // 替换 HTML 实体

					 "'&(amp|#38);'i",

					 "'&(lt|#60);'i",

					 "'&(gt|#62);'i",

					 "'&(nbsp|#160);'i",

					 "'&(iexcl|#161);'i",

					 "'&(cent|#162);'i",

					 "'&(pound|#163);'i",

					 "'&(copy|#169);'i",

					 "'&#(\d+);'e");                    // 作为 PHP 代码运行

	

	$replace = array ("",

					  "",

					  "\\1",

					  "\"",

					  "&",

					  "<",

					  ">",

					  " ",

					  chr(161),

					  chr(162),

					  chr(163),

					  chr(169),

					  "chr(\\1)");

	return preg_replace ($search, $replace, $str);

}



//************************************************************

//函数名称	：	cut

//函数功能	：	剪截指定长度字符串

//参数		：	$str (源字符串)  

//				$start(开始位置)  

//				$len(需要长度)

//返回值	：	$str剪截后得字符串

//************************************************************

function cut($str,$start=0,$len){

	$str=removeHtml(trim($str));

	if (strlen($str) > $len){

		for($i=0; $i < $len; $i++)

			if (ord($str[$i]) > 160)

				$i++;

		$str= substr($str,$start,$i);

	}

	return $str;

}



/*
* 函数名:printMessage
* 作用是，每次操作成功或失败后，输出提示信息和跳转地址，并且重新输出头部和底部信息
* @$message:显示的信息，如权限不够
* @$url:跳转地址的链接
*/
function printMessage($message, $url, $left = 0){

	global $webName, $webAddress, $post, $tel, $addr, $webEmail;
	global $linkName1, $linkAddress1, $linkName2, $linkAddress2, $linkName3, $linkAddress3;

	require_once("head.php");
	echo "<table width=\"95%\" align=center cellspacing=0 cellpadding=4>";
	echo "<tr><td align=center valign=middle colspan=2><br><br><br>";
	echo $message;
	echo "<br><br><br><br><br><br></td></tr>";
	if (1 == $left){
		echo "<tr><td colspan=2 align=center><center><a id=backAndGoOn href=\"".$url."\" onclick=\"parent.left.location.href='./admin.php?action=admin/left';\">返 回 继 续 操 作</a></center></td></tr></table>\n";		
	}else{
		echo "<tr><td colspan=2 align=center><center><a id=backAndGoOn href=\"".$url."\">返 回 继 续 操 作</a></center></td></tr></table>\n";
	}
	echo "<script>\n backAndGoOn.focus();\n</script>";		
	require_once("foot.php");
	die();
}





//************************************************************

//函数名称	：	upLoad

//函数功能	：	html方式上传文件

//参数		：	$files	：上传后的文件信息，例如：$_FILES['newsPic']

//				$type	：允许上传文件的类型，例如：“jpg|png|gif|bmp”

//				$url	：上传失败跳转路径，例如：“"./admin.php?action=".$_GET['action']”

//				$dir	：上传文件的保存目录，例如：“upload”

//				$codir	：真实保存目录的相对前缀，例如：“../”

//				$mess	：上传文件的错误提示名称，例如：“文件”、“图片”

//返回值	：	$fileurl: 上传后文件的地址，$dir＋文件名

//************************************************************

function upLoad($files,$type=".*",$url="./admin.php",$mess="文件",$dir="upload/",$codir="./"){

	$perl="/^.*?\.(".$type.")\$/i";

	if(is_uploaded_file($files['tmp_name']))

	{	

		//判断文件格式

		if(preg_match($perl,$files['name'],$match))

		{

			//新的文件名

			$tmpname=time().date("_Ymd_His").".".$match[1];

			//创建路径

			$urls	=$dir;

			$url	=$codir.$urls;

			if(!is_dir($url)) 

				if(!mkdir($url)){

					printMessage("上传路径：".$urls."创建失败，请与管理员联系",$url);

					exit();

				}

			$fileName=$url."/".$tmpname;

			//转移文件

			if(move_uploaded_file($files['tmp_name'],$fileName))

			{

				$fileurl=$urls."/".$tmpname;

				return $fileurl;

			}else{

				printMessage($mess."：".$files['name']."来源不符，请与管理员联系",$url);

				exit();

			}

		}else{

			printMessage($mess."：".$files['name']."格式不符",$url);

			exit();

		}

	}else{

		printMessage($mess."：".$files['name']."上传方式有误，请与管理员联系",$url);

		exit();

	}

}



//************************************************************

//函数名称	：	printMessageself

//函数功能	：	在当前页面显示信息

//参数		：		$message ：打印的信息   $url：转向的地址 

//返回值	：	无 

//************************************************************	

	function printMessageself($message,$link,$button){

		echo "<table width=\"95%\" align=center cellspacing=0 cellpadding=4>";

		echo "<tr><td align=center valign=middle colspan=2><br><br><br>";

		echo $message;

		echo "<br><br><br><br><br><br></td></tr>";

		echo "<tr><td colspan=2 align=center><center><a href=\"$link\">$button</a></center></td></tr></table>";

		//require_once(dirname(__FILE__).'/conf.php');
		require(dirname(__FILE__).'/conf.php');
		if(file_exists(dirname(__FILE__).'/../foot.php')){
			require_once(dirname(__FILE__).'/../foot.php');
		}else{
			require_once(dirname(__FILE__).'/../../foot.php');
		}

	}





//************************************************************

//函数名称	：	downLoad

//函数功能	：	html方式下载文件

//参数		：	$file	：文件路径

//				$name	：文件名称

//				$speed	：下载速度 1000=8,5 kb/s 

//返回值	：	无（操作正常将下载文件，否则错误提示）

//************************************************************

function downLoad($file,$name,$speed=1000){

	if(file_exists($file) && is_file($file)) {

		ob_end_clean();

		header("Cache-control: private");

		header("Content-Type: application/force-download"); 

		header("Content-Length: ".filesize($file));

		header("Content-Disposition:attachment;filename=".$name);

		flush();

		$fd = fopen($file, "rb");

		set_time_limit(0);

		while(!feof($fd)) {

			echo fread($fd, round($speed*1024));

			flush();

			ob_flush();

			sleep(1);

		}  

		fclose ($fd);

	}else{

		printMessage("文件：".$name."不存在，请与管理员联系",$url);

		exit();

	}

}

// ---------- 分页函数 ----------- //

function page( $page ,$nums , $url ,$max_allarticle=20)

{

  //制作目的: 添加统一的分页程序

  //制作人员：张成伟

  //制作日志:2007/04/15 第一次编写

  //		 2007/04/28 规范内容  添加页码范围控制

  //		 2007/05/04 强制修改页码,不准超出范围 

  

  //$page  当前页码

  //$pages 总页码

  //$nums  数据条数

  //$url   用 basename(__FILE__); 返回网页地址

  //$max_allarticle 每页最大条数

  

  //判断是否有GET变量传送

if( ereg("\?",$url)!= NULL ){

	$url=$url."&";

}else{

	$url=$url."?";

}

	  //判断最后一页号码

	  if($nums%$max_allarticle==0)

		$pages=$nums/$max_allarticle;

	  else

		$pages=floor($nums/$max_allarticle)+1;

  //判断页码权限(回车)

  if(empty($page) || !is_numeric($page) || ($page<1) || ($page>$pages)){

	$page=1;
	
  }

  //判断页码权限(提交)

  ?>



  <table align="center" class="normal">

	<tr align="center">

	  <td>您在第<?=$page;?>页，</td>

	  <td><?=$max_allarticle;?>篇/页，</td>

	  <td>共<?=$pages;?>页</td>

	  <td><a href="<?=$url;?>page=1">[首页]</a></td>

	  <td><? if($page>1) {?><a href="<?=$url;?>page=<?=($page-1);?>"><? }?>[上页]<? if($page>1) {?></a><? }?></td>

	  <td><? if($page<$pages) {?><a href="<?=$url;?>page=<?=($page+1);?>"><? }?>[下页]<? if($page<$pages) {?></a><? }?></td>

	  <td><a href="<?=$url;?>page=<?=$pages;?>">[尾页]</a></td>



	</tr>

  </table>

  <!--

   onKeyPress="if (event.keyCode==13) changePage(page.value); else if((this.value<1)||(this.value><?=$pages;?>)) this.value='1';" 

  -->

  <?

}//分页函数





//************************************************************

//函数名称	：	checkDep

//函数功能	：	检查当前用户所属部门

//参数		：	无

//返回值	：	用户所属部门的ID

//************************************************************



function checkDep(){

	global $db,$administrator;

	$id = $_SESSION[$administrator->getKey()];

	$sql = "SELECT `dep` FROM `admin` WHERE `id`='$id'";

	$query = $db->query($sql);

	$rs = $db->fetch_object($query);

	return $rs->dep;



}


//************************************************************

//函数名称	：	encodingConvert

//函数功能	：	转换数组中字符编码

//参数		：	$data:			需转码的数组；

//				$in_charset:	输入数组编码；

//				$out_charset:	输出数组编码；

//返回值	：	用户所属部门的ID

//************************************************************
function encodingConvert(&$data,$in_charset='gbk',$out_charset='utf-8'){
	if(is_string($data)){
		return iconv($in_charset, $out_charset.'//IGNORE', $data);		
	}
	if(is_array($data)&&!empty($data)){
		foreach ($data as $k=>$v){
			$data[$k]=encodingConvert($v,$in_charset,$out_charset);			
		}
	}
	return $data;
	
}

/*图片上下左右居中显示，大图等比缩小显示*/
function picMid($i=0,$targetWidth,$targetHeight,$pic_url,$artHref='',$picAlt=''){
	list($originalWidth, $originalHeight, $type, $attr) = getimagesize($pic_url);
	
	if(($originalWidth <= $targetWidth)&&($originalHeight <= $targetHeight)){
		$returnWidth = $originalWidth;
		$returnHeight = $originalHeight;
		$margin_left = 100+($targetWidth - $returnWidth)/2;
		$margin_left = $margin_left.'px';
		$margin_top = 0;
	}else{
		$targetTan = $targetHeight/$targetWidth;
		$originalTan = $originalHeight/$originalWidth;
		if($originalTan >= $targetTan){
			$returnWidth = $originalWidth/$originalHeight*$targetHeight;
			$returnHeight = $targetHeight;
			$margin_left = 100+($targetWidth - $returnWidth)/2;
			$margin_left = floor($margin_left).'px';
			$margin_top = ($targetHeight - $returnHeight)/2;
			$margin_top = floor($margin_top).'px';	
		}else{
			$returnWidth = $targetWidth;
			$returnHeight = $originalHeight/$originalWidth*$targetWidth;
			$margin_top = '0px';
			$margin_left = '100px';
		}
		//echo $targetHeight;
		//echo '$returnH='.$returnHeight;
	}
	
	$returnWidth = $returnWidth.'px';
	$returnHeight = $returnHeight.'px';
	return "
		<style type=\"text/css\">
			#varPic$i{
				width:$returnWidth;
				height:$returnHeight;
				margin:$margin_top 0 20px $margin_left;
				float:left;
				display:inline;}
		</style>".
		"<a href=\"$pic_url\" rel=\"sexylightbox[group1]\" title=\"$picAlt\"><img id=\"varPic$i\" src=\"$pic_url\"  /></a>
		<div class=\"picMarginBottm\" style=\"clear: both;\";></div>";
}

function showMessage($msg,$url){
	if(empty($url)){
		echo "<script type='text/javascript'>alert('$msg');window.history.go(-1);</script>";
	}else{
		echo "<script type='text/javascript'>alert('$msg');location.href='$url'</script>";
	}
}
?>