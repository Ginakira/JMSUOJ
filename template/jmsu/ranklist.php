<!DOCTYPE html>
<html lang="zh-cn" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>排名 | <?php echo $OJ_NAME ?></title>
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
            <div class="col justify-content-start">
                <form class="form-inline" action="ranklist.php">
                    <?php echo $MSG_USER ?>
                    <input class="form-control" name="prefix" aria-label="user-search"
                           value="<?php echo htmlentities(isset($_GET['prefix']) ? $_GET['prefix'] : "", ENT_QUOTES, "utf-8") ?>">
                    <input type=submit class="form-control" value=Search>
                </form>
            </div>
            <div class="col justify-content-end text-right">
                <a href=ranklist.php?scope=d>日排名</a>
                <a href=ranklist.php?scope=w>周排名</a>
                <a href=ranklist.php?scope=m>月排名</a>
                <a href=ranklist.php?scope=y>年排名</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo $MSG_Number ?></th>
                        <th><?php echo $MSG_USER ?></th>
                        <th><?php echo $MSG_NICK ?></th>
                        <th><?php echo $MSG_AC ?></th>
                        <th><?php echo $MSG_SUBMIT ?></th>
                        <th><?php echo $MSG_RATIO ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cnt = 0;
                    foreach ($view_rank as $row) {
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
        <div class="row mb-4">
            <div class="col text-center">
                <?php
                $qs = "";
                if (isset($_GET['prefix'])) {
                    $qs .= "&prefix=" . htmlentities($_GET['prefix'], ENT_QUOTES, "utf-8");
                }
                if (isset($scope)) {
                    $qs .= "&scope=" . htmlentities($scope, ENT_QUOTES, "utf-8");
                }
                for ($i = 0; $i < $view_total; $i += $page_size) {
                    echo "<a href='./ranklist.php?start=" . strval($i) . $qs . "'>";
                    echo strval($i + 1);
                    echo "-";
                    echo strval($i + $page_size);
                    echo "</a>&nbsp;";
                    if ($i % 250 == 200) {
                        echo "<br>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php"); ?>
</body>
</html>
