<?php
/*
* 文件名:msg_add.php
* 功能:添加留言的功能
* 更新日志:
* 2012.11.12	黄劼	代码整理
*/
	require_once(ROOT_PATH."inc/table_config.php");

	$dep = checkDep();	
	$do = is_numeric(@$_GET['do'])? @$_GET['do']: (is_numeric(@$_POST['do'])? @$_POST['do']: 0);
	
	if(isset($_POST['msg_title']) && !empty($_POST['msg_title'])){
		$msg_title = htmlspecialchars(addslashes(trim($_POST['msg_title'])));
 	    $msg_content = str_replace(" ", "&nbsp;", (htmlspecialchars(addslashes(trim($_POST['msg_content'])))));
		
		if($msg_title == ""){
			printMessageself("信息不全", "./admin.php?action=".$_GET['action'], "返回");
			exit();
		}

		$time = time();
		$ip = $_SERVER['REMOTE_ADDR'];

		if(is_numeric(@$_POST['mid'])){
			$sqlInsArt = "UPDATE `".$messagetable."` SET 
				`msg_title` = '".$msg_title."', 
				`msg_content` = '".$msg_content."', 
				`msg_add_ip` = '".$ip."',
				`msg_add_time` = '".$time."' 
				WHERE `mid` = '".$_POST['mid']."'";
		}else{
			$sqlInsArt = "INSERT INTO `".$messagetable."` 
				(`msg_title`, `msg_content`, `is_reply`, `is_locked`, `father_id`, `msg_add_time`, `msg_add_ip`)
				VALUES
				('".$msg_title."', '".$msg_content."', 'no', 'yes', '0', '".$time."', '".$ip."')";
		}

		$resInsArt = $db->query($sqlInsArt);
		if($resInsArt <= 0){
			printMessageself((is_numeric($_POST['mid'])? "修改": "添加")."文章出错", "./admin.php?action=".$_GET['action'], "返回");
			exit();
		}
		$id = $db->insert_id();//取得上次insert操作产生的id

		if($id == 0){
			$id = $do;
		}
		
		printMessageself((is_numeric(@$_POST['mid'])? "修改": "添加")."文章成功", "./admin.php?action=".$_GET['action']."&amp;do=".$_POST['mid'], "返回");
		exit();
	}else {
 		$sqlSelArt = "SELECT * FROM `".$messagetable."` WHERE `mid` = '".$do."'";
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

	function check()
	{
	if (!checkValue(articleAdd.article_title,"请添加留言标题!"))
			return false;
	return true;
}
</script>

<link rel="stylesheet" type="text/css" href="css/main.css">
<body>
	<form action="./admin.php?action=<?=$_GET['action'];?>" method="post" enctype="multipart/form-data" name="articleAdd" onSubmit="return check();">
		<?=(($do!=0)?"<input type=\"hidden\" name=\"mid\" value=\"$do\" />":"");?>

		<table  width='55%' align="center" cellspacing="1" cellpadding="3" class="i_table">
			<tr>
				<td class="head" align="center" colspan="3">
					<b>添加/修改留言</b>
				</td>
			</tr>
			<tr class="b">
				<td width="22%" align="right">留言标题：</td>
				<td width="78%" colspan="2"><input name="msg_title" type="text" id="msg_title" style="width:300;" value="<?=@$objSelArt->msg_title;?>"><span style="color:#FF0000;"> *</span></td>
			</tr>
			<tr class="b">
				<td align="right" valign="top">文章内容：</td>
				<td colspan="2">
					<textarea name="msg_content"  style="width:300px; height:100px;"><?=@$objSelArt->msg_content;?></textarea>
				</td>
			</tr>
		</table>
		<br>
		<center>
			<input type="submit" value="提 交" onClick="return check()" name="adminAdd">&nbsp;&nbsp;
			<input type="reset" value="重 置"><? if(@$objSelArt->mid){ ?>&nbsp;&nbsp;
			<input onClick="location.href='admin.php?action=<?=$messagefolder;?>/article_do&del=<?=@$objSelArt->mid;?>'" type=button value="删除">&nbsp;&nbsp;
			<input onClick="location.href='admin.php?action=<?=$messagefolder;?>/msg_manage'" type=button value="返回"><? } ?>
		</center>
		<input type="hidden" name="do" value="<?=$do?>">
	</form>
<?php
	}
?>
</body>