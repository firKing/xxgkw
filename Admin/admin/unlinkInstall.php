<?php
	$filePath = "../install";
	$fileNameStep = $filePath . "/index.php";
	$fileNameStep2 = $filePath . "/index2.php";
	if (file_exists($fileNameStep))
		unlink($fileNameStep);
	if (file_exists($fileNameStep2))
		unlink($fileNameStep2);
	if (file_exists($filePath))
		rmdir($filePath);
	if (file_exists($filePath)){
		$message = "ɾ����װ�ļ�ʧ��";
		printMessage($message,"admin.php?action=admin/index");
		exit();
	}
	$db->query("DELETE FROM menu WHERE `url`='admin/unlinkInstall';");
	$message = "ɾ����װ�ļ��ɹ�";
	printMessage($message,"admin.php?action=admin/index",1);
?>