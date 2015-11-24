<?php
/*
* �ļ���:Administrator.php
* ����:����Ա�࣬��¼��ʱ��ᴴ�������Ķ��������в���
* ������־:
* 2012.10.30	�Ƅ�	��������
*/

	if(!class_exists("mysql")){	//�ж� mysql ���Ƿ��壬���û�ж��壬����� mysql.php �ļ�
		require_once("mysql.php");
	}
		
	class Admin extends mysql{
		/********************************************/
		/*	������Admin								*/
		/*	���ܣ���վ��̨����Ա					*/
		/*	����ʱ�䣺2007/??/??					*/
		/*	�޸�ʱ�䣺2008/11/14					*/
		/*	�޸���ʷ��								*/
		/*	turing	2007/??/?? �����Ȩ�޻�������	*/
		/*	bluesea	2008/08/28 �̳�mysql��			*/
		/*	bluesea	2008/08/28 ����л����ݿ⺯��	*/
		/*					   �Ӷ�������Ա�ʺ�ͳһ	*/
		/*	bluesea	2008/11/13 ������Ա����Ϊ��վ	*/
		/*					   ����Ա�ͷ�վ����Ա	*/
		/*	bluesea	2008/11/14 ȡ�����ݿ��л�����	*/
		/*					   ֱ���ڱ���ǰ�ӿ���	*/
		/********************************************/	

		public	$dbAdmin = "";	//�û�����
		private $keyString = "This is Redrock admin 2008 System!";	//����ַ������������ܺ� SESSION �����±��õ�
		private $keyIndex;
		private	$dbTemp	= "";	//��ʱ����
		private $loginFlag = 0;
		private $adminId;
		private $admin_name;

		/* ���캯�� */
		function Admin(){
			parent::mysql();
			$this->dbAdmin = "`".$this->dbname."`.";
			$this->checkIP();
			$this->addLog();
			$this->keyIndex = md5($this->keyString);
		}

		function getKey(){	//ȡ���±꣬����±����� SESSION �����д����Ա�˻� ID ��
			return md5($this->keyString);
		}

		function getAdminId(){	//�õ���ǰ�û��� ID
			return $this->adminId;
		}

		function setSESSION(){	//��¼�ɹ��󣬰��û��� ID ��� SESSION ��
			$_SESSION[$this->keyIndex] = $this->adminId;
		}

		function setAdminId(){	//���ݳ�Ա���� admin_name ���ó�Ա���� adminId���Ժ�ȡ��ǰ�û������ݣ��Ͳ���Ҫ�� admin_name ���� adminId ��
			$sql = "SELECT `id` FROM `admin` WHERE `admin_name` = '".$this->admin_name."'";
			$query = mysql_query($sql);
			$row = mysql_fetch_assoc($query);
			$this->adminId = $row['id'];
		}

		function setAdminName($inputAdminName){	//�û�������û����������ݿ�ȡ���û��������Ա������
			$sql = "SELECT `admin_name` FROM `admin` WHERE `admin_name` = '".$inputAdminName."'";
			$query = mysql_query($sql);
			$row = mysql_fetch_assoc($query);
			$this->admin_name = $row['admin_name'];
		}

		function destroySession(){	//��� SESSION ���������Ϣ
			session_unset();
			session_destroy();
		}

		function isLogin(){	//�ж��Ƿ��¼
			if(isset($_SESSION[$this->keyIndex])){
				$this->adminId = $_SESSION[$this->keyIndex];
				//die("isset SESSION");
				return true;
			}else{
				//die("not isset SESSION");
				return false;
			}
		}

		/*
		function changeLoginFlag(){	//�ı��¼״̬
			if($this->loginFlag == 1){
				$this->loginFlag = 0;
			}else{
				$this->loginFlag = 1;
			}
		}
		*/

		function get($key){
			$sql = "SELECT `".$key."` FROM `admin` WHERE `id` = '".$this->adminId."'";
			//die($sql);
			$query = $this->query($sql);
			if($this->num_rows($query) == 1){
				$rs = $this->fetch_object($query);
				return $rs->$key;
			}else{
				return false;
			}
		}

		function set($key, $val){
			$key = str_replace("`","", str_replace(" ","",$key) );
			/* ��ֹ�޸��ֶ� */
			switch($key){
				case "id"		:return false;
				case "admin_name":return false;
			}
			$sql	="UPDATE {$this->dbAdmin}`admin` SET `$key`='$val' WHERE `id` = '".$this->adminId."'";
			$query	=$this->query($sql);
			if($query > 0){
				return true;
			}else{
				return false;
			}
		}

		function getAdminName($id=""){
			$sql = "SELECT `admin_real_name` FROM {$this->dbAdmin}`admin` WHERE `id`='".$this->adminId."'";
			$query = $this->query($sql);
			if($this->num_rows($query) == 1){
				$rs = $this->fetch_object($query);
				return $rs->admin_real_name;
			}
			return "������";
		}
		
		function getAdminNickName($id=""){
			$sql = "SELECT `admin_name` FROM {$this->dbAdmin}`admin` WHERE `id`='".$this->adminId."'";
			$query = $this->query($sql);
			if($this->num_rows($query) == 1){
				$rs = $this->fetch_object($query);
				return $rs->admin_name;
			}
			return "guest";
		}
		
		//************************************************************
		//��������	��	checkRights
		//�޸�ʱ��	��	2008/08/29
		//��������	��	������Ա��Ȩ��
		//����		��	$id ����ID  $menuUrl �����ļ��� 
		//����ֵ	��	true����Ȩ��    false��û��Ȩ��
		//************************************************************
		function checkRights($id="", $menuUrl=""){
			$uid = $this->getAdminId();
			
			if($menuUrl){	//��ѯ�˵���Ϣ
				$sql = "SELECT * FROM `menu` WHERE `url`='".$menuUrl."'";
			}else{ 
				$sql = "SELECT * FROM `menu` WHERE `id`='".$id."'";

			}
			$query = $this->query($sql);
			
			if($this->num_rows($query) != 1){	//û�в鵽Ŀ¼��Ϣ
				return false;
			}

			$rs	= $this->fetch_object($query);
			
			//û�в鵽����Ա��Ϣ
			/*
			if($this->get("admin_real_name")){
				return false;
			}
			*/


			if($this->get("admin_rights") >= $rs->rights_level){
				return true;
			}
			//	�鿴����Ա�ǲ��ǶԴ˰���������Ȩ��
			$sql = "SELECT * FROM `admin` WHERE `admin_menu_rights` LIKE '%#".$rs->id."#%' AND `id`='".$uid."'";
			$query = $this->query($sql);
			if ($this->num_rows($query) == 1) {
				return true;
			}else{
				return false;
			}
		}

		//************************************************************
		//��������	��	checkIP
		//���ʱ��	��	2008/01/05
		//�޸�ʱ��	��	2008/11/14
		//��������	��	���IP��¼���ƣ�������Ա�ĵ�¼IP��ַ
		//����ֵ	��	true����Ȩ��    false��û��Ȩ��
		//************************************************************
		function checkIP(){
			$IP = $_SERVER['REMOTE_ADDR'];
			$adminId = $this->getAdminId();
			$sql = "SELECT `id` FROM `adminip` WHERE `admin_id` = '".$adminId."'";
			$query = $this->query($sql);
			if ($this->num_rows($query) == 0)
				$pass = true;
			else{
				$pass = false;
				while ($rs = $this->fetch_object($query))
					if ($rs->adminIP == $IP){
						$pass = true;
						break;
					}
			}
			if ($pass == false){
				$this->destroySession();
				echo "<script language='javascript'>alert('IP���ƣ�����ϵϵͳ����Ա');top.location='./index.php';</script>";	
				die();
			}
		}

		//************************************************************
		//��������	��	addLog
		//���ʱ��	��	2008/11/15
		//�޸�ʱ��	��	2008/11/15
		//��������	��	��־��¼
		//����ֵ	��	��
		//************************************************************
		function addLog($action = ""){
			//��¼�ɹ���ż�¼
			date_default_timezone_set('Asia/Shanghai'); 

			if($this->isLogin()){
				$date    = date("YmdHis");
				$IP      = $_SERVER['REMOTE_ADDR'];
				$execUrl = explode("admin.php?action=", $_SERVER['REQUEST_URI']);
				$execUrl = $execUrl[count($execUrl)-1];
				$adminId = $this->getAdminId();
				$admin_real_name = $this->get("admin_real_name");
				$sql = "INSERT INTO `execLog` VALUES (NULL,'".$adminId."','".$admin_real_name."','".$execUrl."','".$date."','".$IP."')";
				//������ǲ鿴��־��������¼����
				if(addslashes(@$_GET['action']) != "admin/execLog"){
					$this->query($sql);
				}
			}
		}
	}	
?>