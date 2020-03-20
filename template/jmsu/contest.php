<!DOCTYPE html>
<html lang="zh-CN">
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

<body>

<div class="container">
    <?php include "template/$OJ_TEMPLATE/nav.php"; ?>
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <center>
            <div>
                <h3>Contest<?php echo $view_cid ?> - <?php echo $view_title ?></h3>
                <p class='text-muted'><?php echo $view_description ?></p>
                开始时间: <font class='text-info'><?php echo $view_start_time ?></font>&nbsp;
                结束时间: <font class='text-info'><?php echo $view_end_time ?></font><br>
                <?php if (isset($OJ_RANK_LOCK_PERCENT) && $OJ_RANK_LOCK_PERCENT != 0) { ?>
                    Lock Board Time: <font color=#993399><?php echo date("Y-m-d H:i:s", $view_lock_time) ?></font><br/>
                <?php } ?>
                当前服务器时间: <font class='text-info'><span id=nowdate> <?php echo date("Y-m-d H:i:s") ?></span></font>
                <br/>
                状态：<?php
                if ($now > $end_time) {
                    echo " <span class='text-danger'>已结束</span>";
                } else if ($now < $start_time) {
                    echo " <span class='text-primary'>即将开始</span>";
                } else {
                    echo " <span class='text-success'>进行中</span>";
                }

                ?>&nbsp;&nbsp;
                类别：
                <?php
                if ($view_private == '0') {
                    echo " <span class='text-primary'>公开</font>";
                } else {
                    echo " <span class='text-danger'>非公开</font>";
                }

                ?>
                <br><br>
                <a class='btn btn-info btn-sm' href='status.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-hourglass-half'></i> 提交记录</a>
                <a class='btn btn-success btn-sm' href='contestrank.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-thumbs-up'></i> 排名</a>
                <a class='btn btn-secondary btn-sm' href='conteststatistics.php?cid=<?php echo $view_cid ?>'><i
                            class='fas fa-file-alt'></i> 统计</a>
            </div>
            <table id='problemset' class='table table-striped' width='90%'>
                <thead>
                <tr align=center class='toprow'>
                    <td width='5'>
                    <td style="cursor:hand" onclick="sortTable('problemset', 1, 'int');"><?php echo $MSG_PROBLEM_ID ?>
                    <td width='60%'><?php echo $MSG_TITLE ?></td>
                    <td width='10%'><?php echo $MSG_SOURCE ?></td>
                    <td style="cursor:hand" onclick="sortTable('problemset', 4, 'int');"
                        width='5%'><?php echo $MSG_AC ?></td>
                    <td style="cursor:hand" onclick="sortTable('problemset', 5, 'int');"
                        width='5%'><?php echo $MSG_SUBMIT ?></td>
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
        </center>
    </div>

</div> <!-- /container -->


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
