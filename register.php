<?php
require_once("./include/db_info.inc.php");
if (isset($OJ_REGISTER)&&!$OJ_REGISTER) {
    exit(0);
}
require_once("./include/my_func.inc.php");
require_once("./include/csrf_check.php");
$err_str="";
$err_cnt=0;
$len;
$user_id=trim($_POST['user_id']);
$len=strlen($user_id);
$email=trim($_POST['email']);
$school=trim($_POST['school']);
if (isset($OJ_VCODE)&&$OJ_VCODE) {
    $vcode=trim($_POST['vcode']);
}
if ($OJ_VCODE&&($vcode!= $_SESSION[$OJ_NAME.'_'."vcode"]||$vcode==""||$vcode==null)) {
    $_SESSION[$OJ_NAME.'_'."vcode"]=null;
    $err_str=$err_str."验证码错误！\\n";
    $err_cnt++;
}
if ($OJ_LOGIN_MOD!="hustoj") {
    $err_str=$err_str."System do not allow register.\\n";
    $err_cnt++;
}

if ($len>20) {
    $err_str=$err_str."用户名过长!请修改\\n";
    $err_cnt++;
} elseif ($len<3) {
    $err_str=$err_str."用户名过短！请修改\\n";
    $err_cnt++;
}
if (!is_valid_user_name($user_id)) {
    $err_str=$err_str."用户ID仅允许使用字母+数字!\\n";
    $err_cnt++;
}
$nick=trim($_POST['nick']);
$len=strlen($nick);
if ($len>100) {
    $err_str=$err_str."昵称过长！请修改!\\n";
    $err_cnt++;
} elseif ($len==0) {
    $nick=$user_id;
}
if (strcmp($_POST['password'], $_POST['rptpassword'])!=0) {
    $err_str=$err_str."两次输入的密码不一致!\\n";
    $err_cnt++;
}
if (strlen($_POST['password'])<6) {
    $err_cnt++;
    $err_str=$err_str."密码长度至少六位!\\n";
}
$len=strlen($_POST['school']);
if ($len>100) {
    $err_str=$err_str."学校名过长!\\n";
    $err_cnt++;
}
$len=strlen($_POST['email']);
if ($len>100) {
    $err_str=$err_str."电子邮件地址过长！\\n";
    $err_cnt++;
}
if ($err_cnt>0) {
    print "<script language='javascript'>\n";
    print "alert('";
    print $err_str;
    print "');\n history.go(-1);\n</script>";
    exit(0);
}
$password=pwGen($_POST['password']);
$sql="SELECT `user_id` FROM `users` WHERE `users`.`user_id` = ?";
$result=pdo_query($sql, $user_id);
$rows_cnt=count($result);
if ($rows_cnt == 1) {
    print "<script language='javascript'>\n";
    print "alert('用户ID已经存在!\\n');\n";
    print "history.go(-1);\n</script>";
    exit(0);
}
$nick=(htmlentities($nick, ENT_QUOTES, "UTF-8"));
$school=(htmlentities($school, ENT_QUOTES, "UTF-8"));
$email=(htmlentities($email, ENT_QUOTES, "UTF-8"));
$ip = ($_SERVER['REMOTE_ADDR']);
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&!empty(trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $tmp_ip = explode(',', $REMOTE_ADDR);
    $ip = (htmlentities($tmp_ip[0], ENT_QUOTES, "UTF-8"));
} elseif (isset($_SERVER['HTTP_X_REAL_IP'])&&!empty(trim($_SERVER['HTTP_X_REAL_IP']))) {
    $REMOTE_ADDR = $_SERVER['HTTP_X_REAL_IP'];
    $tmp_ip = explode(',', $REMOTE_ADDR);
    $ip = (htmlentities($tmp_ip[0], ENT_QUOTES, "UTF-8"));
}
if (isset($OJ_REG_NEED_CONFIRM)&&$OJ_REG_NEED_CONFIRM) {
    $defunct="Y";
} else {
    $defunct="N";
}
$sql="INSERT INTO `users`("
."`user_id`,`email`,`ip`,`accesstime`,`password`,`reg_time`,`nick`,`school`,`defunct`)"
."VALUES(?,?,?,NOW(),?,NOW(),?,?,?)";
//echo "$sql:$user_id,$email,$ip,$password,$nick,$school,$defunct";
$rows=pdo_query($sql, $user_id, $email, $ip, $password, $nick, $school, $defunct);// or die("Insert Error!\n");
//echo $rows;
$sql="INSERT INTO `loginlog` VALUES(?,?,?,NOW())";
pdo_query($sql, $user_id, "no save", $ip);

if (!isset($OJ_REG_NEED_CONFIRM)||!$OJ_REG_NEED_CONFIRM) {
    $_SESSION[$OJ_NAME.'_'.'user_id']=$user_id;
    $sql="SELECT `rightstr` FROM `privilege` WHERE `user_id`=?";
    //echo $sql."<br />";
    $result=pdo_query($sql, $_SESSION[$OJ_NAME.'_'.'user_id']);
    foreach ($result as $row) {
        $_SESSION[$OJ_NAME.'_'.$row['rightstr']]=true;
        //echo $_SESSION[$OJ_NAME.'_'.$row['rightstr']]."<br />";
    }
    $_SESSION[$OJ_NAME.'_'.'ac']=array();
    $_SESSION[$OJ_NAME.'_'.'sub']=array();
}
?>
<script>history.go(-2);</script>
