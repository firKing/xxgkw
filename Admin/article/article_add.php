<?php
/*
* 文件名:article_add.php
* 功能:文章添加的功能模块页面
* 工作流程:
* 1.通过 html 代码显示操作界面，
* 2.通过php的操作进行数据库存取
* 更新日志:
* 2012.12.10	黄劼	将允许上传的文件，图片格式改为可以配置，并对SQL语句中的变量做了过滤
* 2012.11.15	黄劼	将时间数据的存储类型改为使用 time() 函数返回的时间戳 int 型
* 2012.11.02	黄劼	在小康和小安的友情提示下，恢复了对 admin/check.php 的包含
* 2012.10.31	黄劼	代码整理
*/


error_reporting(2047);

require_once(ROOT_PATH."admin/check.php");
require_once(ROOT_PATH."inc/inc.php");
require_once(ROOT_PATH."inc/table_config.php");
require_once(ROOT_PATH."thumb.php");

$dep = checkDep();

//允许的图片格式，放在一个数组里
$validPicType = array("jpg", "png");
//允许的附件格式，放在一个数组里
$validFileType = array("zip", "rar", "doc", "txt", "exl");

//根据允许的图片格式，生成一串字符串，用来放入正则中匹配
$picArraySize = count($validPicType);
$perlString = "";
for ($i = 0; $i < $picArraySize; $i++)
{
	if ($i == 0)
		$perlString = $perlString.$validPicType[$i];
	else
		$perlString = $perlString."|".$validPicType[$i];
	$perlString = $perlString."|".strtoupper($validPicType[$i]);
}

//根据允许的图片格式，生成一串字符串，用来放入正则中匹配
$FileArraySize = count($validFileType);
$perlString2 = "";
for ($i = 0; $i < $FileArraySize; $i++)
{
	if ($i == 0)
		$perlString2 = $perlString2.$validFileType[$i];
	else
		$perlString2 = $perlString2."|".$validFileType[$i];
	$perlString2 = $perlString2."|".strtoupper($validFileType[$i]);
}
?>

<?php
	if(isset($_GET['do']) && is_numeric($_GET['do'])){
		$do = $_GET['do'];
	}else if(isset($_POST['do']) && is_numeric($_POST['do'])){
		$do = $_POST['do'];
	}else{
		$do = 0;
}

