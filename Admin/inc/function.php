<?php
/*
* �ļ���:function.php
* ����:�������ܼ���
* ������־:
* 2012.11.02	�Ƅ�	�޸��� printMessage ������ $post �������� global ��bug����bug���²����ɹ���ʧ��ҳ��ĵײ���Ϣ�����������Ҳ�������
*/

//���ݹ���
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
//���ݻ�ԭ
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
	$search = array ("'<script[^>]*?>.*?</script>'si",  // ȥ�� javascript
					  "'<[\/\!]*?[^<>]*?>'si",          // ȥ�� HTML ���
					  "'([\r\n])[\s]+'",                // ȥ���հ��ַ�
					  "'&(quot|#34);'i",                // �滻 HTML ʵ��
					  "'&(amp|#38);'i",
					  "'&(lt|#60);'i",
					  "'&(gt|#62);'i",
					  "'&(nbsp|#160);'i"
					  );                    // ��Ϊ PHP ��������
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

//��������	��	safeVal

//��������	��	���ذ�ȫ��sqlֵ

//����		��	$val

//����ֵ	��	

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

//��������	��	getStr

//��������	��	������Ϊ$key�ı�����ֵ��GET��POST

//����		��	$key

//����ֵ	��	

//************************************************************

function getStr($key){

	return $_GET[$key]?$_GET[$key]:($_POST[$key]?$_POST[$key]:"");

}

//************************************************************

//��������	��	getNum

//��������	��	������Ϊ$key�ı�����ֵ��GET��POST

//����		��	$key

//����ֵ	��	

//************************************************************

function getNum($key){

	return (is_numeric($_GET[$key])&&$_GET[$key])?$_GET[$key]:((is_numeric($_POST[$key])&&$_POST[$key])?$_POST[$key]:0);

}

//************************************************************

//��������	��	relativePath

//��������	��	

//����		��	$sql

//����ֵ	��	

//************************************************************

function relativePath($path){

	global $webRootUrl,$webRootPath,$webDirPath;

	return str_replace($webDirPath,"",str_replace($webRootUrl.$webDirPath,"",str_replace($webRootPath.$webDirPath,"",$path)));

}

//************************************************************

//��������	��	addIpLog

//��������	��	�Զ�����û�������־

//����		��	$sql

//����ֵ	��	��

//************************************************************

function addIpLog($name=""){

	global $db,$pageName;

	$name=$name?$name:($pageName?$pageName:"δ����ҳ��");

	@$sql="INSERT INTO `ip` (ipId,ipTime,ipMessage,ipPage,ipRequirePage,ipPageName) VALUES (null,'".date("Y-m-d H:i:s")."','".$_SERVER['REMOTE_ADDR']."','".relativePath($_SERVER['PHP_SELF'])."','".relativePath($_SERVER['HTTP_REFERER'])."','".$name."')";

	$que=$db->query($sql);

}

//************************************************************

//��������	��	getValue

//��������	��	����sql��ѯ���Ľ��

//����		��	$sql

//����ֵ	��	����������

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

//��������	��	alert

//��������	��	��js���뵯��һ����ʾ��

//����		��	$str (Դ�ַ���)  

//����ֵ	��	��

//************************************************************

function alert($str,$type="0"){

	if($type){

		?>alert("<?php echo $str; ?>");<?php

	}else{

		?><script>alert("<?php echo $str; ?>");</script><?php

	}

}



//************************************************************

//��������	��	back

//��������	��	��js���뷵����һҳ��

//����		��	��

//����ֵ	��	��

//************************************************************

function back($type="0"){

	if($type){

		?>history.go(-1);<?php

	}else{

		?><script>history.go(-1);</script><?php

	}

}



//************************************************************

//��������	��	removeHtml

//��������	��	ȥ��ָ���ַ����е�html���롢���

//����		��	$str (Դ�ַ���)  

//����ֵ	��	$strȥ��html���롢��Ǻ�õ����ַ���

//ԭ�� string strip_tags ( string str [, string allowable_tags] )

//************************************************************

function removeHtml($str){

	return strip_tags($str);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // ȥ�� javascript

					 "'<[\/\!]*?[^<>]*?>'si",           // ȥ�� HTML ���

					 "'([\r\n])[\s]+'",                 // ȥ���հ��ַ�

					 "'&(quot|#34);'i",                 // �滻 HTML ʵ��

					 "'&(amp|#38);'i",

					 "'&(lt|#60);'i",

					 "'&(gt|#62);'i",

					 "'&(nbsp|#160);'i",

					 "'&(iexcl|#161);'i",

					 "'&(cent|#162);'i",

					 "'&(pound|#163);'i",

					 "'&(copy|#169);'i",

					 "'&#(\d+);'e");                    // ��Ϊ PHP ��������

	

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

//��������	��	cut

//��������	��	����ָ�������ַ���

//����		��	$str (Դ�ַ���)  

//				$start(��ʼλ��)  

//				$len(��Ҫ����)

//����ֵ	��	$str���غ���ַ���

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
* ������:printMessage
* �����ǣ�ÿ�β����ɹ���ʧ�ܺ������ʾ��Ϣ����ת��ַ�������������ͷ���͵ײ���Ϣ
* @$message:��ʾ����Ϣ����Ȩ�޲���
* @$url:��ת��ַ������
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
		echo "<tr><td colspan=2 align=center><center><a id=backAndGoOn href=\"".$url."\" onclick=\"parent.left.location.href='./admin.php?action=admin/left';\">�� �� �� �� �� ��</a></center></td></tr></table>\n";		
	}else{
		echo "<tr><td colspan=2 align=center><center><a id=backAndGoOn href=\"".$url."\">�� �� �� �� �� ��</a></center></td></tr></table>\n";
	}
	echo "<script>\n backAndGoOn.focus();\n</script>";		
	require_once("foot.php");
	die();
}





