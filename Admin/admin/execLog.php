<?php
/*
* �ļ���:execLog.php
* ����:����һЩִ����־
* ������־:
* 2012.11.12	�Ƅ�	��������, �޸���һЩ�� @ ���δ����д��
*/
	require_once(ROOT_PATH."admin/check.php");
	
	if(isset($_POST['delLog']) && $_POST['delLog'] == "ɾ��"){
		if(isset($_POST['delAll']) && $_POST['delAll'] == "on"){
				$sql="DELETE FROM `execLog`";
				$db->query($sql);
		}else{
			foreach($_POST as $key => $val){
				if(is_numeric($key)){
					$sql = "DELETE FROM `execLog` WHERE `id` = '".$key."'";
					$db->query($sql);
				}
			}
		}
		printMessage("ɾ����־�ɹ�", "admin.php?action=".$_GET['action']);
	}
	
	@$page = $_GET['page'] ? $_GET['page'] : 1;
	if(!is_numeric($page)){
		require_once(ROOT_PATH."admin/quit.php");
	}
		
	$sql = "SELECT COUNT(*) AS num FROM `execLog`";
	$query = $db->query($sql);
	$rs = $db->fetch_object($query);
	$nums = $rs->num;
	$num = 15;
	$pages = (int)(($nums-1)/$num)+1;
	if ($page	>	$pages)
		$page	=	$pages;
  	$start = ($page-1) * $num;
	$sql = "SELECT * FROM `execLog` ORDER BY `exec_date` DESC LIMIT ".$start.", ".$num."";
	$query = $db->query($sql);
?>
<link rel="stylesheet" type="text/css" href="./css/main.css">
<table width='95%' align="center" cellspacing="1" cellpadding="3" class="i_table">
<form method="post">
<script>
function check(){
	obj=document.getElementsByTagName('INPUT');
	allsc=document.getElementById('allc');
	delal=document.getElementById('delAll').checked;
	for(n=0;n<obj.length;n++){
		obj[n].checked=allsc.checked;
	}
	document.getElementById('delAll').checked=delal;
}
</script>
<tr><td class="head" align="center" colspan="6"><b>�鿴��־</b></td></tr>
<tr class="b"><td align="center">ID</td><td align="center">����</td>
<td align="center">·��</td><td align="center">ʱ��</td><td align="center">IP</td>
<td align="center"><input name="checkbox" type="checkbox" id="allc" onclick="check()" /><input type="submit" name="delLog" value="ɾ��" /><br><label style="vertical-align:bottom"><input name="delAll" id="delAll" type="checkbox" style=" width:12px; height:12px; vertical-align:bottom"/><span style="vertical-align:bottom; font-size:12px; line-height:12px; height:12px">���</span></label></td>
</tr>
<?php
	while ($rs = $db->fetch_object($query)){
?>
<tr class="b"><td align="center"><? echo $rs->id;?></td><td align="center"><? echo $rs->user_name;?></td>
<td><? echo $rs->exec_url;?></td>
<td align="center"><? echo $rs->exec_date;?></td><td align="center"><? echo $rs->exec_ip;?></td>
<td align="center"><input type="checkbox" name="<? echo $rs->id;?>" /></td>
</tr>
<?
	}
?>
</form>
</table>
<br><center>��&nbsp;<?php echo $nums;?>&nbsp;����־&nbsp;&nbsp;<?php echo $num;?>��/ҳ&nbsp;&nbsp;&nbsp;
<a href="<?php echo $_SERVER['PHP_SELF']?>?action=admin/execLog">��һҳ</a>&nbsp;
<a href="<?php echo $_SERVER['PHP_SELF']?>?action=admin/execLog&page=<?php echo $page-1 ? $page-1 : 1;?>">��һҳ</a>&nbsp;
<a href="<?php echo $_SERVER['PHP_SELF']?>?action=admin/execLog&page=<?php echo $page+1?>">��һҳ</a>&nbsp;
<a href="<?php echo $_SERVER['PHP_SELF']?>?action=admin/execLog&page=<?php echo $pages;?>">���һҳ</a></center>