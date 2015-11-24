<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>校办信息公开网首页</title>
<link href="__CSS__/head.css" type="text/css" rel="stylesheet">
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
				<img src="__IMG__/xxgk.gif">
				<ul id="list">
					<li class="list"><a href="__APP__/Guide/index/tid/8">基本情况</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/21">招生考试</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/10">教学质量</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/11">学位、学科信息</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/12">学生管理服务</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/22">学风建设</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/13">人事师资</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/14">财务、资产及收费</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/16">校园安全</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/17">对外交流与合作</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/15">其他</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/18">信息公开</a></li>
					<li class="list"><a href="__APP__/Guide/index/tid/19">申述处理</a></li>
				</ul>
			</div>
			<div id="con_m">
				<div id="con1">
					<div class="title">
						<img src="__IMG__/icon1.gif">
						<span class="h">最新规章制度</span>
						<span class="more"><a href="__APP__/Interaction/index/tid/7">更多》</a></span>
					</div>
					<ul class="article">
					<?php if(is_array($new)): foreach($new as $key=>$new): ?><li>
							<span>
								<a href="__APP__/Interaction/detail/type/<?php echo ($new["art_type"]); ?>/aid/<?php echo ($new["art_id"]); ?>"><?php echo ($new["art_title"]); ?></a>
							</span>
							<span class="date">[<?php echo (date("Y-m-d",$new["art_add_time"])); ?>]</span>
						</li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div id="con2">
					<div class="title">
						<img src="__IMG__/icon2.gif">
						<span class="h">通知公告</span>
						<span class="more"><a href="__APP__/Guide/index/tid/20">更多》</a></span>
					</div>
					<ul class="article">
						<?php if(is_array($inform)): foreach($inform as $key=>$inform): ?><li>
							<span>
								<a href="__APP__/Guide/detail/type/<?php echo ($inform["art_type"]); ?>/aid/<?php echo ($inform["art_id"]); ?>"><?php echo ($inform["art_title"]); ?></a>
							</span>
						</li><?php endforeach; endif; ?>
					</ul>
				</div>
			</div>
			<div id="con_r">
				<a href="http://office.cqupt.edu.cn/mail.php"><img src="__IMG__/xinxiang.gif"></a>
				<a href="__APP__/Guide/index/tid/2"><img src="__IMG__/shenqing.gif"></a>
				<a href="__APP__/Interaction/index/tid/6"><img src="__IMG__/gongshi.gif"></a>
				<div>
					<h1 class="h">信息公开受理</h1>
					<ul>
						<li>部门：重庆邮电大学信息公开工作办公室（重庆邮电大学校办）</li>
						<li>受理时间：9：00-11:30，14:30-17:30（法定节假除外）</li>
						<li>办公地址：重庆邮电大学香樟园2号</li>
						<li>邮政编码：400065</li>
						<li>联系电话：023-62460006</li>
						<li>传真号码：023-62461882</li>
						<li>电子邮箱地址：tangc@cqupt.edu.cn</li>
						<li>书记校长信箱：http://office.cqupt.edu.cn/mail.php</li>
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
    $(".num1").addClass("hover");
</script>
</body>
</html>