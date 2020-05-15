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
        <!-- Main component for a primary marketing message or call to action -->
        <div class="row mb-2 align-items-center">
            <div class="col text-center">
                <h3>Contest<?php echo $view_cid ?> <br> <?php echo $view_title ?></h3>
                <p class='text-muted'><?php echo $view_description ?></p>
            </div>
            <div class="col text-center">
                <div class="alert alert-info">
                    <i class="fas fa-calendar-check"></i> 开始时间:
                    <font class='text-info'><?php echo $view_start_time ?></font><br>
                    <i class="fas fa-calendar-times"></i> 结束时间: <font
                            class='text-info'><?php echo $view_end_time ?></font><br>
                    <?php if (isset($OJ_RANK_LOCK_PERCENT) && $OJ_RANK_LOCK_PERCENT != 0) { ?>
                        <i class="fas fa-clock"></i> 榜单锁定时间: <font
                                color=#993399><?php echo date("Y-m-d H:i:s", $view_lock_time) ?></font>
                        <br/>
                    <?php } ?>
                    <i class="fas fa-clock"></i> 当前服务器时间: <font class='text-info'><span
                                id=nowdate> <?php echo date("Y-m-d H:i:s") ?></span></font>
                    <br/>
                    <i class="fas fa-info-circle"></i> 状态：<?php
                    if ($now > $end_time) {
                        echo " <span class='text-danger'>已结束</span>";
                    } else if ($now < $start_time) {
                        echo " <span class='text-primary'>即将开始</span>";
                    } else {
                        echo " <span class='text-success'>进行中</span>";
                    }

                    ?>&nbsp;&nbsp;
                    <i class="fas fa-bell"></i> 类别：
                    <?php
                    if ($view_private == '0') {
                        echo " <span class='text-primary'>公开</font>";
                    } else {
                        echo " <span class='text-danger'>非公开</font>";
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="row mb-2 text-center">
            <div class="col">
                <a class='btn btn-outline-info btn-sm' href='status.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-hourglass-half'></i> 提交记录</a>
                <a class='btn btn-outline-success btn-sm' href='contestrank.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-thumbs-up'></i> 排名</a>
                <a class='btn btn-outline-secondary btn-sm' href='conteststatistics.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-file-alt'></i> 统计</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table id='problemset' class='table table-hover table-bordered'>

                    <thead class="thead-light text-center">
                    <tr>
                        <th></th>
                        <th style="cursor:pointer"
                            onclick="sortTable('problemset', 1, 'int');"><?php echo $MSG_PROBLEM_ID ?></th>
                        <th><?php echo $MSG_TITLE ?></th>
                        <!--                        <th>--><?php //echo $MSG_SOURCE ?><!--</th>-->
                        <th style="cursor:pointer"
                            onclick="sortTable('problemset', 4, 'int');"><?php echo $MSG_AC ?></th>
                        <th style="cursor:pointer"
                            onclick="sortTable('problemset', 5, 'int');"><?php echo $MSG_SUBMIT ?></th>
                    </tr>
                    </thead>
                    <tbody align='center'>
                    <?php
                    $cnt = 0;
                    foreach ($view_problemset as $row) {
                        if ($cnt) {
                            echo "<tr class='oddrow'>";
                        } else {
                            echo "<tr class='evenrow'>";
                        }

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
    </div>
    </div>
</main>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
<script src="include/sortTable.js"></script>
<script>
    var diff = new Date("<?php echo date("Y/m/d H:i:s") ?>").getTime() - new Date().getTime();

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
