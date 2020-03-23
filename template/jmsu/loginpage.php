<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>登陆 | <?php echo $OJ_NAME ?></title>
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
            <!-- Main component for a primary marketing message or call to action -->
            <div class="col-sm-6 m-auto bg-light rounded"
                 style="padding:20px 50px 20px 50px;border: 1px solid #dcdcdc;">
                <h3 class="text-center">登录</h3>
                <form id="login" action="login.php" method="post" role="form" class="form-horizontal"
                      onSubmit="return jsMd5();">
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_USER_ID ?></label>
                        <input name="user_id" class="form-control" placeholder="<?php echo $MSG_USER_ID ?>" type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $MSG_PASSWORD ?></label>
                        <input name="password" class="form-control" placeholder="<?php echo $MSG_PASSWORD ?>"
                               type="password">
                    </div>
                    <?php if ($OJ_VCODE) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $MSG_VCODE ?></label>
                            <input name="vcode" class="form-control" type="text">
                            <img id="vcode-img" alt="click to change" onclick="this.src='vcode.php?'+Math.random()"
                                 height="30px">*
                        </div>
                    <?php } ?>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <button name="submit" type="submit" class="btn btn-primary btn-block"
                                    style="margin-bottom: 15px"><?php echo $MSG_LOGIN; ?></button>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-secondary btn-block"
                               href="lostpassword.php"><?php echo $MSG_LOST_PASSWORD; ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="<?php echo $OJ_CDN_URL ?>include/md5-min.js"></script>
        <script>
            function jsMd5() {
                if ($("input[name=password]").val() === "") return false;
                $("input[name=password]").val(hex_md5($("input[name=password]").val()));
                return true;
            }
        </script>
    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php"); ?>

<?php if ($OJ_VCODE) { ?>
    <script>
        $(document).ready(function () {
            $("#vcode-img").attr("src", "vcode.php?" + Math.random());
        })
    </script>
<?php } ?>
</body>
</html>