if(isset($_POST['article_title']) && !empty($_POST['article_title'])){
	$article_ismv = 0;
	$article_type = intval($_POST['art_type']);
	
	$article_title = contentFilter($_POST['article_title']);
	$article_source = contentFilter($_POST['article_source']);
	$article_author = contentFilter($_POST['article_author']);
	$article_content = $_POST['article_content'];

	if(!is_uploaded_file($_FILES['pictures']['tmp_name'][0])){
		if($article_ismv == 2){
			printMessageself("请添加相关图片", "./admin.php?action=".$_GET['action'], "返回");
			exit();
		}
	}

	if($article_title == "" || $article_source == "" || $article_author == "" || $article_content == ""){
		printMessageself("信息不全", "./admin.php?action=".$_GET['action'], "返回");
		exit();
	}

	$time = time();	//取得时间戳
	$ip = $_SERVER['REMOTE_ADDR'];
	$userId = $administrator->getAdminId();

	if(is_numeric(@$_POST['article_id'])){
		$sqlInsArt = "UPDATE `".$arttable."` SET
			`art_title` = '".$article_title."', 
			`art_source` = '".$article_source."', 
			`art_author` = '".$article_author."', 
			`art_content` = '".$article_content."', 
			`art_type` = '".$article_type."', 
			`art_add_user` = '".$userId."', 
			`art_add_ip` = '".$ip."', 
			`art_locked` = 'no', 
			`art_ismv` = '".$article_ismv."', 
			`art_dep` = '".$dep."' 
			WHERE `art_id` = '".$_POST['article_id']."'";	
	}else{
		$sqlInsArt = "INSERT INTO `".$arttable."` 
			(`art_title`, `art_source`, `art_author`, `art_content`, `art_type`, `art_add_user`, `art_add_ip`, `art_add_time`,  `art_click`, `art_locked`, `art_ismv`, `art_dep`)
			VALUES 
			('".$article_title."', '".$article_source."', '".$article_author."', '".$article_content."', '".$article_type."', '".$userId."', '".$ip."', '".$time."', 0, 'no', '".$article_ismv."', '".$dep."')";
	}
	
	$resInsArt = $db->query($sqlInsArt);

	if($resInsArt <= 0){
		printMessageself((is_numeric($_POST['article_id']) ? "修改" : "添加")."文章出错", "./admin.php?action=".$_GET['action'], "返回");
		exit();
	}

	$id = $db->insert_id();//取得上次insert操作产生的id

	if($id == 0){
		$id = $do;
	}
	
	

	/* 添加相关图片 */
	for($n  =0; $n < count($_FILES['pictures']['name']); $n++){
		$perl = "/^.*?\.(".$perlString.")\$/i";
		//die($perl);
		if(is_uploaded_file($_FILES['pictures']['tmp_name'][$n]))
		{
			if(preg_match($perl, $_FILES['pictures']['name'][$n], $match))//判断文件格式
			{
				$tmpname = time()."_".$n.".".$match[1];
				$urls = "upload/pictures";
				$url = $urls;
				
				if(!is_dir($url)){
					mkdir($url);
				}
	
				$fileName = $url."/".$tmpname;
				$fileurl = $urls."/".$tmpname;
				if(isset($_POST['pic_show'][$n]) && $_POST['pic_show'][$n]!=''){
					$pic_show = htmlspecialchars(addslashes($_POST['pic_show'][$n]));
				}else{
					$pic_show = "文章中的图片";
				}
				$thumbDir = "upload/thumb";
				if (!is_dir($thumbDir))
				{
					mkdir($thumbDir);
				}
				$thumbPicName = "thumb_".$tmpname;
				$thumbFile = $thumbDir."/".$thumbPicName;

				if(move_uploaded_file($_FILES['pictures']['tmp_name'][$n], $fileName))
				{
					list($pic_width, $pic_height, $pic_type, $attr) = getimagesize($fileName);
					if($pic_width > 800 || $pic_height > 600)
					{
						thumb($fileName, $fileName, "jpeg", 800, 600, true);
					}
					thumb($fileName, $thumbFile, "jpeg", 304, 244, true);

					$_FILES['pictures']['name'][$n] = mysql_real_escape_string($_FILES['pictures']['name'][$n]);	//进行过滤

					$sqlInsFile = "INSERT INTO `".$pictable."` 
						(`pic_title`, `pic_source`, `pic_type`, `pic_url`, `pic_show`, `pic_add_user`, `pic_add_ip`, `pic_add_time`, `pic_article_id`, `pic_click`, `pic_locked`, `pic_thumbnail_url`) 
						VALUES 
						('".$_FILES['pictures']['name'][$n]."', 'article', '".$article_type."', '".$fileurl."', '".$pic_show."', '".$userId."', '".$ip."', '".$time."', '".$id."', '0', 'no', '".$thumbFile."')";
					$resInsFile = $db->query($sqlInsFile);
					if($resInsFile <= 0){
						printMessageself("添加相关图片：".$_FILES['pictures']['name'][$n]."出错", "./admin.php?action=".$_GET['action'], "返回");
						exit();
					}
				}

			}
		}
	}

	/* 添加相关附件 */
	for($n = 0; $n < count($_FILES['mounts']['name']); $n++){

		$perl = "/^.*?\.(".$perlString2.")\$/i";

		if(is_uploaded_file($_FILES['mounts']['tmp_name'][$n])){
			if(preg_match($perl, $_FILES['mounts']['name'][$n], $match)){	//判断文件格式
				$tmpname = time()."_".$n.".".$match[1];
				$urls = "upload/mounts";
				$url = $urls;
				if(!is_dir($url))
				mkdir($url);
				$fileName = $url."/".$tmpname;
				$fileurl = $urls."/".$tmpname;
				if(move_uploaded_file($_FILES['mounts']['tmp_name'][$n], $fileName)){

					$_FILES['mounts']['name'][$n] = mysql_real_escape_string($_FILES['mounts']['name'][$n]);	//进行过滤

					$sqlInsFile = "INSERT INTO `".$annextable."` 
						(`ann_title`, `ann_source`, `ann_type`, `ann_url`, `ann_show`, `ann_add_user`, `ann_add_ip`, `ann_add_time`, `ann_article_id`, `ann_click`, `ann_lock`) 
						VALUES
						('".$_FILES['mounts']['name'][$n]."', 'article', '".$article_type."', '".$fileurl."', '文章中的附件', '".$userId."', '".$ip."', '".$time."', '".$id."', 0, 'no')";
					$resInsFile = $db->query($sqlInsFile);
					if($resInsFile <= 0){
						printMessage("添加相关附件：".$_FILES['mounts']['name'][$n]."出错", "./admin.php?action=".$_GET['action'], "返回");
						exit();
					}
				}
			}
		}
	}

	if(isset($_POST['article_id']) && is_numeric($_POST['article_id'])){
		$actionStr = "修改";
		printMessageself($actionStr."文章成功", "./admin.php?action=".$_GET['action']."&amp;do=".$_POST['article_id'], "返回");
	}else{
		$actionStr = "添加";
		printMessageself($actionStr."文章成功", "./admin.php?action=".$_GET['action'], "返回");
	}
	
	exit();
}else {
	//require_once("./admin/head.php");
	$sqlSelArt = "SELECT * FROM `".$arttable."` WHERE `art_id` = '".$do."'";
	$resSelArt = $db->query($sqlSelArt);
	$objSelArt = $db->fetch_object($resSelArt);

	?>

<link href="inc/edit.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function checkValue(obj,alerts){
		if (obj.value == "" || obj.value <= 0 ){
			alert(alerts);
			obj.focus();
			return false;
		}
		return true;
	}

	function checkFile(obj, alerts, type, fathe){
		switch(type){
			//图片
		case 0:	
			var fa= "Pic";
			var re = /(jpg|JPG)$/g;
			break;
			//附件
		case 1:	
			var fa= "Mou";
			var re = /(zip|rar|doc|txt|exl)$/g;
			/**/
			
			break;
		}

		if (obj.value != ""){
			if (re.exec(obj.value) == null ){
				alert(alerts+"文件格式错误");
				var addF=document.getElementById('add'+fa+"_"+fathe);
				addF.innerHTML="<input name=\"pictures[]\" type=\"file\"  style=\"width:580;\" onchange=\"checkFile(this,'图片',"+(type==1?"1":"0")+",'"+fathe+"')\"> <input type=\"button\" value=\""+(fathe==1?"添加":"删除")+"\" onclick=\""+(fathe==1?"add":"del")+fa+"("+fathe+");\">";
			}else{
				return true;
			}
		}
		return false;
	}

	function check()
	{

		if (!checkValue(articleAdd.article_title, "请添加文章标题"))

		return false;
		if (!checkValue(articleAdd.article_source, "请添加文章来源"))

		return false;
		if (!checkValue(articleAdd.article_author, "请添加文章作者"))
		return false;
		
		if (!checkValue(articleAdd.art_type, "请选择文章类别"))
		return false;

		if(KE.count('content2') == 0){

			alert("请输入文章内容！");
			return false;
		}
		return true;
	}

	//上传图片	
	var addPicNext = 2;
	function addPic(){
		var addPicss = document.getElementById("addPics");
		newchild = document.createElement("span");
		newchild.id = "addPic_"+addPicNext;
		newchild.innerHTML = "<input name=\"pictures[]\" type=\"file\"  style=\"width:25%;\" onchange=\"checkFile(this,'图片',0,'"+addPicNext+"')\"> 图片说明：<input name=\"pic_show[]\" type=\"text\"  style=\"width:50%;\" /><input type=\"button\" value=\"删除\" onclick=\"delPic("+addPicNext+");\">";
		addPicss.appendChild(newchild);
		addPicNext++;
	}
	function delPic(pic){
		document.getElementById("addPic_"+pic).innerHTML="";
	}
	
	//上传附件	
	var addMouNext = 2;
	function addMou(){
		var addMouss = document.getElementById("addMous");
		addMouss.innerHTML += "<span id=\"addMou_"+addMouNext+"\"><br><input name=\"mounts[]\" type=\"file\"  style=\"width:580;\" onchange=\"checkFile(this,'附件',1,'"+addMouNext+"')\"> <input type=\"button\" value=\"删除\" onclick=\"delMou("+addMouNext+");\"></span>";
		addMouNext++;
	}
	function delMou(mou){
		document.getElementById("addMou_"+mou).innerHTML = "";
	}
	function checkChild()
	{
		if($("#art_type option:selected").val() == 7)
		{
			$("#art_type2").show();
		}
		else
		{
			$("#art_type2").hide();
		}
	}
