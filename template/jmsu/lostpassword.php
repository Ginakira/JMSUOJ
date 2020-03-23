<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $OJ_NAME ?></title>
    <?php include("template/$OJ_TEMPLATE/css.php"); ?>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="d-flex flex-column h-100">

<?php include("template/$OJ_TEMPLATE/nav.php"); ?>
<main role="main">
    <div class="container">
        <!-- Main component for a primary marketing message or call to action -->
        <div class="col-sm-8 m-auto">
            <fieldset disabled style="display: none"> <!--TODO BUILDING 200309-->
                <form action=lostpassword.php method=post>
                    <center>
                        <table width=400 algin=center>
                            <tr>
                                <td width=200><?php echo $MSG_USER_ID ?>:
                                <td width=200><input name="user_id" type="text" size=20>
                            </tr>
                            <tr>
                                <td><?php echo $MSG_EMAIL ?>:
                                <td><input name="email" type="text" size=20>
                            </tr>
                            <tr>
                                <td><?php echo $MSG_VCODE ?>:</td>
                                <td><input name="vcode" size=4 type=text><img alt="click to change" src=vcode.php
                                                                              onclick="this.src='vcode.php?'+Math.random()">*
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <td><input name="submit" type="submit" size=10 value="Submit">
                            </tr>
                        </table>
                        <center>
                </form>
            </fieldset>
            <div class="row">
                <div class="col">
                    <div class="alert alert-warning text-center">
                        <h4 class="alert-heading">找回密码功能暂时关闭</h4>
                        <hr>
                        <strong>注意：</strong>由于找回密码功能存在缺陷，目前正加急开发中。
                        <br>如忘记密码，请发送邮件联系管理员进行修改：<strong>ginakira@outlook.com</strong>
                        <br>或<a href="http://bbs.jmsu.xyz/" class="alert-link">点击前往论坛</a>，在反馈板块发帖说明。
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php"); ?>
</body>
</html>
