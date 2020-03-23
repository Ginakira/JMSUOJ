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
        提交记录 | <?php echo $OJ_NAME ?>
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
        <div class="row mb-2">
            <div class="col text-center">
                <div class="alert alert-primary alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>提示</strong>：提交完成后<strong>刷新页面</strong>，点击结果<strong>分数</strong>即可查看具体评测点信息
                </div>
                <form id=simform class=form-inline action="status.php" method="get">
                    <?php echo $MSG_PROBLEM_ID ?>:<input class="form-control" type=text size=4 name=problem_id
                                                         value='<?php echo htmlspecialchars($problem_id, ENT_QUOTES) ?>'>
                    <?php echo $MSG_USER ?>:<input class="form-control" type=text size=4 name=user_id
                                                   value='<?php echo htmlspecialchars($user_id, ENT_QUOTES) ?>'>
                    <?php if (isset($cid)) {
                        echo "<input type='hidden' name='cid' value='$cid'>";
                    }
                    ?>
                    <?php echo $MSG_LANG ?>:
                    <select class="form-control" size="1" name="language">
                        <option value="-1">All</option>
                        <?php
                        if (isset($_GET['language'])) {
                            $selectedLang = intval($_GET['language']);
                        } else {
                            $selectedLang = -1;
                        }
                        $lang_count = count($language_ext);
                        $langmask = $OJ_LANGMASK;
                        $lang = (~((int)$langmask)) & ((1 << ($lang_count)) - 1);
                        for ($i = 0; $i < $lang_count; $i++) {
                            if ($lang & (1 << $i)) {
                                echo "<option value=$i " . ($selectedLang == $i ? "selected" : "") . ">
		" . $language_name[$i] . "
		</option>";
                            }

                        }
                        ?>
                    </select>
                    <?php echo $MSG_RESULT ?>:
                    <select class="form-control" size="1" name="jresult">
                        <?php if (isset($_GET['jresult'])) {
                            $jresult_get = intval($_GET['jresult']);
                        } else {
                            $jresult_get = -1;
                        }

                        if ($jresult_get >= 12 || $jresult_get < 0) {
                            $jresult_get = -1;
                        }

                        /*if ($jresult_get!=-1){
                        $sql=$sql."AND `result`='".strval($jresult_get)."' ";
                        $str2=$str2."&jresult=".strval($jresult_get);
                        }*/
                        if ($jresult_get == -1) {
                            echo "<option value='-1' selected>All</option>";
                        } else {
                            echo "<option value='-1'>All</option>";
                        }

                        for ($j = 0; $j < 12; $j++) {
                            $i = ($j + 4) % 12;
                            if ($i == $jresult_get) {
                                echo "<option value='" . strval($jresult_get) . "' selected>" . $jresult[$i] . "</option>";
                            } else {
                                echo "<option value='" . strval($i) . "'>" . $jresult[$i] . "</option>";
                            }

                        }
                        echo "</select>";
                        ?>
                    </select>
                    <?php if (isset($_SESSION[$OJ_NAME . '_' . 'administrator']) || isset($_SESSION[$OJ_NAME . '_' . 'source_browser'])) {
                        if (isset($_GET['showsim'])) {
                            $showsim = intval($_GET['showsim']);
                        } else {
                            $showsim = 0;
                        }

                        echo "SIM:
                        <select id=\"appendedInputButton\" class=\"form-control\" name=showsim onchange=\"document.getElementById('simform').submit();\">
                        <option value=0 " . ($showsim == 0 ? 'selected' : '') . ">All</option>
                        <option value=50 " . ($showsim == 50 ? 'selected' : '') . ">50</option>
                        <option value=60 " . ($showsim == 60 ? 'selected' : '') . ">60</option>
                        <option value=70 " . ($showsim == 70 ? 'selected' : '') . ">70</option>
                        <option value=80 " . ($showsim == 80 ? 'selected' : '') . ">80</option>
                        <option value=90 " . ($showsim == 90 ? 'selected' : '') . ">90</option>
                        <option value=100 " . ($showsim == 100 ? 'selected' : '') . ">100</option>
                        </select>";
                        /* if (isset($_GET['cid']))
                        echo "<input type=hidden name=cid value='".$_GET['cid']."'>";
                        if (isset($_GET['language']))
                        echo "<input type=hidden name=language value='".$_GET['language']."'>";
                        if (isset($_GET['user_id']))
                        echo "<input type=hidden name=user_id value='".$_GET['user_id']."'>";
                        if (isset($_GET['problem_id']))
                        echo "<input type=hidden name=problem_id value='".$_GET['problem_id']."'>";
                        //echo "<input type=submit>";
                         */
                    }
                    echo "<input type=submit class='form-control btn btn-outline-primary' value='$MSG_SEARCH'></form>";
                    ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table id=result-tab class="table text-center table-hover">
                    <thead class="thead-light">
                    <tr class='toprow'>
                        <th>
                            <?php echo $MSG_RUNID ?>
                        </th>
                        <th>
                            <?php echo $MSG_USER ?>
                        </th>
                        <th>
                            <?php echo $MSG_PROBLEM ?>
                        </th>
                        <th>
                            <?php echo $MSG_RESULT ?>
                        </th>
                        <th class='hidden-xs'>
                            <?php echo $MSG_MEMORY . "(KB)" ?>
                        </th>
                        <th class='hidden-xs'>
                            <?php echo $MSG_TIME . "(MS)" ?>
                        </th>
                        <th>
                            <?php echo $MSG_LANG ?>
                        </th>
                        <th class='hidden-xs'>
                            <?php echo $MSG_CODE_LENGTH ?>
                        </th>
                        <th>
                            <?php echo $MSG_SUBMIT_TIME ?>
                        </th>
                        <th class='hidden-xs'>
                            <?php echo $MSG_JUDGER ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cnt = 0;
                    foreach ($view_status as $row) {
                        if ($cnt) {
                            echo "<tr class='oddrow'>";
                        } else {
                            echo "<tr class='evenrow'>";
                        }

                        $i = 0;
                        foreach ($row as $table_cell) {
                            if ($i > 3 && $i != 8 && $i != 6) {
                                echo "<td class='hidden-xs'>";
                            } else {
                                echo "<td>";
                            }

                            echo $table_cell;
                            echo "</td>";
                            $i++;
                        }
                        echo "</tr>\n";
                        $cnt = 1 - $cnt;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div id=center class="text-center">
                    <?php echo "<a href='status.php?" . $str2 . "' class='btn btn-outline-secondary'>&laquo;</a>&nbsp;&nbsp;";
                    if (isset($_GET['prevtop'])) {
                        echo "<a href='status.php?" . $str2 . "&top=" . intval($_GET['prevtop']) . "' class='btn btn-outline-primary'>&lsaquo;</a>&nbsp;&nbsp;";
                    } else {
                        echo "<a href='status.php?" . $str2 . "&top=" . ($top + 20) . "' class='btn btn-outline-primary'>&lsaquo;</a>&nbsp;&nbsp;";
                    }

                    echo "<a href='status.php?" . $str2 . "&top=" . $bottom . "&prevtop=$top' class='btn btn-outline-primary'>&rsaquo;</a>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
<script>
    var i = 0;
    var judge_result = [ <?php
        foreach ($judge_result as $result) {
            echo "'$result',";
        }
        ?>
        ''
    ];

    var judge_color = [ <?php
        foreach ($judge_color as $result) {
            echo "'$result',";
        }
        ?>
        ''
    ];
</script>
<script src="template/<?php echo $OJ_TEMPLATE ?>/auto_refresh.js?v=0.37"></script>
</body>
</html>
