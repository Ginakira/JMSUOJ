<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>查看代码 | <?php echo $OJ_NAME ?></title>
    <?php include "template/$OJ_TEMPLATE/css.php"; ?>


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
            <div class="col">
                <div class="card">
                    <div class="card-header">333</div>
                    <div class="card-body">23</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <link href='highlight/styles/shCore.css' rel='stylesheet' type='text/css'/>
                <link href='highlight/styles/shThemeDefault.css' rel='stylesheet' type='text/css'/>
                <script src='highlight/scripts/shCore.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushCpp.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushCss.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushJava.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushDelphi.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushRuby.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushBash.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushPython.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushPhp.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushPerl.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushCSharp.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushVb.js' type='text/javascript'></script>
                <script src='highlight/scripts/shBrushSql.js' type='text/javascript'></script>
                <script language='javascript'>
                    SyntaxHighlighter.config.bloggerMode = false;
                    SyntaxHighlighter.config.clipboardSwf = 'highlight/scripts/clipboard.swf';
                    SyntaxHighlighter.all();
                </script>
                <?php
                //if ($ok == true) {
                if ($view_user_id != $_SESSION[$OJ_NAME . '_' . 'user_id']) {
                    echo "<a href='mail.php?to_user=" . htmlentities($view_user_id, ENT_QUOTES, "UTF-8") . "&title=$MSG_SUBMIT $id'>Mail the author</a>";
                }

                $brush = strtolower($language_name[$slanguage]);
                if ($brush == 'pascal') {
                    $brush = 'delphi';
                }

                if ($brush == 'obj-c') {
                    $brush = 'c';
                }

                if ($brush == 'freebasic') {
                    $brush = 'vb';
                }

                if ($brush == 'fortran') {
                    $brush = 'vb';
                }

                if ($brush == 'swift') {
                    $brush = 'csharp';
                }

                echo "<pre class=\"brush:" . $brush . ";\">";
                ob_start();
                echo "/**************************************************************\n";
                echo "\tProblem: $sproblem_id\n\tUser: $suser_id\n";
                echo "\tLanguage: " . $language_name[$slanguage] . "\n\tResult: " . $judge_result[$sresult] . "\n";
                if ($sresult == 4) {
                    echo "\tTime:" . $stime . " ms\n";
                    echo "\tMemory:" . $smemory . " kb\n";
                }
                echo "****************************************************************/\n\n";
                $auth = ob_get_contents();
                ob_end_clean();
                echo htmlentities(str_replace("\n\r", "\n", $view_source), ENT_QUOTES, "utf-8") . "\n" . $auth . "</pre>";
                //}
                ?>
            </div>
        </div>
    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
</body>
</html>
