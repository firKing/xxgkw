<?
/*
* �ļ���:msg_pass.php
* ����:������ԵĹ���
* ������־:
* 2012.11.12	�Ƅ�	��������
*/
	require_once(ROOT_PATH."inc/table_config.php");

	if(@is_numeric($_GET['pass'])){
		$sql = "UPDATE `".$messagetable."` SET `is_locked` = 'no' WHERE `mid` = '".$_GET['pass']."'";
		$query = $db->query($sql);

		if($query <= 0){
			printMessage("����ʧ�ܣ���������δͨ�����", "./admin.php?action=".$messagefolder."/msg_manage", "����");
			exit();
		}else{
			printMessage("�����ɹ�����������ͨ�����","./admin.php?action=".$messagefolder."/msg_manage", "����");
		}
	}
		if(@is_numeric($_GET['unpass'])){
			$sql = "UPDATE `".$messagetable."` SET `is_locked` = 'yes' WHERE `mid` = '".$_GET['unpass']."'";
			$query = $db->query($sql);
			if($query <= 0){
				printMessage("����ʧ�ܣ��������Գ���", "./admin.php?action=".$messagefolder."/msg_manage", "����");
				exit();
			}else{
				printMessage("�����ɹ����������ѱ�����", "./admin.php?action=".$messagefolder."/msg_manage", "����");
			}
		}
?>