</script>

<link rel="stylesheet" type="text/css" href="css/main.css">

<body>
<form action="./admin.php?action=<?=$_GET['action'];?>" method="post"
	enctype="multipart/form-data" name="articleAdd"
	onSubmit="return check();"><?=(($do!=0)?"<input type=\"hidden\" name=\"article_id\" value=\"$do\" />":"");?>


<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
	<tr>
		<td class="head" align="center" colspan="3"><b> 添加/修改文章</b></td>
	</tr>
	<tr class="b">
		<td width="15%" align="right">文章标题：</td>
		<td width="85%" colspan="2"><input name="article_title" type="text"
			id="article_title" style="width: 580;"
			value="<?=contentRestore(@$objSelArt->art_title);?>"><span style="color: #FF0000;"> *</span></td>
	</tr>
	<tr class="b">
		<td align="right">文章来源：</td>
		<td colspan="2"><input name="article_source" type="text"
			id="article_source" style="width: 580;"
			value="<?=contentRestore(@$objSelArt->art_source);?>"> <span style="color: #FF0000;">*</span></td>

	</tr>
	<tr class="b">
		<td align="right">文章作者：</td>
		<td colspan="2"><input name="article_author" type="text"
			id="article_author" style="width: 580;"
			value="<?=contentRestore(@$objSelArt->art_author);?>"> <span style="color: #FF0000;">*</span></td>
	</tr>
	<tr class="b">
		<td align="right">文章类别：</td>
		<td colspan="2"><select name="art_type" id="art_type" onchange="checkChild();">
			<option value="0">请选择文章类别</option>
			<?
			$sqlSelType = "SELECT * FROM `".$typetable."` ORDER BY `type_order` ASC";
			//echo $sqlSelType;
			$resSelType = $db->query($sqlSelType);
			while($objSelType = $db->fetch_object($resSelType)){
				//echo $objSelType->type_id;
			?>
			<option value="<?=@$objSelType->typeid;?>"
			<?=(@$objSelArt->art_type == $objSelType->typeid?" selected=\"selected\"":"");?>><?=$objSelType->typedetail;?>
			</option>
			<?
			}
			?>

		</select></td>
	</tr>
	
	<script type="text/javascript" charset="utf-8" src="editor/kindeditor-min.js"></script>
	<script type="text/javascript">
	KE.show({
		id : 'content2',
		resizeMode : 1,
		height : "400px",
		allowPreviewEmoticons : false,
		allowUpload : false,
		filterMode : false,
		item:[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'map', 'code', 'pagebreak',
        'link', 'unlink', '|', 'about'
		]
	});
	</script>
	
	<tr class="b">
		<td align="right" valign="top">文章内容：<br />
		<?php
		if(isset($_GET['do'])&&is_numeric($_GET['do'])){
		?>
			<a href="../art.php?id=<?php echo $_GET['do'];?>" target="_blank">预览</a>&nbsp;&nbsp;&nbsp;
		<?php
		}
		?>
		</td>
		<td colspan="2">
			<textarea id="content2" name="article_content" style="width: 580px; height: 200px; visibility: hidden;">
			<?php
				if(isset($objSelArt->art_content) && !empty($objSelArt->art_content)){
					echo contentRestore($objSelArt->art_content);
					//echo $objSelArt->art_content;
				}
			?>
			</textarea>
		</td>
	</tr>
	<tr class="b">
		<td align="right" valign="middle">相关图片：</td>
		<td colspan="2">
			<?php
			$sqlSelPic = "SELECT * FROM `".$pictable."` WHERE `pic_article_id` = '".$do."' AND `pic_article_id` != '0' AND `pic_source` = 'article'";
			$resSelPic = $db->query($sqlSelPic);
			$pic_num = $db->affected_rows($resSelPic);
			if($pic_num != 0){
			?>
			<table class="i_table" width="95%">
				<tr class="b">
					<td>图片名</td>
					<td>图片说明</td>
					<td>操作</td>
				</tr>
				<?
				while($objSelPic = $db->fetch_object($resSelPic)){
					?>
				<tr class="b">
					<td><a href="<?=$objSelPic->pic_url;?>" target="_blank"><?=$objSelPic->pic_title;?></a></td>
					<td><?php echo $objSelPic->pic_show; ?></td>
					<td><a href="admin.php?action=<?=$folder?>/article_do&do=<?=$do;?>&delPic=<?=$objSelPic->pic_id;?>">删除</a></td>
				</tr>
				<?
				}
				?>
			</table>
			<?php
			}
			?>
			<span id="addPics"><span id="addPic_1">
				<input name="pictures[]" type="file" style="width: 25%;" onChange="checkFile(this,'图片',0,'1')" />
				图片说明：<input type="text" name="pic_show[]" style="width: 50%;" />
				<input type="button" value="添加" name="button_add1" onClick="addPic();"> <br />
			</span></span>
			<font color="#FF0000">支持的图片类型: <?php foreach ($validPicType as $index => $value) {
				echo $value." ";
			} ?></font><br />
		</td>
	</tr>
	<tr class="b">
		<td align="right" valign="middle">相关附件：</td>
		<td colspan="2">
		<?
		$sqlSelAnn = "SELECT * FROM `".$annextable."` WHERE `ann_article_id` = '".$do."'";
		$resSelAnn = $db->query($sqlSelAnn);
		while($objSelAnn = $db->fetch_object($resSelAnn)){
		?>
		<a href="<?=$objSelAnn->ann_url;?>" target="_blank"><?=$objSelAnn->ann_title;?></a>&nbsp;&nbsp;
		<a href="admin.php?action=<?=$folder?>/article_do&do=<?=$do;?>&delAnn=<?=$objSelAnn->ann_id;?>">删除</a><br>
		<?
		}
		?>
		<span id="addMous"><span id="addMou_1">
		<input name="mounts[]" type="file" style="width: 580;" onChange="checkFile(this,'附件',1,'1')" />
		<input type="button" value="添加" name="button_add2" onClick="addMou();">
		<br>
		<font color="#FF0000">类型: <?php foreach ($validFileType as $index => $value) {
				echo $value." ";
			} ?></font></span></span></td>
	</tr>
</table>
<br>
<center>
	<input type=submit value="提 交" onClick="return check()" name="adminAdd">&nbsp;&nbsp;
	<input type=reset value="重 置">
	<?
	if(@$objSelArt->art_id){
	?>&nbsp;&nbsp;
	<input onClick="location.href='admin.php?action=<?=$folder;?>/article_do&del=<?=@$objSelArt->art_id;?>'"
		type=button value="删除">&nbsp;&nbsp;
	<input onClick="location.href='admin.php?action=<?=$folder;?>/article_manage'"
		type=button value="返回">
	<? 
	}
	?>
</center>
<input type="hidden" name="do" value="<?=$do?>">

</form>

<?php
}
?>
</body>
