<?php
/*
* 文件名:page.php
* 功能:添加统一的分页程序，按规定格式输出列表
* 工作流程:
* 参数：	
* $sql：sql语句
* $page：当前页码
* $cols：表格列数
* $url：用 basename(__FILE__); 列表网页地址
* $get：get方式传参
* $function：列表的函数名称
* $max：每页最大条数
* 返回值：分页表格HTML代码
* 更新日志:
* 2012.11.12	黄劼	代码整理
* 2008.10.10 	张成伟	更改格式思路，采用函数形式 
* 2008.08.13	张成伟	强制修改页码,不准超出范围 
* 2007.05.04 	张成伟	强制修改页码,不准超出范围 
* 2007.04.28 	张成伟	规范内容  添加页码范围控制
* 2007.04.15	张成伟	第一次编写
*/
	if(!class_exists("mysql")){
		require_once("mysql.php");
	}

	function page_list($type = 0, $rs = ""){
		if($type == 1){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<!-- 显示分页标题栏 -->
	<tr>
		<td>序号</td>
		<td>标题</td>
		<td>时间</td>
		<td>添加人</td>
		<td>修改</td>
		<td>删除</td>
	</tr>
<?php
		}elseif($type==2){
?>
<!-- 显示分页内容栏 -->
	<tr>
		<td colspan="6" align="center" style="color:#ff0000;">没有数据</td>
	</tr>
</table>
<?php
		}else{
?>
<!-- 显示分页内容栏 -->
	<tr>
		<td><?php echo $rs->id; ?></td>
		<td><?php echo $rs->title; ?></td>
		<td><?php echo $rs->time; ?></td>
		<td><?php echo $rs->adder; ?></td>
		<td><a href="admin.php?action=fileEdit&id=<?php echo $rs->id; ?>">修改</a></td>
		<td><a href="admin.php?action=fileDel&id=<?php echo $rs->id; ?>">删除</a></td>
	</tr>
<?php
		}
	}
	function page($sql, $page = 1, $cols = 1000, $url = "", $get = "", $function = "page_list", $max = 20){
		global $db;
		
		/* 初时化变量 */
		$url = $url? $url: basename(__FILE__);
		$get = $get? $get: $_GET;
		
		/* 输出样式表 */
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

		/* 输出页码头部 */
		$function(1);
		
		/* 将链接上加上GET传值,确定$url */
		foreach($get as $key => $val){
			if($key != "page"){
				if( ereg("\?",$url)!= NULL ){
					$url.="&".$key."=".$val;
				}else{
					$url.="?".$key."=".$val;
				}	
			}
		}

		/* 连接页码GET代码 */
		if(ereg("\?", $url) != NULL){
			$url.="&";
		}else{
			$url.="?";
		}
			
		/* 计算信息条数 */
		$que = $db->query($sql);
		$nums = $db->num_rows($que);
		
		/* 无相关数据，输出警告 */
		if($nums == 0){
			$function(2);
		}
		
		/* 生成最后一页的号码 */
		if($nums % $max == 0){
			$pages = $nums / $max;
		}else{
			$pages=floor(($nums-1)/$max)+1;
		}

		/* 判断页码范围 */
		if(($page < 1) || ($page > $pages)){
			$page = 1;
		}
			
		/* 判断页码范围(提交表单时的js事件) */
		
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

		/* 执行新的SQL语句 */
		$sql .= " limit ".(($page-1)*$max).",".$max.";";
		$que = $db->query($sql);
		
		/* 输出页码列表 */
		while($rs = $db->fetch_object($que)){
			$function(0,$rs);
		}
		
		/* 输出页码信息 */
		echo "	<tr class=\"page\">\n";
		echo "		<td colspan=\"".$cols."\" align=\"center\"><form onSubmit=\"return changePage(page.value);\">您在第".$page."页，".$max."篇/页，共".$pages."页<a href=\"".$url."page=1\">【首页】</a>";
		if($page>1)
			echo "<a href=\"".$url."page=".($page-1)."\">【上页】</a>";
		else
			echo "【上页】";
		if($page<$pages)
			echo "<a href=\"".$url."page=".($page+1)."\">【下页】</a>";
		else
			echo "【下页】";
		echo "<a href=\"".$url."page=".$pages."\">【尾页】</a>快速定位至<input name=\"page\" id=\"page\" type=\"text\" class=\"bgcolor\" title=\"回车换页\" size=\"3\"onkeyup=\"judgePage(this);\"  onafterpaste=\"judgePage(this);\" onKeyPress=\"judgePage(this);\" onFocus=\"judgePage(this);\" onChange=\"judgePage(this);\" />页<input type=\"button\" onClick=\"changePage(page.value);\" value=\"跳转\" /></form></td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		
		$db->free_result($que);
	}
?>