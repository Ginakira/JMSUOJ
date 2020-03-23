<?php
$OJ_CACHE_SHARE = false;
$cache_time = 0;
require_once './include/db_info.inc.php';
require_once './include/const.inc.php';
//require_once('./include/cache_start.php');
require_once './include/memcache.php';
require_once './include/setlang.php';
$view_title = "Problem Set";
$first = 1000;
//if($OJ_SAE) $first=1;
$sql = "select max(`problem_id`) as upid FROM `problem`";
$page_cnt = 50;
$result = mysql_query_cache($sql);
$row = $result[0];
$cnt = $row['upid'] - $first;
$cnt = $cnt / $page_cnt;

//remember page
$page = "1";
if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
    if (isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
        $sql = "update users set volume=? where user_id=?";
        pdo_query($sql, $page, $_SESSION[$OJ_NAME . '_' . 'user_id']);
    }
} else {
    if (isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
        $sql = "select volume from users where user_id=?";
        $result = pdo_query($sql, $_SESSION[$OJ_NAME . '_' . 'user_id']);
        $row = $result[0];
        $page = intval($row[0]);
    }
    if (!is_numeric($page) || $page < 0) {
        $page = '1';
    }
}
//end of remember page

$pstart = $first + $page_cnt * intval($page) - $page_cnt;
$pend = $pstart + $page_cnt;

$sub_arr = array();
// submit
if (isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
    $sql = "SELECT `problem_id` FROM `solution` WHERE `user_id`=?" .
        //  " AND `problem_id`>='$pstart'".
        // " AND `problem_id`<'$pend'".
        " group by `problem_id`";
    $result = pdo_query($sql, $_SESSION[$OJ_NAME . '_' . 'user_id']);
    foreach ($result as $row) {
        $sub_arr[$row[0]] = true;
    }
}

$acc_arr = array();
// ac
if (isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
    $sql = "SELECT `problem_id` FROM `solution` WHERE `user_id`=?" .
        //  " AND `problem_id`>='$pstart'".
        //  " AND `problem_id`<'$pend'".
        " AND `result`=4" .
        " group by `problem_id`";
    $result = pdo_query($sql, $_SESSION[$OJ_NAME . '_' . 'user_id']);
    foreach ($result as $row) {
        $acc_arr[$row[0]] = true;
    }
}

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = "%" . ($_GET['search']) . "%";
    $filter_sql = " ( title like ? or source like ?)";
    $pstart = 0;
    $pend = 100;
} else {
    $filter_sql = "  `problem_id`>='" . strval($pstart) . "' AND `problem_id`<'" . strval($pend) . "' ";
}

if (isset($_SESSION[$OJ_NAME . '_' . 'administrator'])) {
    $sql = "SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` WHERE $filter_sql ";
} else {
    $now = strftime("%Y-%m-%d %H:%M", time());
    $sql = "SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` " .
        "WHERE `defunct`='N' and $filter_sql AND `problem_id` NOT IN(
		SELECT  `problem_id`
		FROM contest c
		INNER JOIN  `contest_problem` cp ON c.contest_id = cp.contest_id
		AND (
			c.`end_time` >  '$now'
			OR c.private =1
		)

	) "; ////    AND c.`defunct` =  'N'  即使私有结束后被隐藏了，它的题目依旧保留，以免泄露
}
$sql .= " ORDER BY `problem_id`";

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $result = pdo_query($sql, $search, $search);
} else {
    $result = mysql_query_cache($sql);
}

$view_total_page = intval($cnt + 1);

$cnt = 0;
$view_problemset = array();
$i = 0;
foreach ($result as $row) {
    $view_problemset[$i] = array();
    if (isset($sub_arr[$row['problem_id']])) {
        if (isset($acc_arr[$row['problem_id']])) {
            $view_problemset[$i][0] = "<div class='badge badge-pill badge-success'>Solved</div>";
        } else {
            $view_problemset[$i][0] = "<div class='badge badge-pill badge-warning'>Unsolved</div>";
        }
    } else {
        $view_problemset[$i][0] = "<div class=none> </div>";
    }

    $category = array();
    $cate = explode(" ", $row['source']);
    foreach ($cate as $cat) {
        array_push($category, trim($cat));
    }
    $view_problemset[$i][1] = "<div fd='problem_id' class='center'>" . $row['problem_id'] . "</div>";
    $view_problemset[$i][2] = "<div class='left'><a href='problem.php?id=" . $row['problem_id'] . "'>" . $row['title'] . "</a></div>";
    //3号 通过率显示进度条 使用bootstrap4样式
    $pass_percent = round($row['accepted'] / ($row['accepted'] + $row['submit']) * 100);
    $view_problemset[$i][3] = "<div class='progress' style='margin:0 10px 0 10px;height:20px'><div class='progress-bar bg-success' style='width:" . $pass_percent . "%'>" . $pass_percent . "%</div></div>";
    $view_problemset[$i][4] = "<div pid='" . $row['problem_id'] . "' fd='source' class='center'>";
    foreach ($category as $cat) {
        if (trim($cat) == "") {
            continue;
        }

        $hash_num = hexdec(substr(md5($cat), 0, 7));
        $label_theme = $color_theme[$hash_num % count($color_theme)];
        if ($label_theme == "") {
            $label_theme = "default";
        }

        $view_problemset[$i][4] .= "<a title='" . htmlentities($cat, ENT_QUOTES, 'UTF-8') . "' class='badge badge-secondary' style='display: inline-block;' href='problemset.php?search=" . htmlentities($cat, ENT_QUOTES, 'UTF-8') . "'>" . mb_substr($cat, 0, 10, 'utf8') . "</a>&nbsp;";
    }
    $view_problemset[$i][4] .= "</div >";
    $view_problemset[$i][5] = "<div class='center'><a class='badge badge-pill badge-success' href='status.php?problem_id=" . $row['problem_id'] . "&jresult=4'>" . $row['accepted'] . "</a></div>";
    $view_problemset[$i][6] = "<div class='center'><a class='badge badge-pill badge-info' href='status.php?problem_id=" . $row['problem_id'] . "'>" . $row['submit'] . "</a></div>";

    $i++;
}

require "template/$OJ_TEMPLATE/problemset.php";
require "oj-footer.php";
if (file_exists('./include/cache_end.php')) {
    require_once './include/cache_end.php';
}
