<?php
$cache_time = 1;
require_once('./include/cache_start.php');
require_once("./include/db_info.inc.php");
require_once("./include/setlang.php");
$view_title = "LOGIN";

if (isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
    echo "<a href=logout.php>您已登陆，如切换账号请先进行注销!</a>";
    exit(1);
}

/////////////////////////Template
require "template/$OJ_TEMPLATE/loginpage.php";
require "oj-footer.php";

/////////////////////////Common foot
if (file_exists('./include/cache_end.php')) {
    require_once('./include/cache_end.php');
}

