<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>注册 | <?php echo $OJ_NAME ?></title>
    <?php include("template/$OJ_TEMPLATE/css.php"); ?>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="d-flex flex-column h-100">

<?php include "template/$OJ_TEMPLATE/nav.php"; ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 m-auto bg-light rounded"
                 style="padding:20px 50px 20px 50px;border: 1px solid #dcdcdc;">

                <form action="register.php" method="post" role="form" class="form-horizontal">

                    <div class="form-group">
                        <h4 class="control-label text-center"><?php echo $MSG_REG_INFO ?></h4>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_USER_ID ?></label>
                        <input name="user_id" class="form-control" placeholder="必填 建议使用学号（3～20个数字/字母）" type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_NICK ?></label>
                        <input name="nick" class="form-control" placeholder="留空默认与ID相同 （1～100个字符）" type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_PASSWORD ?></label>
                        <input name="password" class="form-control" placeholder="必填 至少六位" type="password">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_REPEAT_PASSWORD ?></label>
                        <input name="rptpassword" class="form-control" placeholder="必填" type="password">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_SCHOOL ?></label>
                        <input name="school" class="form-control" placeholder="非必填" type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_EMAIL ?></label>
                        <input name="email" class="form-control" placeholder="必填" type="text">
                    </div>

                    <?php if ($OJ_VCODE) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $MSG_VCODE ?></label>
                            <input name="vcode" class="form-control" placeholder="<?php echo $MSG_VCODE ?>*"
                                   type="text">
                            <img alt="click to change" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"
                                 height="30px">*
                        </div>
                    <?php } ?>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <button name="submit" type="submit" class="btn btn-primary btn-block"
                                    style="margin-bottom: 15px"><?php echo $MSG_REGISTER; ?></button>
                        </div>
                        <div class="col-sm-6">
                            <button name="submit" type="reset"
                                    class="btn btn-secondary btn-block"><?php echo $MSG_RESET; ?></button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php"); ?>
<script>
    $("input").attr("class", "form-control");
</script>
</body>
</html>
