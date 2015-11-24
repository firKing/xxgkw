<?php

	require_once(ROOT_PATH."admin/check.php");

	$sql	=	"SELECT * FROM {$administrator->dbAdmin}`dep`";

	$query	=	$db->query($sql);	

?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<link rel="stylesheet" type="text/css" href="./css/main.css">

<table width='95%' align=center cellspacing=1 cellpadding=3 class="i_table">

<tr><td class=head colspan=9><b>编辑部门</b></td></tr>

<tr align=center class="b">

<td width="300">部门名称</td><td>编辑</td><td>删除</td></tr>

<?php 

	

	while ($rs = $db->fetch_object($query)) {		

?>

<tr align=center class="b">

<td><?php echo $rs->name;?></td>

<td><a href="./admin.php?action=admin/depEdit&job=edit&cid=<?php echo $rs->id?>">编辑</a></td>

<td><a href="#" onclick="return checkset('./admin.php?action=admin/depEdit&job=delete&cid=<?php echo $rs->id;?>')">删除</a></td></tr>

<?php

	}

?>

</table>

<br>

<script language='JavaScript'>

function checkset(chars)

{	

	if(!confirm("确实要删除该部门？"))

		return false;

	location.href=chars;

}

</script>