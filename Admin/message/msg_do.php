<?php
/*
* �ļ���:msg_do.php
* ����:������ԵĹ���
* ������־:
* 2012.11.12	�Ƅ�	��������
*/
	require_once(ROOT_PATH."inc/table_config.php");

	if(@is_numeric($_GET['del'])){
		$sqlDelArt = "DELETE FROM `".$messagetable."` WHERE `mid` = '".$_GET['del']."'";
		$resDelArt = $db->query($sqlDelArt);

		if($resDelArt <= 0){
			printMessageself("ɾ�����³���", "./admin.php?action=".$messagefolder."/msg_manage", "����");
			exit();
		}

		printMessageself("ɾ�����³ɹ�", "./admin.php?action=".$messagefolder."/msg_manage", "����");
		exit();
	}
?>