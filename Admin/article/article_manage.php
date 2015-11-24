<?php
/*
* 文件名:article_manage.php
* 功能:文章管理模块
* 工作流程:
* 1.通过 php 对数据库文章表的存取
* 更新日志:
* 2012.11.02    黄劼  在小康和小安的友情提示下，恢复了对 admin/check.php 的包含
* 2012.11.01  黄劼  代码整理
*/
    require_once(ROOT_PATH."admin/check.php");
	require_once(ROOT_PATH."inc/table_config.php");

	$dep = checkDep();

	$sqlSelArt = "SELECT count(*) AS nums FROM `".$arttable."`";
	$resSelArt = $db->query($sqlSelArt);
	$objSelArt = $db->fetch_object($resSelArt);
	$nums = $objSelArt->nums;
	$max = 20;

	@$_GET['page'] = ($_GET['page'] < 1)? (($_POST['page'] < 1)? 1: ($_POST['page'] > floor(($nums - 1) / $max) + 1? floor(($nums - 1) / $max) + 1: $_POST['page'])): ($_GET['page'] > floor(($nums - 1) / $max) + 1? floor(($nums - 1) / $max) + 1: $_GET['page']);

	$sqlSelArt = "SELECT * FROM `".$arttable."` ORDER BY `art_add_time` DESC, `art_id` LIMIT ".(($_GET['page'] - 1) * $max).", ".$max."";

	$resSelArt = $db->query($sqlSelArt);
?>

<link rel="stylesheet" type="text/css" href="css/main.css">
<table width='95%' align=center cellspacing=1 cellpadding=3 class="i_table">
    <tr>
        <td colspan="8" align="center" class=head ><b>::新闻编辑::</b></td>
    </tr>
    <tr align="center" class="head_2">
        <td >标题</td>
        <td width="10%">类别</td>
        <td width="10%">添加者</td>
        <td width="10%">文章作者</td>
        <td width="10%">IP</td>
        <td width="15%">时间</td>
        <td width="5%">编辑</td>
        <td width="5%">删除</td>
    </tr>
    <?
        while($objSelArt=$db->fetch_object($resSelArt)){
    ?>
    <tr align="center" class="b">
        <td>
            <a href="../art.php?id=<?php echo $objSelArt->art_id;?>" target="_blank" title="点击预览"><?=cut($objSelArt->art_title,0,30);?></a>&nbsp;&nbsp;&nbsp;
        </td>
        <td>
            <?php
            $sqlSelType = "SELECT * FROM `".$typetable."` WHERE `typeid` = '".$objSelArt->art_type."'";
            $resSelType = $db->query($sqlSelType);
            $objSelType = $db->fetch_object($resSelType);
            echo $objSelType->typedetail;
            ?>
        </td>
        <td><?=$administrator->getAdminName($objSelArt->art_add_user);?></td>
        <td><?=$objSelArt->art_author;?></td>
        <td><?=$objSelArt->art_add_ip;?></td>
        <td><?php echo $objSelArt->art_add_time == 0? "由系统创建时添加": date("Y-m-d H:i:s", $objSelArt->art_add_time); ?></td>
        <td><a href="admin.php?action=<?=$folder?>/article_add&do=<?=$objSelArt->art_id;?>">编辑</a></td>
        <td><a href="admin.php?action=<?=$folder?>/article_do&del=<?=$objSelArt->art_id;?>">删除</a></td>
    </tr>
    <?
    }
    ?>
    <tr class="b">
    <td colspan="8" align="center"><?=page( $_GET['page'] ,$nums , "admin.php?action=".$_GET['action'] ,20);?></td>
    </tr>
</table>
<?php
	require_once(ROOT_PATH."foot.php");
?>