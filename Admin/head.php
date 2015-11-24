<?php
/*
* 文件名:head.php
* 功能:显示页面中顶部的内容，三个友情链接
* 更新日志:
* 2012.11.01	黄劼	代码整理
*/
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<table width="99%" align="center" cellspacing="2" cellpadding="4" border="0">
	<tr class="head">
    	<td width='30%' align="center"><a href='<?php echo $linkAddress1;?>' target='_blank'><b><?php echo $linkName1;?></b></a></td>
    	<td width='30%' align="center"><a href='<?php echo $linkAddress2;?>' target='_blank'><b><?php echo $linkName2;?></b></a></td>
    	<td width='30%' align="center"><a href='<?php echo $linkAddress3;?>' target='_blank'><b><?php echo $linkName3;?></b></a></td>
	</tr>
</table>
<br>
<br>