<?php
/*
* �ļ���:page.php
* ����:���ͳһ�ķ�ҳ���򣬰��涨��ʽ����б�
* ��������:
* ������	
* $sql��sql���
* $page����ǰҳ��
* $cols���������
* $url���� basename(__FILE__); �б���ҳ��ַ
* $get��get��ʽ����
* $function���б�ĺ�������
* $max��ÿҳ�������
* ����ֵ����ҳ���HTML����
* ������־:
* 2012.11.12	�Ƅ�	��������
* 2008.10.10 	�ų�ΰ	���ĸ�ʽ˼·�����ú�����ʽ 
* 2008.08.13	�ų�ΰ	ǿ���޸�ҳ��,��׼������Χ 
* 2007.05.04 	�ų�ΰ	ǿ���޸�ҳ��,��׼������Χ 
* 2007.04.28 	�ų�ΰ	�淶����  ���ҳ�뷶Χ����
* 2007.04.15	�ų�ΰ	��һ�α�д
*/
	if(!class_exists("mysql")){
		require_once("mysql.php");
	}

	function page_list($type = 0, $rs = ""){
		if($type == 1){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<!-- ��ʾ��ҳ������ -->
	<tr>
		<td>���</td>
		<td>����</td>
		<td>ʱ��</td>
		<td>�����</td>
		<td>�޸�</td>
		<td>ɾ��</td>
	</tr>
<?php
		}elseif($type==2){
?>
<!-- ��ʾ��ҳ������ -->
	<tr>
		<td colspan="6" align="center" style="color:#ff0000;">û������</td>
	</tr>
</table>
<?php
		}else{
?>
<!-- ��ʾ��ҳ������ -->
	<tr>
		<td><?php echo $rs->id; ?></td>
		<td><?php echo $rs->title; ?></td>
		<td><?php echo $rs->time; ?></td>
		<td><?php echo $rs->adder; ?></td>
		<td><a href="admin.php?action=fileEdit&id=<?php echo $rs->id; ?>">�޸�</a></td>
		<td><a href="admin.php?action=fileDel&id=<?php echo $rs->id; ?>">ɾ��</a></td>
	</tr>
<?php
		}
	}
	function page($sql, $page = 1, $cols = 1000, $url = "", $get = "", $function = "page_list", $max = 20){
		global $db;
		
		/* ��ʱ������ */
		$url = $url? $url: basename(__FILE__);
		$get = $get? $get: $_GET;
		
		/* �����ʽ�� */
		echo "<style>\n"
			."	.page {\n"
			."		font-size:12px;\n"
			."		color:#606062;\n"
			."	}\n"
			."	.page a,td {\n"
			."		font-size:12px;\n"
			."		color:#606062;\n"
			."		text-decoration:none;\n"
			."	}\n"
			."	.page input{\n"
			."		font-size:12px;\n"
			."		color:#606062;\n"
			."		text-decoration:none;\n"
			."		line-height:16px;\n"
			."		height:16px;\n"
			."	}\n"
			."</style>\n";

		/* ���ҳ��ͷ�� */
		$function(1);
		
		/* �������ϼ���GET��ֵ,ȷ��$url */
		foreach($get as $key => $val){
			if($key != "page"){
				if( ereg("\?",$url)!= NULL ){
					$url.="&".$key."=".$val;
				}else{
					$url.="?".$key."=".$val;
				}	
			}
		}

		/* ����ҳ��GET���� */
		if(ereg("\?", $url) != NULL){
			$url.="&";
		}else{
			$url.="?";
		}
			
		/* ������Ϣ���� */
		$que = $db->query($sql);
		$nums = $db->num_rows($que);
		
		/* ��������ݣ�������� */
		if($nums == 0){
			$function(2);
		}
		
		/* �������һҳ�ĺ��� */
		if($nums % $max == 0){
			$pages = $nums / $max;
		}else{
			$pages=floor(($nums-1)/$max)+1;
		}

		/* �ж�ҳ�뷶Χ */
		if(($page < 1) || ($page > $pages)){
			$page = 1;
		}
			
		/* �ж�ҳ�뷶Χ(�ύ��ʱ��js�¼�) */
		
		echo "<script>\n"
			."	function changePage(page){\n"
			."		if((page>=1)&&(page<=".$pages."))\n"
			."			window.location='".$url."page='+page;\n"
			."		return false;\n"
			."	}\n"
			."	function judgePage(obj){\n"
			."		if((obj.value<1)||(obj.value>".$pages."))\n"
			."			obj.value='';\n"
			."		obj.value=obj.value.replace(/\D/g,'');\n"
			."	}\n"
			."</script>\n";

		/* ִ���µ�SQL��� */
		$sql .= " limit ".(($page-1)*$max).",".$max.";";
		$que = $db->query($sql);
		
		/* ���ҳ���б� */
		while($rs = $db->fetch_object($que)){
			$function(0,$rs);
		}
		
		/* ���ҳ����Ϣ */
		echo "	<tr class=\"page\">\n";
		echo "		<td colspan=\"".$cols."\" align=\"center\"><form onSubmit=\"return changePage(page.value);\">���ڵ�".$page."ҳ��".$max."ƪ/ҳ����".$pages."ҳ<a href=\"".$url."page=1\">����ҳ��</a>";
		if($page>1)
			echo "<a href=\"".$url."page=".($page-1)."\">����ҳ��</a>";
		else
			echo "����ҳ��";
		if($page<$pages)
			echo "<a href=\"".$url."page=".($page+1)."\">����ҳ��</a>";
		else
			echo "����ҳ��";
		echo "<a href=\"".$url."page=".$pages."\">��βҳ��</a>���ٶ�λ��<input name=\"page\" id=\"page\" type=\"text\" class=\"bgcolor\" title=\"�س���ҳ\" size=\"3\"onkeyup=\"judgePage(this);\"  onafterpaste=\"judgePage(this);\" onKeyPress=\"judgePage(this);\" onFocus=\"judgePage(this);\" onChange=\"judgePage(this);\" />ҳ<input type=\"button\" onClick=\"changePage(page.value);\" value=\"��ת\" /></form></td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		
		$db->free_result($que);
	}
?>