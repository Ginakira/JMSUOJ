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
        <?php echo $OJ_NAME ?>
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
    <!-- Main component for a primary marketing message or call to action -->
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <div id="main" style="height:400px;"></div>
            </div>
        </div>
        <!--公告以列表形式 + bs4模态框展现-->
        <div class="row">
            <div class="col">
                <div class="card" style="width:80%;margin:0 auto; border: 1px solid #0f4c81;">
                    <div class="card-header text-white" style="background-color: #0f4c81">
                        <i class="fas fa-bullhorn"></i> 公告
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <colgroup>
                                <col style="width:55%">
                                <col style="width:35%">
                                <col style="width:10%">
                            </colgroup>
                            <tbody>
                            <?php echo $news_list; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--输出模态框内容news_modals-->
    <?php echo $news_modals ?>
</main>
<!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/echarts@4.7.0/dist/echarts.min.js"></script>
<script type="text/javascript">
    let data_all = <?php echo json_encode($chart_data_all) ?>;
    data_all = data_all.slice(-30); // 只取最后30天记录 SQL查询未优化
    let myChart = echarts.init(document.getElementById('main'));
    // 绘制图表
    let option = {
            legend: {
                left: 'right',
            },
            tooltip: {
                trigger: 'axis',
            },

            dataset: {
                source: data_all,
            },
            title: {
                left: 'center',
                text: '最近提交',
            },
            xAxis: {
                type: 'category',
            },
            yAxis: {},
            series: [
                {
                    name: '提交数',
                    type: 'line',
                    smooth: 'true',
                    sampling: 'average',
                    itemStyle: {
                        color: '#fad157',
                    },
                    areaStyle: {
                        color: '#fad284',
                    },
                },
                {
                    name: 'AC数',
                    type: 'line',
                    smooth: 'true',
                    sampling: 'average',
                    itemStyle: {
                        color: '#8beeb9',
                    },
                    areaStyle: {
                        color: '#a9eec2',
                    },
                },
            ]
        }
    ;
    myChart.setOption(option);
</script>
</body>
</html>