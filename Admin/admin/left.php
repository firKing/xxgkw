<?php
/*
* �ļ���:left.php
* ����:��ʾ����������ߵĲ����б���
* ��������:
* 1.ͨ�����ݿ��ѯ��һ���������������
* 2.���� Admin ��ʵ�����Ķ����ж��Ƿ���Ȩ�ޣ������Ƿ���ʾ����
* 3.��������� action ���ı� main frame ��ʾ�Ĺ�������
* ������־:
* 2012.10.29	�Ƅ�	��������
*/
?>
<link rel="stylesheet" type="text/css" href="css/main.css">
<body topmargin=5 leftmargin=5>
<table width="99%" align=center cellspacing=2 cellpadding=4 border=0>
	<tr>
		<td class=head height=23 align=center>
			<a target='main' href="?action=admin/index"><b>��������ҳ</b></a> | <a target='_top' href="?action=admin/quit"><b>�˳�</b></a>
		</td>
	</tr>
	<tr>
		<td class="b" align=center>
			<a href="#" onClick="return ClearAdminDeploy()">+ ȫ��չ��</a> <a href="#" onClick="return SetAdminDeploy()">- ȫ������</a>
		</td>
	</tr>
	<?php
		$sql = "SELECT `id`, `name` FROM `menu` WHERE `father_id` = 0 ORDER BY `order` ASC";	//ȡ��������һ������
		$query = $db->query($sql);
		
		$i = 1;

		while($rs = $db->fetch_object($query)){	//ѭ��ȡ����	ѭ��һ����ʼ

			if(true != $administrator->checkRights($rs->id)){	//�жϵ�ǰ����Ա��Ȩ���Ƿ�ʵ�����һ������
				continue;	//���������Ȩ�޲���������������ѭ����������һ��ѭ����Ҳ����˵�����һ����������ݶ��޷�����
			}
			$i++;
			
			//Ȩ���㹻�Ļ��ᵽ�����ʼ����һ������� ID ȡ��������
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
							while($rs2 = $db->fetch_object($query2)){	//ѭ��ȥ��������	ѭ��������ʼ
								
								if(true != $administrator->checkRights($rs2->id)){	//�ж�Ȩ���Ƿ�
									continue;	//�����Ļ�����������ѭ����ȡ��һ����������
								}
								//Ȩ�޹��Ļ������������� HTML ��ǩ���γɷ��ఴť
						?>
						<a href="admin.php?action=<?php echo $rs2->url?>" target="main"><?php echo $rs2->name;?></a><br>
						<?php
							}	//ѭ����������
						?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<?php
		}	//ѭ��һ������
	?>
	<tr><td class="head_2" align="center"><a href=<?php echo $webAddress;?> target="_blank"><?php echo $webName;?></a>
	</td>
	</tr>
</table></td>
<script language="JavaScript" src="image/Deploy.js"></script>
<script language="JavaScript" src="image/DeployInit.js"></script>