<!DOCTYPE html>
<html lang="zh-cn" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>
        问题统计 | <?php echo $OJ_NAME ?>
    </title>
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
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Problem <?php echo $id ?> 统计数据</h2>
                <div style="text-align: center;">
                    <table class="table-sm table-bordered">
                        <tr>
                            <td>
                                <table id='statics'>
                                    <?php
                                    $cnt = 0;
                                    foreach ($view_problem as $row) {
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
                                    <tr id="pie" bgcolor=white>
                                        <td colspan=2>
                                            <div id="chartDiv"
                                                 style="position:relative;width: 200px;height:150px;"></div>
                                    </tr>
                                </table>
                                <br>
                                <?php if (isset($view_recommand)) { ?>
                                    <table id=recommand>
                                        <tr>
                                            <td>
                                                推荐的相关题目<br>
                                                <?php
                                                $cnt = 1;
                                                foreach ($view_recommand as $row) {
                                                    echo "<a href=problem.php?id=$row[0]>$row[0]</a>&nbsp;";
                                                    if ($cnt % 3 == 0) {
                                                        echo "<br>";
                                                    }

                                                    $cnt++;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </td>
                            <td>
                                <table id=problemstatus class="table" style="margin-bottom:10px">
                                    <thead class="thead-light">
                                    <tr class=toprow>
                                        <th style="cursor:pointer"
                                            onclick="sortTable('problemstatus', 0, 'int');"><?php echo $MSG_Number ?></th>
                                        <th>RunID</th>
                                        <th><?php echo $MSG_USER ?></th>
                                        <th><?php echo $MSG_MEMORY ?></th>
                                        <th><?php echo $MSG_TIME ?></th>
                                        <th><?php echo $MSG_LANG ?></th>
                                        <th><?php echo $MSG_CODE_LENGTH ?></th>
                                        <th><?php echo $MSG_SUBMIT_TIME ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($view_solution as $row) {
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
                                </table>
                                <?php
                                echo "<a class='btn btn-light' href='problemstatus.php?id=$id'>TOP</a>";
                                echo "&nbsp;&nbsp;<a class='btn btn-light' href='status.php?problem_id=$id'>提交记录</a>";
                                if ($page > $pagemin) {
                                    $page--;
                                    echo "&nbsp;&nbsp;<a href='problemstatus.php?id=$id&page=$page'>[PREV]</a>";
                                    $page++;
                                }
                                if ($page < $pagemax) {
                                    $page++;
                                    echo "&nbsp;&nbsp;<a href='problemstatus.php?id=$id&page=$page'>[NEXT]</a>";
                                    $page--;
                                }
                                ?>
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
<script type="text/javascript" src="include/jquery.tablesorter.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#problemstatus").tablesorter();
    });
</script>
</body>

<script src="https://cdn.jsdelivr.net/npm/echarts@4.7.0/dist/echarts.min.js"></script>
<script language="javascript">
    let dt = document.getElementById("statics");
    let data = [];
    let labels = [];
    for (var i = 3; dt.rows[i].id !== "pie"; i++) {
        labels.push(dt.rows[i].cells[0].innerText);
        data.push({
            'name': dt.rows[i].cells[0].innerText,
            'value': dt.rows[i].cells[1].innerText,
        });
    }

    let myChart = echarts.init(document.getElementById('chartDiv'));
    let options = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 0,
            data: labels,
        },
        series: [
            {
                name: '提交统计',
                type: 'pie',
                radius: ['50%', '70%'],
                center: ['70%', '50%'],
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '15',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: data,
            }
        ]
    };
    myChart.setOption(options);
</script>

</html>