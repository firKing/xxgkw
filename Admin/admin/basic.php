<?php

	//require_once("check.php");

	if (@$_POST['basic']) {		

		$f = fopen("inc/conf.php","w");

		fwrite($f,"<?php\n");

		$s = "\$webName=\"".$_POST['webName']."\";\n";		

		fwrite($f,$s);

		$s = "\$webAddress=\"".$_POST['webAddress']."\";\n";

		fwrite($f,$s);

		$s = "\$tel=\"".$_POST['tel']."\";\n";

		fwrite($f,$s);

		$s = "\$addr=\"".$_POST['addr']."\";\n";

		fwrite($f,$s);

		$s = "\$webEmail=\"".$_POST['webEmail']."\";\n";

		fwrite($f,$s);

		$s = "\$linkName1=\"".$_POST['linkName1']."\";\n";

		fwrite($f,$s);

		$s = "\$linkAddress1=\"".$_POST['linkAddress1']."\";\n";		

		fwrite($f,$s);

		$s = "\$linkName2=\"".$_POST['linkName2']."\";\n";

		fwrite($f,$s);

		$s = "\$linkAddress2=\"".$_POST['linkAddress2']."\";\n";

		fwrite($f,$s);

		$s = "\$linkName3=\"".$_POST['linkName3']."\";\n";

		fwrite($f,$s);

		$s = "\$linkAddress3=\"".$_POST['linkAddress3']."\";\n";

		fwrite($f,$s);	

		$s = "\$post=\"".$_POST['post']."\";\n";

		fwrite($f,$s);				

		fwrite($f,"\n?>");

		fclose($f);		

		$message = "�����ɹ�";

		printMessage($message,"./admin.php?action=admin/basic",1);

		die();

	}

?>

<link rel="stylesheet" type="text/css" href="./css/main.css">

<form action="./admin.php?action=admin/basic" method="post" name="basic">

<table width='95%' align=center cellspacing=1 cellpadding=3 class="i_table">

<tr><td class=head align=center colspan=2><b>��վ��������</b></td></tr>

<tr class="b"><td>��վ���ƣ�</td>

<td><input type="text" name="webName" size=70 value="<?php echo $webName;?>"></td></tr>

<tr class="b"><td>��վ��ַ��</td>

<td><input type="text" name="webAddress" size=70  value="<?php echo $webAddress;?>"></td></td></tr>

<tr class="b"><td>��ϵ�绰��</td>

<td><input type="text" name="tel" size=70  value="<?php echo $tel;?>"></td></tr>

<tr class="b"><td>��ϸ��ַ��</td>

<td><input type="text" name="addr" size=70  value="<?php echo $addr;?>"></td></tr>

<tr class="b"><td>�������룺</td>

<td><input type="text" name="post" size=70  value="<?php echo $post;?>"></td></tr>

<tr class="b"><td>E-mail��</td>

<td><input type="text" name="webEmail" size=70 value="<?php echo $webEmail;?>" ></td></tr>

<tr class="b"><td>��������1��</td>

<td><input type="text" name="linkName1" size=70  value="<?php echo $linkName1;?>"></td></tr>

<tr class="b"><td>���ӵ�ַ1��</td>

<td><input type="text" name="linkAddress1" size=70  value="<?php echo $linkAddress1;?>"></td></tr>

<tr class="b"><td>��������2��</td>

<td><input type="text" name="linkName2" size=70  value="<?php echo $linkName2;?>"></td></tr>

<tr class="b"><td>���ӵ�ַ2��</td>

<td><input type="text" name="linkAddress2" size=70  value="<?php echo $linkAddress2;?>"></td></tr>

<tr class="b"><td>��������3��</td>

<td><input type="text" name="linkName3" size=70  value="<?php echo $linkName3;?>"></td></tr>

<tr class="b"><td>���ӵ�ַ3��</td>

<td><input type="text" name="linkAddress3" size=70  value="<?php echo $linkAddress3;?>"></td></tr>

</table>

<br><center><input type=submit value="�� ��" name="basic">&nbsp;&nbsp;<input type=reset value="�� ��"></center></form>