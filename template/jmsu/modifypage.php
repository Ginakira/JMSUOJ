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
    <?php include "template/$OJ_TEMPLATE/css.php"; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="d-flex flex-column h-100">
<?php include "template/$OJ_TEMPLATE/nav.php"; ?>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">

        <form action="modify.php" method="post" role="form" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-4 control-label h4"><?php echo $MSG_REG_INFO ?></label>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $MSG_USER_ID ?></label>
                <div class="col-sm-4"><label
                            class="col-sm-2 control-label"><?php echo $_SESSION[$OJ_NAME . '_' . 'user_id'] ?></label>
                </div>
                <?php require_once './include/set_post_key.php'; ?>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $MSG_NICK ?></label>
                <div class="col-sm-4"><input name="nick" class="form-control"
                                             value="<?php echo htmlentities($row['nick'], ENT_QUOTES, "UTF-8") ?>"
                                             type="text"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $MSG_PASSWORD ?>(必填)</label>
                <div class="col-sm-4"><input name="opassword" class="form-control"
                                             placeholder="<?php echo $MSG_PASSWORD ?>*" type="password"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo "新" . $MSG_PASSWORD ?>(不修改请留空)</label>
                <div class="col-sm-4"><input name="npassword" class="form-control" type="password"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo "新" . $MSG_REPEAT_PASSWORD ?></label>
                <div class="col-sm-4"><input name="rptpassword" class="form-control" type="password"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $MSG_SCHOOL ?></label>
                <div class="col-sm-4"><input name="school" class="form-control"
                                             value="<?php echo htmlentities($row['school'], ENT_QUOTES, "UTF-8") ?>"
                                             type="text"></div>
                <?php if (isset($_SESSION[$OJ_NAME . "_printer"])) {
                    echo "$MSG_HELP_BALLOON_SCHOOL";
                }
                ?>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $MSG_EMAIL ?></label>
                <div class="col-sm-4"><input name="email" class="form-control"
                                             value="<?php echo htmlentities($row['email'], ENT_QUOTES, "UTF-8") ?>"
                                             type="text"></div>
            </div>

            <div class="form-group row m-auto">
                <div class="col-sm-2">
                    <button name="submit" type="submit"
                            class="btn btn-primary btn-block"><?php echo $MSG_SUBMIT; ?></button>
                </div>
                <div class="col-sm-2">
                    <button name="submit" type="reset"
                            class="btn btn-secondary btn-block"><?php echo $MSG_RESET; ?></button>
                </div>
            </div>
        </form>
        <br>
        <a href=export_ac_code.php>下载所有已AC题目源代码</a><br>
    </div>
</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
</body>
</html>
