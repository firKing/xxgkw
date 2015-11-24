<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <!---->
    </head>

    <body topmargin="5" leftmargin="5">
        <br>
        <!---->
        <center>
            欢迎光临 <b><?php echo $webName?></b> 系统设置面板
        </center>
        <br>
        <!---->
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> 系 统 说 明</td>
            </tr>
            <tr>
                <td class="b"> 当前版本 V3.2&nbsp;&nbsp;该后台管理系统供<strong><?php echo $webName;?></strong>使用！<br>
                若有任何疑问，请联系 <a href="mailto:<?php echo $webEmail;?>"><?php echo $webEmail;?></a>
                </td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> 系 统 信 息</td>
            </tr>
            <tr>
                <td class="b"> PHP程式版本：&nbsp; &nbsp; <font color="#000066"><?php echo phpversion();?></font><br>
                MYSQL 版本：&nbsp; &nbsp;&nbsp; <font color="#000066"><?php echo mysql_get_server_info();?></font><br>
                服务器端信息： &nbsp; <font color="#000066"><?php echo $_SERVER['SERVER_SOFTWARE']; //echo apache_get_version()?> </font><br>
                最大上传限制： &nbsp; <font color="#000066"><?php echo ini_get("post_max_size");?></font><br>
                最大执行时间： &nbsp; <font color="#000066"><?php echo ini_get("max_execution_time");?> seconds</font><br>
                服务器所在时间：&nbsp;<font color="#000066"><?php echo date("Y-m-d H:i");?></font> </td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> 开 发 团 队</td>
            </tr>
            <tr>
                <td class="b">系统开发：&nbsp; &nbsp; 重庆邮电大学红岩网校</td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class=head> 个 人 信 息</td>
            </tr>
            <tr>
                <td class="b">您上次登录时间：&nbsp; &nbsp; <?php echo $_SESSION['admin_last_loaded_time']; ?> <br>
                您上次登录IP：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['admin_last_loaded_ip']; ?> </td>
            </tr>
        </table>
    </body>
</html>
