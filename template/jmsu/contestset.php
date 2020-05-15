<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>比赛&作业 | <?php echo $OJ_NAME ?></title>
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
        <!-- Main component for a primary marketing message or call to action -->
        <div class="row">
            <div class="col">
                <form method=post action=contest.php>
                    <?php echo $MSG_SEARCH; ?>:
                    <input class="input-medium" name=keyword type=text>
                    <input type=submit>
                </form>
            </div>
            <div class="col">
                <nav aria-label="Page navigation" class="d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="contest.php?page=1">&lsaquo;</a></li>
                        <?php
                        if (!isset($page)) $page = 1;
                        $page = intval($page);
                        $section = 8;
                        $start = $page > $section ? $page - $section : 1;
                        $end = $page + $section > $view_total_page ? $view_total_page : $page + $section;
                        for ($i = $start; $i <= $end; $i++) {
                            echo "<li class='" . ($page == $i ? "active " : "") . "page-item'>
            <a class='page-link' title='go to page' href='contest.php?page=" . $i . (isset($_GET['my']) ? "&my" : "") . "'>" . $i . "</a></li>";
                        }
                        ?>
                        <li class="page-item"><a class="page-link"
                                                 href="contest.php?page=<?php echo $view_total_page ?>">&rsaquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class='table table-striped' width=90%>
                    <thead>
                    <tr class=toprow align=center>
                        <td width=10%>ID
                        <td width=30%>名称
                        <td width=40%>状态
                        <td width=10%>类型
                        <td width=10%>发起者
                    </tr>
                    </thead>
                    <tbody align='center'>
                    <?php
                    $cnt = 0;
                    foreach ($view_contest as $row) {
                        if ($cnt)
                            echo "<tr class='oddrow'>";
                        else
                            echo "<tr class='evenrow'>";
                        foreach ($row as $table_cell) {
                            echo "<td>";
                            echo "\t" . $table_cell;
                            echo "</td>";
                        }
                        echo "</tr>";
                        $cnt = 1 - $cnt;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-2 text-center">
            <div class="col text-muted">当前服务器时间:<span id=nowdate></span></div>
        </div>

    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php"); ?>
<script>
    var diff = new Date("<?php echo date("Y/m/d H:i:s")?>").getTime() - new Date().getTime();

    //alert(diff);
    function clock() {
        var x, h, m, s, n, xingqi, y, mon, d;
        var x = new Date(new Date().getTime() + diff);
        y = x.getYear() + 1900;
        if (y > 3000) y -= 1900;
        mon = x.getMonth() + 1;
        d = x.getDate();
        xingqi = x.getDay();
        h = x.getHours();
        m = x.getMinutes();
        s = x.getSeconds();
        n = y + "-" + mon + "-" + d + " " + (h >= 10 ? h : "0" + h) + ":" + (m >= 10 ? m : "0" + m) + ":" + (s >= 10 ? s : "0" + s);
//alert(n);
        document.getElementById('nowdate').innerHTML = n;
        setTimeout("clock()", 1000);
    }

    clock();
</script>
</body>
</html>
