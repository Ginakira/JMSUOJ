<?php
$url = basename($_SERVER['REQUEST_URI']);
$dir = basename(getcwd());
if ($dir == "discuss3") {
    $path_fix = "../";
} else {
    $path_fix = "";
}

if (isset($OJ_NEED_LOGIN) && $OJ_NEED_LOGIN && ($url != 'loginpage.php' &&
    $url != 'lostpassword.php' &&
    $url != 'lostpassword2.php' &&
    $url != 'registerpage.php') && !isset($_SESSION[$OJ_NAME . '_' . 'user_id'])) {
    header("location:" . $path_fix . "loginpage.php");
    exit();
}

if ($OJ_ONLINE) {
    require_once $path_fix . 'include/online.php';
    $on = new online();
}
?>
<!-- Static navbar -->
<nav class="navbar navbar-expand-sm bg-info navbar-dark" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="navbar-toggler-icon"></span>
                <!--
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              -->
            </button>
            <a class="navbar-brand" href="<?php echo $OJ_HOME ?>"><?php echo $OJ_NAME ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php $ACTIVE = "active" ?>
                <?php if (!isset($OJ_ON_SITE_CONTEST_ID)) { ?>

                    <?php if ($OJ_BBS) { ?>
                        <li class="nav-item <?php if ($dir == "discuss3") {
    echo " $ACTIVE";
}
                                            ?>">
                            <a class="nav-link" href="<?php echo $path_fix ?>bbs.php<?php if (isset($_GET['cid'])) {
                                                echo "?cid=" . intval($_GET['cid']);
                                            }
                                                                                    ?>"><i class="fas fa-comment-alt"></i> <?php echo $MSG_BBS ?></a></li>
                    <?php }
                } else {
                    if ($OJ_BBS) { ?>
                        <li class="nav-item <?php if ($dir == "discuss3") {
                        echo " $ACTIVE";
                    }
                                            ?>"><a class="nav-link" href="<?php echo $path_fix ?>bbs.php<?php echo "?cid=" . intval($OJ_ON_SITE_CONTEST_ID); ?>">
                                <i class="fas fa-comment-alt"></i> <?php echo $MSG_BBS ?></a>
                        </li>
                <?php }
                }
                ?>

                <?php if (isset($OJ_PRINTER) && $OJ_PRINTER) { ?>
                    <li <?php if ($url == "printer.php") {
                    echo " $ACTIVE";
                }
                        ?>><a href="<?php echo $path_fix ?>printeyphicon-print" r.php"><span class="glyphicon gl aria-hidden=" true"></span> <?php echo $MSG_PRINTER ?></a></li> <?php } ?> <?php if (!isset($OJ_ON_SITE_CONTEST_ID)) { ?>
                    <li class='nav-item <?php if ($url == "problemset.php") {
                            echo " $ACTIVE";
                        }        ?>'><a class='nav-link' href="<?php echo $path_fix ?>problemset.php">
                            <i class="fas fa-book"></i> <?php echo $MSG_PROBLEMS ?></a></li>
                    <li class='nav-item <?php if ($url == "category.php") {
                            echo " $ACTIVE";
                        }                   ?>'><a class='nav-link' href="<?php echo $path_fix ?>category.php"><i class="fas fa-th-list"></i> <?php echo $MSG_SOURCE ?></a></li>
                    <li class='nav-item <?php if ($url == "status.php") {
                            echo " $ACTIVE";
                        }                             ?>'><a class='nav-link' href="<?php echo $path_fix ?>status.php"><i class="fas fa-play-circle"></i> <?php echo $MSG_JUDGE_STATUS ?></a></li>
                    <?php if (isset($OJ_OI_MODE) && $OJ_OI_MODE) {
                        } else { ?>
                        <li class='nav-item <?php if ($url == "ranklist.php") {
                            echo " $ACTIVE";
                        }                             ?>'><a class='nav-link' href="<?php echo $path_fix ?>ranklist.php"><i class="fas fa-thumbs-up"></i> <?php echo $MSG_RANKLIST ?></a></li>
                    <?php } ?>
                    <li class='nav-item <?php if ($url == "contest.php") {
                            echo " $ACTIVE";
                        }
                                        ?>'><a class='nav-link' href="<?php echo $path_fix ?>contest.php"><i class=" fas fa-fire"></i> <?php echo $MSG_CONTEST ?></a></li>
                    <?php if (isset($OJ_RECENT_CONTEST) && $OJ_RECENT_CONTEST) { ?>
                        <li class='nav-item <?php if ($url == "recent-contest.php") {
                                            echo " $ACTIVE";
                                        }
                                            ?>'><a class='nav-link' href="<?php echo $path_fix ?>recent-contest.php"><i class="fas fa-globe"></i> <?php echo $MSG_RECENT_CONTEST ?></a></li>
                    <?php } ?>
                <?php } else { ?>
                    <li class='nav-item <?php if ($url == " contest.php") {
                                                echo " $ACTIVE";
                                            }                            ?>'><a class='nav-link' href="<?php echo $path_fix ?>contest.php<?php echo "?cid=" . intval($OJ_ON_SITE_CONTEST_ID); ?>"><i class="fas fa-fire"></i> <?php echo $MSG_CONTEST ?></a></li>
                <?php } ?>
                <li class='nav-item <?php if ($url == "faqs.php") {
                                                echo " $ACTIVE";
                                            }
                                    ?>'><a class='nav-link' href="<?php echo $path_fix ?>faqs.php">
                        <i class="fas fa-question-circle"></i> <?php echo $MSG_FAQ ?></a></li>
                <?php if (isset($_GET['cid'])) {
                                        $cid = intval($_GET['cid']); ?>
                    <li><a>&emsp;</a></li>

                    <li class="active"><a class='btn btn-primary btn-sm' href="<?php echo $path_fix ?>contest.php?cid=<?php echo $cid ?>">
                            <?php echo $MSG_PROBLEMS ?>
                        </a></li>
                    <li class=" active"><a class='btn btn-warning btn-sm' href="<?php echo $path_fix ?>status.php?cid=<?php echo $cid ?>">
                            <?php echo $MSG_STATUS ?>
                        </a></li>
                    <li class=" active"><a class='btn btn-danger btn-sm' href="<?php echo $path_fix ?>contestrank.php?cid=<?php echo $cid ?>">
                            <?php echo $MSG_RANKLIST ?>
                        </a></li>
                    <?php if ($OJ_OI_MODE) {
                                            echo "<li class='active' ><a href='" . $path_fix . "contestrank-oi.php?cid=" . $cid . "'OI" . $MSG_RANKLIST;
                                        } ?>
                    <!-- nav栏上的统计按钮
      <li class=" active"><a class='btn btn-secondary btn-sm' href="<?php echo $path_fix ?>conteststatistics.php?cid=<?php echo $cid ?>">
                                                                <?php echo $MSG_STATISTICS ?>
                                                            </a></li>
                                            -->
                    <li><a></a></li>
                <?php
                                    } ?>

                <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
	-->
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fas fa-user-circle"></i> <span id="profile">Login</span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <script src="<?php echo $path_fix . "template/$OJ_TEMPLATE/profile.php?" . rand(); ?>"></script>
                        <!--<li><a href="../navbar-fixed-top/">Fixed top</a></li>-->
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>
<div class="alert alert-danger alert-dismissible fade show text-center">
    JMSU OnlineJudge提醒您：<b>勤洗手 不聚众 开窗通风 正确佩戴口罩 注意个人卫生</b>
</div>