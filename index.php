<?php
////////////////////////////Common head
$cache_time = 30;
$OJ_CACHE_SHARE = true;
require_once './include/cache_start.php';
require_once './include/db_info.inc.php';
require_once './include/memcache.php';
require_once './include/setlang.php';
$view_title = "Welcome To Online Judge";
$result = false;
if (isset($OJ_ON_SITE_CONTEST_ID)) {
    header("location:contest.php?cid=" . $OJ_ON_SITE_CONTEST_ID);
    exit();
}
///////////////////////////MAIN

//2020-01-21重写 news_list为公告列表展现 news_modals为模态框内容
//$view_news = "";
$news_list = "";
$news_modals = "";
$sql = "select * "
    . "FROM `news` "
    . "WHERE `defunct`!='Y'"
    . "ORDER BY `importance` ASC,`time` DESC "
    . "LIMIT 50";
$result = mysql_query_cache($sql); //mysql_escape_string($sql));
if (!$result) {
    $view_news = "<h3>暂无公告!</h3>";
} else {
    $view_news .= "<div class='card' style='width:80%;margin:0 auto;'>";
    $cnt_id = 1; //用于模态框id记录
    foreach ($result as $row) {
        $news_list .= "<tr><td><a href='#' data-toggle='modal' data-target='#news" . $cnt_id . "'>" . $row['title'] . "</a></td>" .
                    "<td class='small'>" . $row['time'] . "</td>" .
                    "<td><span class='badge badge-secondary'>" . $row['user_id'] . "</span></td></tr>";
        $news_modals .= "<div class='modal fade' id='news" . $cnt_id . "'>"; //模态框id
        //模态框头部&标题
        $news_modals .= "<div class='modal-dialog modal-lg'><div class='modal-content'><div class='modal-header'><h4 class='modal-title'>" . $row['title'] . "</h4>-<small>" . $row['user_id'] . "</small><button type='button' class='close' data-dismiss='modal'>&times;</button></div>";
        //模态框主体
        $news_modals .= "<div class='modal-body'>" . $row['content'] . "</div>";
        //模态框底部
        $news_modals .= "<div class='modal-footer'><button type='button' class='btn btn-secondary' data-dismiss='modal'>关闭</button></div></div></div></div>";
        $cnt_id++;
    }
}
$view_apc_info = "";

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM (select * from solution order by solution_id desc limit 8000) solution  where result<13 group by md order by md desc limit 200";
$result = mysql_query_cache($sql); //mysql_escape_string($sql));
$chart_data_all = array();
//echo $sql;

foreach ($result as $row) {
    array_push($chart_data_all, array($row['md'], $row['c']));
}

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM  (select * from solution order by solution_id desc limit 8000) solution where result=4 group by md order by md desc limit 200";
$result = mysql_query_cache($sql); //mysql_escape_string($sql));
$chart_data_ac = array();
//echo $sql;

foreach ($result as $row) {
    array_push($chart_data_ac, array($row['md'], $row['c']));
}
if (isset($_SESSION[$OJ_NAME . '_' . 'administrator'])) {
    $sql = "select avg(sp) sp from (select  avg(1) sp,judgetime from solution where result>3 and judgetime>date_sub(now(),interval 1 hour)  group by (judgetime DIV 60 * 60) order by sp) tt;";
    $result = mysql_query_cache($sql);
    $speed = ($result[0][0] ? $result[0][0] : 0) . '/分钟';
} else {
    if (isset($chart_data_all[0][1])) {
        $speed = ($chart_data_all[0][1] ? $chart_data_all[0][1] : 0) . '/天';
    }
}

/////////////////////////Template
require "template/" . $OJ_TEMPLATE . "/index.php";
/////////////////////////Common foot
if (file_exists('./include/cache_end.php')) {
    require_once './include/cache_end.php';
}
