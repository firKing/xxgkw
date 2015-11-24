<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>信息公开指南</title>
<link href="__CSS__/xxgkzn.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div id="wrap">
		<!-- 以下是头部 -->
		<div id="head">
		
		</div>
		<!-- 以下是导航 -->
		<div class="nav">
		<ul>
			<li class="num1"><a href="__APP__/Index/index">首页</a></li>
			<li class="num2"><a href="__APP__/Guide/index">信息公开指南</a>
                <div id="num2">
                    <ul>
                        <li><a href="__APP__/Guide/index/tid/1">重庆邮电大学信息公开指南</a></li>
                        <li><a href="__APP__/Guide/index/tid/2">重庆邮电大学信息公开申请表</a></li>
                        <li><a href="__APP__/Guide/index/tid/3">重庆邮电大学信息公开工作流程</a></li>
                    </ul>
                </div>
			</li>
			<li class="num3"><a href="__APP__/Menu/index">信息公开目录</a>
                <div id="num3">
                    <ul>
                        <?php if(is_array($np)): foreach($np as $key=>$n): ?><li><a href="__APP__/Menu/index/aid/<?php echo ($n["art_id"]); ?>"><?php echo (msubstr($n["art_title"],0,18,'utf-8',false)); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                </div>
            </li>
			<li class="num4"><a href="__APP__/Newspaper/index">信息公开年报</a></li>
			<li class="num5"><a href="__APP__/Interaction/index">网上互动</a>
                <div id="num5">
                    <ul>
                        <li><a href="http://office.cqupt.edu.cn/mail.php">书记校长信箱</a></li>
                        <li><a href="__APP__/Interaction/index/tid/6">网上公示</a></li>
                        <li><a href="__APP__/Interaction/index/tid/7">最新规章制度</a></li>
                    </ul>
                </div>
             </li>
		</ul>
	</div>
		<!-- 以下为内容部分 -->
        <div id="con">
            <div id="con_l">
                <div id="box">
                    <ul id="list">
                        <?php if(is_array($type_list)): foreach($type_list as $key=>$tl): ?><li class="list"><a href="__APP__/Guide/index/tid/<?php echo ($tl["typeid"]); ?>"><?php echo ($tl["typedetail"]); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
            <div id="con_m">
                <div id="title">
                    您的位置：首页<span>></span>信息公开指南<span>></span><span class="art_title"><?php echo ($type); ?><span>
                </div>
                <div id="article">
                    <ul>
                        <?php if(is_array($guide)): foreach($guide as $key=>$gu): ?><li class="article_l"><a href="__APP__/Guide/detail/type/<?php echo ($gu["art_type"]); ?>/aid/<?php echo ($gu["art_id"]); ?>"><?php echo ($gu["art_title"]); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <div id="page1">
                    <ul>
                        <?php echo ($pageshow); ?>
                    </ul>
                </div>
            </div>
        </div>
		<!--底部版本信息-->
        <div id="foot">
	<p>版权所有　重庆邮电大学　地址：重庆市南岸区崇文路2号　邮编：400065　校长邮箱　webmaster　渝ICP备05001043号</p>
</div>
	</div>
<script src="__JS__/jquery-1.10.2.min.js"></script>
<script src="__JS__/head.js"></script>
<script>
    $(".num2").addClass("hover");
</script>
</body>
</html>