<?php
/*
* 文件名:Administrator.php
* 功能:管理员类，登录的时候会创建这个类的对象来进行操作
* 更新日志:
* 2012.10.30	黄劼	代码整理
*/

	if(!class_exists("mysql")){	//判断 mysql 类是否定义，如果没有定义，则包含 mysql.php 文件
		require_once("mysql.php");
	}
		
	class Admin extends mysql{
		/********************************************/
		/*	类名：Admin								*/
		/*	功能：网站后台管理员					*/
		/*	创建时间：2007/??/??					*/
		/*	修改时间：2008/11/14					*/
		/*	修改历史：								*/
		/*	turing	2007/??/?? 添加了权限基本函数	*/
		/*	bluesea	2008/08/28 继承mysql类			*/
		/*	bluesea	2008/08/28 添加切换数据库函数	*/
		/*					   从而将管理员帐号统一	*/
		/*	bluesea	2008/11/13 将管理员划分为总站	*/
		/*					   管理员和分站管理员	*/
		/*	bluesea	2008/11/14 取消数据库切换功能	*/
		/*					   直接在表名前加库名	*/
		/********************************************/	

		public	$dbAdmin = "";	//用户库名
		private $keyString = "This is Redrock admin 2008 System!";	//这个字符串是用来加密后当 SESSION 数组下标用的
		private $keyIndex;
		private	$dbTemp	= "";	//临时库名
		private $loginFlag = 0;
		private $adminId;
		private $admin_name;

		/* 构造函数 */
		function Admin(){
			parent::mysql();
			$this->dbAdmin = "`".$this->dbname."`.";
			$this->checkIP();
			$this->addLog();
			$this->keyIndex = md5($this->keyString);
		}

		function getKey(){	//取得下标，这个下标是在 SESSION 数组中存管理员账户 ID 的
			return md5($this->keyString);
		}

		function getAdminId(){	//得到当前用户的 ID
			return $this->adminId;
		}

		function setSESSION(){	//登录成功后，把用户的 ID 存进 SESSION 中
			$_SESSION[$this->keyIndex] = $this->adminId;
		}

		function setAdminId(){	//根据成员变量 admin_name 设置成员变量 adminId，以后取当前用户的数据，就不需要传 admin_name 或是 adminId 了
			$sql = "SELECT `id` FROM `admin` WHERE `admin_name` = '".$this->admin_name."'";
			$query = mysql_query($sql);
			$row = mysql_fetch_assoc($query);
			$this->adminId = $row['id'];
		}

		function setAdminName($inputAdminName){	//用户输入的用户名，从数据库取得用户名存进成员属性里
			$sql = "SELECT `admin_name` FROM `admin` WHERE `admin_name` = '".$inputAdminName."'";
			$query = mysql_query($sql);
			$row = mysql_fetch_assoc($query);
			$this->admin_name = $row['admin_name'];
		}

		function destroySession(){	//清空 SESSION 数组里的信息
			session_unset();
			session_destroy();
		}

		function isLogin(){	//判断是否登录
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
		function changeLoginFlag(){	//改变登录状态
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
			/* 禁止修改字段 */
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
			return "无名氏";
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
		//函数名称	：	checkRights
		//修改时间	：	2008/08/29
		//函数功能	：	检测管理员的权限
		//参数		：	$id 板块的ID  $menuUrl 板块的文件名 
		//返回值	：	true：有权限    false：没有权限
		//************************************************************
		function checkRights($id="", $menuUrl=""){
			$uid = $this->getAdminId();
			
			if($menuUrl){	//查询菜单信息
				$sql = "SELECT * FROM `menu` WHERE `url`='".$menuUrl."'";
			}else{ 
				$sql = "SELECT * FROM `menu` WHERE `id`='".$id."'";

			}
			$query = $this->query($sql);
			
			if($this->num_rows($query) != 1){	//没有查到目录信息
				return false;
			}

			$rs	= $this->fetch_object($query);
			
			//没有查到管理员信息
			/*
			if($this->get("admin_real_name")){
				return false;
			}
			*/


			if($this->get("admin_rights") >= $rs->rights_level){
				return true;
			}
			//	查看管理员是不是对此板块有特殊的权限
			$sql = "SELECT * FROM `admin` WHERE `admin_menu_rights` LIKE '%#".$rs->id."#%' AND `id`='".$uid."'";
			$query = $this->query($sql);
			if ($this->num_rows($query) == 1) {
				return true;
			}else{
				return false;
			}
		}

		//************************************************************
		//函数名称	：	checkIP
		//添加时间	：	2008/01/05
		//修改时间	：	2008/11/14
		//函数功能	：	检测IP登录限制，检测管理员的登录IP地址
		//返回值	：	true：有权限    false：没有权限
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
				echo "<script language='javascript'>alert('IP限制，请联系系统管理员');top.location='./index.php';</script>";	
				die();
			}
		}

		//************************************************************
		//函数名称	：	addLog
		//添加时间	：	2008/11/15
		//修改时间	：	2008/11/15
		//函数功能	：	日志记录
		//返回值	：	无
		//************************************************************
		function addLog($action = ""){
			//登录成功后才记录
			date_default_timezone_set('Asia/Shanghai'); 

			if($this->isLogin()){
				$date    = date("YmdHis");
				$IP      = $_SERVER['REMOTE_ADDR'];
				$execUrl = explode("admin.php?action=", $_SERVER['REQUEST_URI']);
				$execUrl = $execUrl[count($execUrl)-1];
				$adminId = $this->getAdminId();
				$admin_real_name = $this->get("admin_real_name");
				$sql = "INSERT INTO `execLog` VALUES (NULL,'".$adminId."','".$admin_real_name."','".$execUrl."','".$date."','".$IP."')";
				//如果不是查看日志操作，记录下列
				if(addslashes(@$_GET['action']) != "admin/execLog"){
					$this->query($sql);
				}
			}
		}
	}	
?>