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
        题目 | <?php echo $OJ_NAME ?>
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
<!-- Main component for a primary marketing message or call to action -->
<main class="flex-shrink-0">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="problemset.php?page=1">&laquo;</a>
                        </li>
                        <?php
                        if (!isset($page)) {
                            $page = 1;
                        }

                        $page = intval($page);
                        $section = 8;
                        $start = $page > $section ? $page - $section : 1;
                        $end = $page + $section > $view_total_page ? $view_total_page : $page + $section;
                        for ($i = $start; $i <= $end; $i++) {
                            echo "<li class='" . ($page == $i ? "active " : "") . "page-item'>
                        <a class='page-link' href='problemset.php?page=" . $i . "'>" . $i . "</a></li>";
                        }
                        ?>
                        <li class="page-item">
                            <a class="page-link"
                               href="problemset.php?page=<?php echo $view_total_page ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <form action=problem.php>
                    <div class="row">
                        <div class="col input-group">
                            <input class="form-control search-query" type='text' name='id' placeholder="题目编号"
                                   aria-label="Problem ID">
                            <div class="input-group-append">
                                <button class="form-control btn btn-outline-primary" type='submit'>Go</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col">
                <form class="form-search">
                    <div class="row">
                        <div class="col input-group">
                            <input type="text" name=search class="form-control search-query"
                                   placeholder="关键字/标签" aria-label="Keyword/Tag">
                            <div class="input-group-append">
                                <button type="submit" class="form-control btn btn-outline-primary">
                                    <?php echo $MSG_SEARCH ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table id='problemset' class='table text-center table-bordered table-hover'>
                <colgroup>
                    <col style="width: 7%">
                    <col style="width: 8%">
                    <col>
                    <col style="width: 15%">
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead class="thead-light">
                <tr class='toprow'>
                    <th>状态</th>
                    <th>
                        <?php echo $MSG_PROBLEM_ID ?>
                    </th>
                    <th>
                        <?php echo $MSG_TITLE ?>
                    </th>
                    <th class="d-none d-lg-table-cell">通过率</th>
                    <th class="d-none d-lg-table-cell">
                        <?php echo $MSG_SOURCE ?>
                    </th>
                    <th>
                        <?php echo $MSG_AC ?>
                    </th>
                    <th>
                        <?php echo $MSG_SUBMIT ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt = 0;
                foreach ($view_problemset as $row) {
                    if ($cnt) {
                        echo "<tr class='oddrow'>";
                    } else {
                        echo "<tr class='evenrow'>";
                    }

                    $i = 0;
                    foreach ($row as $table_cell) {
                        if ($i == 3 || $i == 4) {
                            echo "<td class='d-none d-lg-table-cell'>";
                        } else {
                            echo "<td>";
                        }

                        echo "\t" . $table_cell;
                        echo "</td>";
                        $i++;
                    }
                    echo "</tr>";
                    $cnt = 1 - $cnt;
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="problemset.php?page=1">&laquo;</a>
                        </li>
                        <?php
                        if (!isset($page)) {
                            $page = 1;
                        }

                        $page = intval($page);
                        $section = 8;
                        $start = $page > $section ? $page - $section : 1;
                        $end = $page + $section > $view_total_page ? $view_total_page : $page + $section;
                        for ($i = $start; $i <= $end; $i++) {
                            echo "<li class='" . ($page == $i ? "active " : "") . "page-item'>
                        <a class='page-link' href='problemset.php?page=" . $i . "'>" . $i . "</a></li>";
                        }
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="problemset.php?page=<?php echo $view_total_page ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>
<!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include "template/$OJ_TEMPLATE/js.php"; ?>
<script type="text/javascript" src="include/jquery.tablesorter.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#problemset").tablesorter();
        $("#problemset").after($("#page").prop("outerHTML"));
    });
</script>
</body>
</html>