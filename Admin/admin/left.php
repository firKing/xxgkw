<?php
/*
* 文件名:left.php
* 功能:显示管理界面的左边的操作列表部分
* 工作流程:
* 1.通过数据库查询出一级分类与二级分类
* 2.根据 Admin 类实例化的对象判断是否有权限，即，是否显示出来
* 3.根据输出的 action ，改变 main frame 显示的管理内容
* 更新日志:
* 2012.10.29	黄劼	代码整理
*/
?>
<link rel="stylesheet" type="text/css" href="css/main.css">
<body topmargin=5 leftmargin=5>
<table width="99%" align=center cellspacing=2 cellpadding=4 border=0>
	<tr>
		<td class=head height=23 align=center>
			<a target='main' href="?action=admin/index"><b>管理区首页</b></a> | <a target='_top' href="?action=admin/quit"><b>退出</b></a>
		</td>
	</tr>
	<tr>
		<td class="b" align=center>
			<a href="#" onClick="return ClearAdminDeploy()">+ 全部展开</a> <a href="#" onClick="return SetAdminDeploy()">- 全部收缩</a>
		</td>
	</tr>
	<?php
		$sql = "SELECT `id`, `name` FROM `menu` WHERE `father_id` = 0 ORDER BY `order` ASC";	//取出操作的一级分类
		$query = $db->query($sql);
		
		$i = 1;

		while($rs = $db->fetch_object($query)){	//循环取数据	循环一：开始

			if(true != $administrator->checkRights($rs->id)){	//判断当前管理员的权限是否够实用这个一级分类
				continue;	//进入这里，即权限不够，将跳出本层循环，进入下一次循环，也就是说，这个一级分类的内容都无法操作
			}
			$i++;
			
			//权限足够的话会到这里，开始根据一级分类的 ID 取二级分类
			$sql2 = "SELECT * FROM `menu` WHERE `father_id` = '".$rs->id."' ORDER BY `order` ASC";
			$query2 = $db->query($sql2);
	?>
	<tr>
		<td class="b">
			<table width="98%" align=center cellspacing=1 cellpadding=3 class=i_table>
				<tr onClick="return IndexDeploy('b<?php echo $i;?>',1)" style="cursor:hand;">
					<td class=head>
						<a style="float:right" href="#" onClick="return IndexDeploy('b<?php echo $i;?>',1)">
							<img id="img_b<?php echo $i;?>" src="./image/cate_fold.gif" border=0>
						</a>
						<b><?php echo $rs->name;?></b>
					</td>
				</tr>
				<tbody id="cate_b<?php echo $i;?>">
					<tr>
						<td class="left_padding">
						<?php 
							while($rs2 = $db->fetch_object($query2)){	//循环去二级分类	循环二：开始
								
								if(true != $administrator->checkRights($rs2->id)){	//判断权限是否够
									continue;	//不够的话将跳出本层循环，取下一个二级分类
								}
								//权限够的话，将输出下面的 HTML 标签，形成分类按钮
						?>
						<a href="admin.php?action=<?php echo $rs2->url?>" target="main"><?php echo $rs2->name;?></a><br>
						<?php
							}	//循环二：结束
						?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<?php
		}	//循环一：结束
	?>
	<tr><td class="head_2" align="center"><a href=<?php echo $webAddress;?> target="_blank"><?php echo $webName;?></a>
	</td>
	</tr>
</table></td>
<script language="JavaScript" src="image/Deploy.js"></script>
<script language="JavaScript" src="image/DeployInit.js"></script>