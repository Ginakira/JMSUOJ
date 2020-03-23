<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>用户 | <?php echo $OJ_NAME ?></title>
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
        <div class="row">
            <div class="col">
                <table class="table table-striped table-responsive" id=statics width=70%>
                    <caption>
                        <?php echo $user . "--" . htmlentities($nick, ENT_QUOTES, "UTF-8") ?>
                        <?php
                        echo "<a href=mail.php?to_user=$user>$MSG_MAIL</a>";
                        ?>
                    </caption>
                    <tr>
                        <td width=15%><?php echo $MSG_Number ?>
                        <td width=25% align=center><?php echo $Rank ?>
                        <td width=70% align=center>已通过的问题
                    </tr>
                    <tr>
                        <td><?php echo $MSG_SOVLED ?>
                        <td align=center><a
                                    href='status.php?user_id=<?php echo $user ?>&jresult=4'><?php echo $AC ?></a>
                        <td rowspan=14 class="text-center">
                            <script language='javascript'>
                                function p(id, c) {
                                    document.write("<a class='badge badge-light' href=problem.php?id=" + id + ">" + id + " </a>");

                                }
                                <?php $sql = "SELECT `problem_id`,count(1) from solution where `user_id`=? and result=4 group by `problem_id` ORDER BY `problem_id` ASC";
                                if ($result = pdo_query($sql, $user)) {
                                    foreach ($result as $row) {
                                        echo "p($row[0],$row[1]);";
                                    }

                                }

                                ?>
                            </script>
                            <div id=submission style="width:600px;height:300px;margin-top:20px"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $MSG_SUBMIT ?>
                        <td align=center><a href='status.php?user_id=<?php echo $user ?>'><?php echo $Submit ?></a>
                    </tr>
                    <?php
                    foreach ($view_userstat as $row) {
//i++;
                        echo "<tr ><td>" . $jresult[$row[0]] . "<td align=center><a href=status.php?user_id=$user&jresult=" . $row[0] . " >" . $row[1] . "</a></tr>";
                    }
                    //}
                    echo "<tr id=pie ><td>统计<td><div id='PieDiv' style='position:relative;height:105px;width:120px;'></div></tr>";
                    ?>
                    <script type="text/javascript" src="include/wz_jsgraphics.js"></script>
                    <script type="text/javascript" src="include/pie.js"></script>
                    <script language="javascript">
                        var y = new Array();
                        var x = new Array();
                        var dt = document.getElementById("statics");
                        var data = dt.rows;
                        var n;
                        for (var i = 3; dt.rows[i].id != "pie"; i++) {
                            n = dt.rows[i].cells[0];
                            n = n.innerText || n.textContent;
                            x.push(n);
                            n = dt.rows[i].cells[1].firstChild;
                            n = n.innerText || n.textContent;
//alert(n);
                            n = parseInt(n);
                            y.push(n);
                        }
                        var mypie = new Pie("PieDiv");
                        mypie.drawPie(y, x);
                        //mypie.clearPie();
                    </script>
                    <tr>
                        <td>学校:
                        <td align=center><?php echo $school ?></tr>
                    <tr>
                        <td>邮箱:
                        <td align=center><?php echo $email ?></tr>
                </table>
            </div>
            <?php
            if (isset($_SESSION[$OJ_NAME . '_' . 'administrator'])) {
                ?>
                <div class="col">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                        <tr class=toprow>
                            <th>用户ID</th>
                            <th>登录状态</th>
                            <th>IP地址</th>
                            <th>登录时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cnt = 0;
                        foreach ($view_userinfo as $row) {
                            if ($cnt) {
                                echo "<tr class='oddrow'>";
                            } else {
                                echo "<tr class='evenrow'>";
                            }

                            for ($i = 0; $i < count($row) / 2; $i++) {
                                echo "<td>";
                                echo "\t" . $row[$i];
                                echo "</td>";
                            }
                            echo "</tr>";
                            $cnt = 1 - $cnt;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>
        </div>

    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>

<script language="javascript" type="text/javascript" src="include/jquery.flot.js"></script>
<script type="text/javascript">
    $(function () {
        var d1 = [];
        var d2 = [];
        <?php
        foreach ($chart_data_all as $k => $d) {
        ?>
        d1.push([<?php echo $k ?>, <?php echo $d ?>]);
        <?php }?>
        <?php
        foreach ($chart_data_ac as $k => $d) {
        ?>
        d2.push([<?php echo $k ?>, <?php echo $d ?>]);
        <?php }?>
//var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];
// a null signifies separate line segments
        var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];
        $.plot($("#submission"), [
            {label: "<?php echo $MSG_SUBMIT ?>", data: d1, lines: {show: true}},
            {label: "<?php echo $MSG_AC ?>", data: d2, bars: {show: true}}], {
            xaxis: {
                mode: "time"
//, max:(new Date()).getTime()
//,min:(new Date()).getTime()-100*24*3600*1000
            },
            grid: {
                backgroundColor: {colors: ["#f5f5f5", "#f5f5f5"]}
            }
        });
    });
    //alert((new Date()).getTime());
</script>
</body>
</html>
