<?php
/*
* �ļ���:article_do.php
* ����:δ֪
* ��������:
* 1.δ֪
* ������־:
* 2012.11.01    �Ƅ�  ��������
*/
	require_once(ROOT_PATH."inc/inc.php");
 	require_once(ROOT_PATH."inc/table_config.php");
	
	function delPic($id, $db, $type = 1, $type2 = 1){
		global $pictable;
		global $annextable;
		if($type2 == 1){
			$sqlSelFile = "SELECT `pic_url`, `pic_id`, `pic_thumbnail_url` 
				FROM `".$pictable."` WHERE ".(($type == 1)?"pic_id":"pic_article_id")."='".$id."' AND `pic_source` = 'article'";
		}else{
			$sqlSelFile = "SELECT `ann_url`, `ann_id` 
				FROM `".$annextable."` WHERE ".(($type == 1)?"ann_id":"ann_article_id")." = '".$id."'";
		}
		$resSelFile = $db->query($sqlSelFile);
		if($db->num_rows($resSelFile) <= 0){
			return true;
		}
		while($objSelFile = $db->fetch_object($resSelFile))

			if(file_exists((($type2 == 1)? $objSelFile->pic_url: $objSelFile->ann_url)))

				if(unlink((($type2 == 1)? $objSelFile->pic_url: $objSelFile->ann_url))>0){

					if($type2 == 1){

						$sqlDelFile = "DELETE FROM `".$pictable."` WHERE `pic_id` = '".( ($type2 == 1)? $objSelFile->pic_id: $objSelFile->ann_id )."'";
						if(file_exists($objSelFile->pic_thumbnail_url)){
							unlink($objSelFile->pic_thumbnail_url);
						}

					}else{
						$sqlDelFile = "DELETE FROM `".$annextable."` WHERE `ann_id` = '".( ($type2 == 1)? $objSelFile->pic_id: $objSelFile->ann_id )."'";
					}

					$resDelFile = $db->query($sqlDelFile);

					if($resDelFile<0){
						return false;
					}

				}

		return true;

	}

?>

<?php
	if(@is_numeric($_GET['del'])){
		$sqlDelArt = "DELETE FROM `".$arttable."` WHERE `art_id` = '".$_GET['del']."'";
		$resDelArt = $db->query($sqlDelArt);
		if($resDelArt <= 0){
			printMessageself("ɾ�����³���", "./admin.php?action=".$folder."/article_manage", "����");
			exit();
		}else{
			if(delPic($_GET['del'], $db, 2, 1)){
				$sqlDelPic = "DELETE FROM `".$pictable."` WHERE `pic_article_id` = '".$_GET['del']."' AND `pic_source` = 'article'";
				$resDelPic = $db->query($sqlDelPic);
				if($resDelPic <= 0){
					printMessageself("ɾ��ͼƬ���ݳ���", "./admin.php?action=".$folder."/article_manage", "����");
					exit();
				}else{
				if(delPic($_GET['del'], $db, 2, 2)){
						$sqlDelAnn = "DELETE FROM `".$annextable."` WHERE `ann_article_id` = '".$_GET['del']."'";
						$resDelAnn = $db->query($sqlDelAnn);
						if($resDelAnn <= 0){
							printMessageself("ɾ���������ݳ���", "./admin.php?action=".$folder."/article_manage", "����");
							exit();
						}
					}else{
						printMessageself("ɾ�������ļ�����","./admin.php?action=".$folder."/article_manage", "����");
						exit();
					}
				}
			}else{
				printMessageself("ɾ��ͼƬ�ļ�����", "./admin.php?action=".$folder."/article_manage", "����");
				exit();
			}
		}
		printMessageself("ɾ�����³ɹ�", "./admin.php?action=".$folder."/article_manage", "����");
		exit();
	}
	else
	if(@is_numeric($_GET['delPic'])){
		if(delPic($_GET['delPic'], $db, 1, 1)){
			printMessageself("ɾ��ͼƬ�ɹ�", "admin.php?action=".$folder."/article_add&do=".$_GET['do'], "����");
			exit();
		}
		printMessageself("ɾ��ͼƬ����", "admin.php?action=".$folder."/article_add&do=".$_GET['do'], "����");
		exit();
	}else if(@is_numeric($_GET['delAnn'])){
		if(delPic($_GET['delAnn'], $db, 1, 2)){
			printMessageself("ɾ�������ɹ�", "admin.php?action=".$folder."/article_add&do=".$_GET['do'], "����");
			exit();
		}
		printMessageself("ɾ����������", "admin.php?action=".$folder."/article_add&do=".$_GET['do'], "����");
		exit();
	}
?>