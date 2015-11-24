<?php
/*
* 文件名:mysql.php
* 功能:mysql类
* 更新日志:
* 2012.11.14 	黄劼	代码整理
* 2008.08.23	bluesea	添加了到处至文件，从文件导入的功能
* 2008.08.12 	bluesea	补充mysql函数
* 200?.??.??	??		创建
*/
	require_once(ROOT_PATH."mysql_config.php");
	error_reporting(2047);
	class mysql{
		
		private 
		$dbhost = SERVER;	//服务器地址
		private $dbuser = USERNAME;	//服务器用户名
		private $dbpw = PASSWORD;	//服务器密码
		public $dbname = DATABASE_NAME;	//数据库名称
		public $charset = CHARSET;	//字符集
		public  $rs;		//数据库结果
		private $links;		//数据库链接

		/********************************************/
		/*	数据库初始化							*/
		/********************************************/	
		function mysql($dbhost = "", $dbuser = "", $dbpw = "",$dbname = ""){
			$this->dbhost = $dbhost? $dbhost: $this->dbhost;
			$this->dbuser = $dbuser? $dbuser: $this->dbuser;
			$this->dbpw = $dbpw? $dbpw: $this->dbpw;
			$this->dbname = $dbname? $dbname: $this->dbname;
			$this->links = $this->connect();
			$this->select_db(); 
			$this->query("SET NAMES '".$this->charset."'");
		}

		/********************************************/
		/*	数据库连接								*/
		/********************************************/
		function connect($dbhost = "", $dbuser = "", $dbpw = "") {	
			$dbhost	= $dbhost? $dbhost : $this->dbhost;
			$dbuser	= $dbuser? $dbuser: $this->dbuser;
			$dbpw =	$dbpw? $dbpw: $this->dbpw;
			if(!$link = @mysql_connect($dbhost, $dbuser, $dbpw)){
				$this->halt('连接服务器失败.');
			}
			return $link;
		}

		/********************************************/
		/*	数据库选择								*/
		/********************************************/ 
		function select_db($dbname = "") {	
			$dbname = $dbname? $dbname: $this->dbname;
			return mysql_select_db($dbname, $this->links);
		}
	
		/********************************************/
		/*	数据库语句查询							*/
		/********************************************/
		function query($sql){
			$query = mysql_query($sql, $this->links);
			$this->rs = $query;		
			if(!$query){
				if($_SERVER['REMOTE_ADDR'] == "172.17.247.157")
					echo $sql;
				$this->halt('服务器查询出错!');	
			}
			return $query;
		}
		/********************************************/
		/*	数据库结果集转化成对象					*/
		/********************************************/ 
		function fetch_object($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return mysql_fetch_object($rs);
		}

		/********************************************/
		/*	从结果集中取得一行作为枚举数组			*/
		/********************************************/
		function fetch_row($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return @mysql_fetch_row($rs);
		}

		/********************************************/
		/*	数据库结果集转化成数组					*/
		/********************************************/
		function fetch_array($rs = "", $result_type = MYSQL_ASSOC){
			$rs = $rs? $rs: $this->rs;
			return @mysql_fetch_array($rs, $result_type);
		}

		/********************************************/
		/*	数据库结果集的数据条数					*/
		/********************************************/ 
		function num_rows($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return mysql_num_rows($rs);	
		}
		/********************************************/
		/*	数据库结果集的字段的数目				*/
		/********************************************/ 
		function num_fields($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return  mysql_num_fields($rs);	
		}

		/********************************************/
		/*	返回数据库结果集的插入id				*/
		/********************************************/ 
		function insert_id(){	
			return  mysql_insert_id();
		}

		/********************************************/
		/*	数据库返回错误代码id					*/
		/********************************************/
		function errno(){
			return mysql_errno();
		}

		/********************************************/
		/*	数据库返回错误							*/
		/********************************************/ 
		function error(){
			return mysql_error();
		}

		/********************************************/
		/*	数据库结果集影响的数据条数				*/
		/********************************************/
		function affected_rows(){
			return @mysql_affected_rows();
		}

		/********************************************/
		/*	数据库显示错误							*/
		/********************************************/
		function halt($message = ""){	
			echo mysql_error();
			echo mysql_errno();
			echo $message;
			exit();
		}	

		/********************************************/
		/*	数据库结果集清空						*/
		/********************************************/
		function free_result($rs){
			mysql_free_result($rs);
		}

		/********************************************/
		/*	转义一个字符串用于 mysql_query 			*/
		/********************************************/
		function escape_string($str){
			return mysql_escape_string($str);
		}

		/********************************************/
		/*	列出数据库								*/
		/********************************************/ 
		function list_dbs(){
			return mysql_list_dbs();
		}	

		/********************************************/
		/*	列出数据表								*/
		/********************************************/ 
		function list_tables($dbname = ""){
			$dbname = $dbname? $dbname: $this->dbname;
			return @mysql_list_tables($dbname);
		}	

		/********************************************/
		/*	列出数据表的字段						*/
		/********************************************/ 
		function list_fields($dbname = "", $tablename){
			$dbname = $dbname? $dbname: $this->dbname;
			return mysql_list_fields($dbname, $tablename);
		}	

		/********************************************/
		/*	数据库连接关闭							*/
		/********************************************/ 
		function close($links){
			return mysql_close($this->links);
		}

		/********************************************/
		/*	将SQL语句转化成对象						*/
		/********************************************/ 
		function sql2obj($sql){
			$query = $this->query($sql);
			$rs = $this->fetch_object($query);
			@$rs->numrows = $this->num_rows($query);
			return $rs;
		}	

		/********************************************/
		/*	列出数据库中的数据表					*/
		/********************************************/ 
		function get_table($dbname = ""){
			$dbname = $dbname? $dbname:	$this->dbname;
			$result = $this->list_tables($dbname);
			while($row = $this->fetch_object($result)){
				$key = "Tables_in_".$dbname;
				if($tablelist == ""){
					$tablelist = $row->$key;
				}else{
					$tablelist .= ",".$row->$key;
				}
			}
			return explode(",", $tablelist);
		}

		/********************************************/
		/*	将数据表导出							*/
		/********************************************/ 
		function table_dump($table, $fp = 0){
			/* 保护某些表 */
			$hidden	= ($table == "back")? "#": "";
			$sql_data = "";
			$tabledump = $hidden."DROP TABLE IF EXISTS `".$table."`\r\n";
			$tabledump .= $hidden."CREATE TABLE `".$table."` (\r\n";
			$firstfield	= 1;

			/* 字段 */
			$fields = $this->query("SHOW FIELDS FROM `".$table."`");
			while($field = $this->fetch_array($fields)){
				/* 不是第一个则换行 */
				if(!$firstfield){
					$tabledump .= ",\r\n";
				}else{
					$firstfield = 0;
				}

				/* 字段和类型 */
				$tabledump .= $hidden."   `".$field['Field']."` ".$field['Type']."";
				/* 默认值 */
				if(!($field['Default']=="")){
					$tabledump .= " DEFAULT '".$field['Default']."'";
				}

				/* 空值 */
				if($field['Null'] != "YES"){
					$tabledump .= " NOT NULL";
				}

				/* 其他值 */
				if($field['Extra'] != ""){
					$tabledump .= " ".$field['Extra']."";
				}
			}
			$this->free_result($fields);

			/* 主键 */
			$keys = $this->query("SHOW KEYS FROM `".$table."`");

			while($key = $this->fetch_array($keys)){
				$kname = $key['Key_name'];

				if ($kname != "PRIMARY" and $key['Non_unique'] == 0){
					$kname = "UNIQUE|$kname";
				}

				if(!is_array($index[$kname])){
					$index[$kname] = array();
				}

				$index[$kname][] = $key['Column_name'];
			}
			$this->free_result($keys);

			// get each key info
			while(list($kname, $columns) = @each($index)){
				  $tabledump .= ",\r\n";
				  $colnames = implode($columns, ",");

				  if ($kname == "PRIMARY"){
					// do primary key
					$tabledump .= $hidden."   PRIMARY KEY ($colnames)";
				  }else{

					// do standard key
					if(substr($kname, 0, 6) == "UNIQUE"){
						  // key is unique
						  $kname = substr($kname, 7);
					}
					$tabledump .= "   KEY $kname ($colnames)";
				  }
			}

			$tabledump .= "\r\n".$hidden.") ENGINE = MyISAM DEFAULT CHARSET=gbk;\r\n\r\n";
			if($fp){
				fwrite($fp, $tabledump);
			}else{
				$sql_data .= $tabledump;
			}
			/* 数据 */
			$rows = $this->query("SElECT * FROM `".$table."`");
			$numfields = $this->num_fields($rows);

			while($row = $this->fetch_array($rows)){
				$tabledump = $hidden."INSERT INTO `".$table."` VALUES(";
				$fieldcounter = -1;
				$firstfield = 1;
				// get each field's data
				while(++$fieldcounter < $numfields){
					   if(!$firstfield){
							$tabledump .= ", ";
					   }else{
							$firstfield = 0;
					   }
					   if(!isset($row[$fieldcounter])){
							$tabledump .= "NULL";
					   }else{
							$tabledump .= "'".$this->escape_string($row[$fieldcounter])."'";
					   }
				}
				$tabledump .= ");\r\n";

				if($fp){
					fwrite($fp,$tabledump);
				}else{
					$sql_data .= $tabledump;
				}
			}
			$this->free_result($rows);

			return $sql_data;
		}

		/********************************************/
		/*	执行多条sql								*/
		/********************************************/ 
		function querys($sqls){
			foreach( $sqls as $sql)
				if($sql)
					$this->query($sql);
		}

		/********************************************/
		/*	执行sql文件								*/
		/********************************************/ 
		function sql_exec($filename) {
			$fp = explode(";", file_get_contents(filename));
			$this->querys($fp);
		}

	}//End for class
?>