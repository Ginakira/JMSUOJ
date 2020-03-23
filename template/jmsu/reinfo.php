<!DOCTYPE html>
<html lang="zh-cn" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>评测信息 | <?php echo $OJ_NAME ?></title>
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
    <div class="container mb-4">
        <!-- Main component for a primary marketing message or call to action -->
        <div class="row">
            <div class="col">
                <div class="alert alert-info alert-dismissible text-center fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>提示</strong>：当答案错误时，左侧数据为期待的<strong>正确输出</strong>，右侧数据为您的代码运行的<strong>实际输出</strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-sm text-center">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">提交ID</th>
                        <th scope="col">题目编号</th>
                        <th scope="col">提交者</th>
                        <th scope="col">得分</th>
                        <th scope="col">耗时</th>
                        <th scope="col">内存</th>
                        <th scope="col">代码长度</th>
                        <th scope="col">评测时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">#<?php echo $solution_info['sid']; ?></th>
                        <td>
                            <a href="problem.php?id=<?php echo $solution_info['pid']; ?>"><?php echo $solution_info['pid']; ?></a>
                        </td>
                        <td>
                            <a href="
                       userinfo.php?user=<?php echo $solution_info['uid']; ?>"> <?php echo $solution_info['uid']; ?></a>
                        </td>
                        <td class=" text-<?php echo $solution_info['score'] == 100 ? "success" : "danger"; ?>">
                            <strong><?php echo $solution_info['score']; ?></strong></td>
                        <td><?php echo $solution_info['time']; ?>ms</td>
                        <td><?php echo $solution_info['memory']; ?>kB</td>
                        <td><?php echo $solution_info['length']; ?>B</td>
                        <td><?php echo $solution_info['date']; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <pre id='errtxt' class="alert alert-error"><?php echo $view_reinfo ?></pre>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">辅助解释</div>
                    <div id='errexp' class="card-body"></div>
                </div>
            </div>
        </div>

    </div>
</main>


<!-- Bootstrap core JavaScript
  ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
<script>
    var pats = new Array();
    var exps = new Array();
    pats[0] = /A Not allowed system call.* /;
    exps[0] = "使用了系统禁止的操作系统调用，请查看是否越权访问了文件或进程等资源";
    //如果你是系统管理员，而且确认提交的答案没有问题，测试数据没有问题，可以发送'RE'到微信公众号onlinejudge，查看解决方案。
    pats[1] = /Segmentation fault/;
    exps[1] = "段错误，检查是否有数组越界，指针异常，访问到不应该访问的内存区域";
    pats[2] = /Floating point exception/;
    exps[2] = "浮点错误，检查是否有除以零的情况";
    pats[3] = /buffer overflow detected/;
    exps[3] = "缓冲区溢出，检查是否有字符串长度超出数组的情况";
    pats[4] = /Killed/;
    exps[4] = "进程因为内存或时间原因被杀死，检查是否有死循环";
    pats[5] = /Alarm clock/;
    exps[5] = "进程因为时间原因被杀死，检查是否有死循环，本错误等价于超时TLE";
    pats[6] = /CALLID:20/;
    exps[6] = "可能存在数组越界，检查题目描述的数据量与所申请数组大小关系";

    function explain() {
        //alert("asdf");
        let errmsg = $("#errtxt").text();
        let expmsg = "";
        for (let i = 0; i < pats.length; i++) {
            let pat = pats[i];
            let exp = exps[i];
            let ret = pat.exec(errmsg);
            if (ret) {
                expmsg += ret + ":" + exp + "<br><hr />";
            }
        }
        document.getElementById("errexp").innerHTML = expmsg;
        //alert(expmsg);
    }

    explain();
</script>
</body>

</html>