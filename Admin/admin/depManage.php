<?php

	require_once(ROOT_PATH."admin/check.php");

	$sql	=	"SELECT * FROM {$administrator->dbAdmin}`dep`";

	$query	=	$db->query($sql);	

?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<link rel="stylesheet" type="text/css" href="./css/main.css">

<table width='95%' align=center cellspacing=1 cellpadding=3 class="i_table">

<tr><td class=head colspan=9><b>�༭����</b></td></tr>

<tr align=center class="b">

<td width="300">��������</td><td>�༭</td><td>ɾ��</td></tr>

<?php 

	

	while ($rs = $db->fetch_object($query)) {		

?>

<tr align=center class="b">

<td><?php echo $rs->name;?></td>

<td><a href="./admin.php?action=admin/depEdit&job=edit&cid=<?php echo $rs->id?>">�༭</a></td>

<td><a href="#" onclick="return checkset('./admin.php?action=admin/depEdit&job=delete&cid=<?php echo $rs->id;?>')">ɾ��</a></td></tr>

<?php

	}

?>

</table>

<br>

<script language='JavaScript'>

function checkset(chars)

{	

	if(!confirm("ȷʵҪɾ���ò��ţ�"))

		return false;

	location.href=chars;

}

</script>