<?php
/*
* �ļ���:mysql.php
* ����:mysql��
* ������־:
* 2012.11.14 	�Ƅ�	��������
* 2008.08.23	bluesea	����˵������ļ������ļ�����Ĺ���
* 2008.08.12 	bluesea	����mysql����
* 200?.??.??	??		����
*/
	require_once(ROOT_PATH."mysql_config.php");
	error_reporting(2047);
	class mysql{
		
		private 
		$dbhost = SERVER;	//��������ַ
		private $dbuser = USERNAME;	//�������û���
		private $dbpw = PASSWORD;	//����������
		public $dbname = DATABASE_NAME;	//���ݿ�����
		public $charset = CHARSET;	//�ַ���
		public  $rs;		//���ݿ���
		private $links;		//���ݿ�����

		/********************************************/
		/*	���ݿ��ʼ��							*/
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
		/*	���ݿ�����								*/
		/********************************************/
		function connect($dbhost = "", $dbuser = "", $dbpw = "") {	
			$dbhost	= $dbhost? $dbhost : $this->dbhost;
			$dbuser	= $dbuser? $dbuser: $this->dbuser;
			$dbpw =	$dbpw? $dbpw: $this->dbpw;
			if(!$link = @mysql_connect($dbhost, $dbuser, $dbpw)){
				$this->halt('���ӷ�����ʧ��.');
			}
			return $link;
		}

		/********************************************/
		/*	���ݿ�ѡ��								*/
		/********************************************/ 
		function select_db($dbname = "") {	
			$dbname = $dbname? $dbname: $this->dbname;
			return mysql_select_db($dbname, $this->links);
		}
	
		/********************************************/
		/*	���ݿ�����ѯ							*/
		/********************************************/
		function query($sql){
			$query = mysql_query($sql, $this->links);
			$this->rs = $query;		
			if(!$query){
				if($_SERVER['REMOTE_ADDR'] == "172.17.247.157")
					echo $sql;
				$this->halt('��������ѯ����!');	
			}
			return $query;
		}
		/********************************************/
		/*	���ݿ�����ת���ɶ���					*/
		/********************************************/ 
		function fetch_object($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return mysql_fetch_object($rs);
		}

		/********************************************/
		/*	�ӽ������ȡ��һ����Ϊö������			*/
		/********************************************/
		function fetch_row($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return @mysql_fetch_row($rs);
		}

		/********************************************/
		/*	���ݿ�����ת��������					*/
		/********************************************/
		function fetch_array($rs = "", $result_type = MYSQL_ASSOC){
			$rs = $rs? $rs: $this->rs;
			return @mysql_fetch_array($rs, $result_type);
		}

		/********************************************/
		/*	���ݿ���������������					*/
		/********************************************/ 
		function num_rows($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return mysql_num_rows($rs);	
		}
		/********************************************/
		/*	���ݿ��������ֶε���Ŀ				*/
		/********************************************/ 
		function num_fields($rs = ""){	
			$rs = $rs? $rs: $this->rs;
			return  mysql_num_fields($rs);	
		}

		/********************************************/
		/*	�������ݿ������Ĳ���id				*/
		/********************************************/ 
		function insert_id(){	
			return  mysql_insert_id();
		}

		/********************************************/
		/*	���ݿⷵ�ش������id					*/
		/********************************************/
		function errno(){
			return mysql_errno();
		}

		/********************************************/
		/*	���ݿⷵ�ش���							*/
		/********************************************/ 
		function error(){
			return mysql_error();
		}

		/********************************************/
		/*	���ݿ�����Ӱ�����������				*/
		/********************************************/
		function affected_rows(){
			return @mysql_affected_rows();
		}

		/********************************************/
		/*	���ݿ���ʾ����							*/
		/********************************************/
		function halt($message = ""){	
			echo mysql_error();
			echo mysql_errno();
			echo $message;
			exit();
		}	

		/********************************************/
		/*	���ݿ��������						*/
		/********************************************/
		function free_result($rs){
			mysql_free_result($rs);
		}

		/********************************************/
		/*	ת��һ���ַ������� mysql_query 			*/
		/********************************************/
		function escape_string($str){
			return mysql_escape_string($str);
		}

		/********************************************/
		/*	�г����ݿ�								*/
		/********************************************/ 
		function list_dbs(){
			return mysql_list_dbs();
		}	

		/********************************************/
		/*	�г����ݱ�								*/
		/********************************************/ 
		function list_tables($dbname = ""){
			$dbname = $dbname? $dbname: $this->dbname;
			return @mysql_list_tables($dbname);
		}	

		/********************************************/
		/*	�г����ݱ���ֶ�						*/
		/********************************************/ 
		function list_fields($dbname = "", $tablename){
			$dbname = $dbname? $dbname: $this->dbname;
			return mysql_list_fields($dbname, $tablename);
		}	

		/********************************************/
		/*	���ݿ����ӹر�							*/
		/********************************************/ 
		function close($links){
			return mysql_close($this->links);
		}

		/********************************************/
		/*	��SQL���ת���ɶ���						*/
		/********************************************/ 
		function sql2obj($sql){
			$query = $this->query($sql);
			$rs = $this->fetch_object($query);
			@$rs->numrows = $this->num_rows($query);
			return $rs;
		}	

		/********************************************/
		/*	�г����ݿ��е����ݱ�					*/
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
		/*	�����ݱ���							*/
		/********************************************/ 
		function table_dump($table, $fp = 0){
			/* ����ĳЩ�� */
			$hidden	= ($table == "back")? "#": "";
			$sql_data = "";
			$tabledump = $hidden."DROP TABLE IF EXISTS `".$table."`\r\n";
			$tabledump .= $hidden."CREATE TABLE `".$table."` (\r\n";
			$firstfield	= 1;

			/* �ֶ� */
			$fields = $this->query("SHOW FIELDS FROM `".$table."`");
			while($field = $this->fetch_array($fields)){
				/* ���ǵ�һ������ */
				if(!$firstfield){
					$tabledump .= ",\r\n";
				}else{
					$firstfield = 0;
				}

				/* �ֶκ����� */
				$tabledump .= $hidden."   `".$field['Field']."` ".$field['Type']."";
				/* Ĭ��ֵ */
				if(!($field['Default']=="")){
					$tabledump .= " DEFAULT '".$field['Default']."'";
				}

				/* ��ֵ */
				if($field['Null'] != "YES"){
					$tabledump .= " NOT NULL";
				}

				/* ����ֵ */
				if($field['Extra'] != ""){
					$tabledump .= " ".$field['Extra']."";
				}
			}
			$this->free_result($fields);

			/* ���� */
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
			/* ���� */
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
		/*	ִ�ж���sql								*/
		/********************************************/ 
		function querys($sqls){
			foreach( $sqls as $sql)
				if($sql)
					$this->query($sql);
		}

		/********************************************/
		/*	ִ��sql�ļ�								*/
		/********************************************/ 
		function sql_exec($filename) {
			$fp = explode(";", file_get_contents(filename));
			$this->querys($fp);
		}

	}//End for class
?>