//************************************************************

//��������	��	upLoad

//��������	��	html��ʽ�ϴ��ļ�

//����		��	$files	���ϴ�����ļ���Ϣ�����磺$_FILES['newsPic']

//				$type	�������ϴ��ļ������ͣ����磺��jpg|png|gif|bmp��

//				$url	���ϴ�ʧ����ת·�������磺��"./admin.php?action=".$_GET['action']��

//				$dir	���ϴ��ļ��ı���Ŀ¼�����磺��upload��

//				$codir	����ʵ����Ŀ¼�����ǰ׺�����磺��../��

//				$mess	���ϴ��ļ��Ĵ�����ʾ���ƣ����磺���ļ�������ͼƬ��

//����ֵ	��	$fileurl: �ϴ����ļ��ĵ�ַ��$dir���ļ���

//************************************************************

function upLoad($files,$type=".*",$url="./admin.php",$mess="�ļ�",$dir="upload/",$codir="./"){

	$perl="/^.*?\.(".$type.")\$/i";

	if(is_uploaded_file($files['tmp_name']))

	{	

		//�ж��ļ���ʽ

		if(preg_match($perl,$files['name'],$match))

		{

			//�µ��ļ���

			$tmpname=time().date("_Ymd_His").".".$match[1];

			//����·��

			$urls	=$dir;

			$url	=$codir.$urls;

			if(!is_dir($url)) 

				if(!mkdir($url)){

					printMessage("�ϴ�·����".$urls."����ʧ�ܣ��������Ա��ϵ",$url);

					exit();

				}

			$fileName=$url."/".$tmpname;

			//ת���ļ�

			if(move_uploaded_file($files['tmp_name'],$fileName))

			{

				$fileurl=$urls."/".$tmpname;

				return $fileurl;

			}else{

				printMessage($mess."��".$files['name']."��Դ�������������Ա��ϵ",$url);

				exit();

			}

		}else{

			printMessage($mess."��".$files['name']."��ʽ����",$url);

			exit();

		}

	}else{

		printMessage($mess."��".$files['name']."�ϴ���ʽ�����������Ա��ϵ",$url);

		exit();

	}

}



//************************************************************

//��������	��	printMessageself

//��������	��	�ڵ�ǰҳ����ʾ��Ϣ

//����		��		$message ����ӡ����Ϣ   $url��ת��ĵ�ַ 

//����ֵ	��	�� 

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

//��������	��	downLoad

//��������	��	html��ʽ�����ļ�

//����		��	$file	���ļ�·��

//				$name	���ļ�����

//				$speed	�������ٶ� 1000=8,5 kb/s 

//����ֵ	��	�ޣ����������������ļ������������ʾ��

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

		printMessage("�ļ���".$name."�����ڣ��������Ա��ϵ",$url);

		exit();

	}

}

// ---------- ��ҳ���� ----------- //

function page( $page ,$nums , $url ,$max_allarticle=20)

{

  //����Ŀ��: ���ͳһ�ķ�ҳ����

  //������Ա���ų�ΰ

  //������־:2007/04/15 ��һ�α�д

  //		 2007/04/28 �淶����  ���ҳ�뷶Χ����

  //		 2007/05/04 ǿ���޸�ҳ��,��׼������Χ 

  

  //$page  ��ǰҳ��

  //$pages ��ҳ��

  //$nums  ��������

  //$url   �� basename(__FILE__); ������ҳ��ַ

  //$max_allarticle ÿҳ�������

  

  //�ж��Ƿ���GET��������

if( ereg("\?",$url)!= NULL ){

	$url=$url."&";

}else{

	$url=$url."?";

}

	  //�ж����һҳ����

	  if($nums%$max_allarticle==0)

		$pages=$nums/$max_allarticle;

	  else

		$pages=floor($nums/$max_allarticle)+1;

  //�ж�ҳ��Ȩ��(�س�)

  if(empty($page) || !is_numeric($page) || ($page<1) || ($page>$pages)){

	$page=1;
	
  }

  //�ж�ҳ��Ȩ��(�ύ)

  ?>



  <table align="center" class="normal">

	<tr align="center">

	  <td>���ڵ�<?=$page;?>ҳ��</td>

	  <td><?=$max_allarticle;?>ƪ/ҳ��</td>

	  <td>��<?=$pages;?>ҳ</td>

	  <td><a href="<?=$url;?>page=1">[��ҳ]</a></td>

	  <td><? if($page>1) {?><a href="<?=$url;?>page=<?=($page-1);?>"><? }?>[��ҳ]<? if($page>1) {?></a><? }?></td>

	  <td><? if($page<$pages) {?><a href="<?=$url;?>page=<?=($page+1);?>"><? }?>[��ҳ]<? if($page<$pages) {?></a><? }?></td>

	  <td><a href="<?=$url;?>page=<?=$pages;?>">[βҳ]</a></td>



	</tr>

  </table>

  <!--

   onKeyPress="if (event.keyCode==13) changePage(page.value); else if((this.value<1)||(this.value><?=$pages;?>)) this.value='1';" 

  -->

  <?

}//��ҳ����





//************************************************************

//��������	��	checkDep

//��������	��	��鵱ǰ�û���������

//����		��	��

//����ֵ	��	�û��������ŵ�ID

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

//��������	��	encodingConvert

//��������	��	ת���������ַ�����

//����		��	$data:			��ת������飻

//				$in_charset:	����������룻

//				$out_charset:	���������룻

//����ֵ	��	�û��������ŵ�ID

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

/*ͼƬ�������Ҿ�����ʾ����ͼ�ȱ���С��ʾ*/
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