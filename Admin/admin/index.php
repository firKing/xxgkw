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
            ��ӭ���� <b><?php echo $webName?></b> ϵͳ�������
        </center>
        <br>
        <!---->
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> ϵ ͳ ˵ ��</td>
            </tr>
            <tr>
                <td class="b"> ��ǰ�汾 V3.2&nbsp;&nbsp;�ú�̨����ϵͳ��<strong><?php echo $webName;?></strong>ʹ�ã�<br>
                �����κ����ʣ�����ϵ <a href="mailto:<?php echo $webEmail;?>"><?php echo $webEmail;?></a>
                </td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> ϵ ͳ �� Ϣ</td>
            </tr>
            <tr>
                <td class="b"> PHP��ʽ�汾��&nbsp; &nbsp; <font color="#000066"><?php echo phpversion();?></font><br>
                MYSQL �汾��&nbsp; &nbsp;&nbsp; <font color="#000066"><?php echo mysql_get_server_info();?></font><br>
                ����������Ϣ�� &nbsp; <font color="#000066"><?php echo $_SERVER['SERVER_SOFTWARE']; //echo apache_get_version()?> </font><br>
                ����ϴ����ƣ� &nbsp; <font color="#000066"><?php echo ini_get("post_max_size");?></font><br>
                ���ִ��ʱ�䣺 &nbsp; <font color="#000066"><?php echo ini_get("max_execution_time");?> seconds</font><br>
                ����������ʱ�䣺&nbsp;<font color="#000066"><?php echo date("Y-m-d H:i");?></font> </td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class="head"> �� �� �� ��</td>
            </tr>
            <tr>
                <td class="b">ϵͳ������&nbsp; &nbsp; �����ʵ��ѧ������У</td>
            </tr>
        </table>
        <br>
        <table width="98%" align="center" cellspacing="1" cellpadding="3" class="i_table">
            <tr>
                <td class=head> �� �� �� Ϣ</td>
            </tr>
            <tr>
                <td class="b">���ϴε�¼ʱ�䣺&nbsp; &nbsp; <?php echo $_SESSION['admin_last_loaded_time']; ?> <br>
                ���ϴε�¼IP��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['admin_last_loaded_ip']; ?> </td>
            </tr>
        </table>
    </body>
</html>
