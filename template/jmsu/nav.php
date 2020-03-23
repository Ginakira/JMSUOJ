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
<header>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-2 shadow-lg" role="navigation"
         style="background-color: #0f4c81">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="<?php echo $OJ_HOME ?>"><?php echo $OJ_NAME ?></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php $ACTIVE = "active" ?>
                    <?php if (!isset($OJ_ON_SITE_CONTEST_ID)) { ?>

                        <li class="nav-item">
                            <a class=" nav-link" href="https://bbs.jmsu.xyz/"><i
                                        class="fas fa-comment-alt"></i> <?php echo $MSG_BBS ?></a></li>

                    <?php } ?>

                    <?php if (isset($OJ_PRINTER) && $OJ_PRINTER) { ?>
                        <li <?php if ($url == "printer.php") {
                            echo " $ACTIVE";
                        }
                        ?>><a href="<?php echo $path_fix ?>printeyphicon-print" r.php"><span
                                    class="glyphicon gl aria-hidden=" true"></span> <?php echo $MSG_PRINTER ?></a>
                        </li> <?php } ?> <?php if (!isset($OJ_ON_SITE_CONTEST_ID)) { ?>
                        <li class='nav-item <?php if (strpos($url, "problem") !== false) {
                            echo " $ACTIVE";
                        } ?>'><a class='nav-link' href="<?php echo $path_fix ?>problemset.php">
                                <i class="fas fa-book"></i> <?php echo $MSG_PROBLEMS ?></a></li>
                        <li class='nav-item <?php if ($url == "category.php") {
                            echo " $ACTIVE";
                        } ?>'><a class='nav-link' href="<?php echo $path_fix ?>category.php"><i
                                        class="fas fa-th-list"></i> <?php echo $MSG_SOURCE ?></a></li>
                        <li class='nav-item <?php if ($url == "status.php") {
                            echo " $ACTIVE";
                        } ?>'><a class='nav-link' href="<?php echo $path_fix ?>status.php"><i
                                        class="fas fa-play-circle"></i> <?php echo $MSG_JUDGE_STATUS ?></a></li>
                        <?php if (isset($OJ_OI_MODE) && $OJ_OI_MODE) {
                        } else { ?>
                            <li class='nav-item <?php if ($url == "ranklist.php") {
                                echo " $ACTIVE";
                            } ?>'><a class='nav-link' href="<?php echo $path_fix ?>ranklist.php"><i
                                            class="fas fa-thumbs-up"></i> <?php echo $MSG_RANKLIST ?></a></li>
                        <?php } ?>
                        <li class='nav-item <?php if ($url == "contest.php") {
                            echo " $ACTIVE";
                        }
                        ?>'><a class='nav-link' href="<?php echo $path_fix ?>contest.php"><i
                                        class=" fas fa-fire"></i> <?php echo $MSG_CONTEST ?></a></li>
                        <?php if (isset($OJ_RECENT_CONTEST) && $OJ_RECENT_CONTEST) { ?>
                            <li class='nav-item <?php if ($url == "recent-contest.php") {
                                echo " $ACTIVE";
                            }
                            ?>'><a class='nav-link' href="<?php echo $path_fix ?>recent-contest.php"><i
                                            class="fas fa-globe"></i> <?php echo $MSG_RECENT_CONTEST ?></a></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li class='nav-item <?php if ($url == " contest.php") {
                            echo " $ACTIVE";
                        } ?>'><a class='nav-link'
                                 href="<?php echo $path_fix ?>contest.php<?php echo "?cid=" . intval($OJ_ON_SITE_CONTEST_ID); ?>"><i
                                        class="fas fa-fire"></i> <?php echo $MSG_CONTEST ?></a></li>
                    <?php } ?>
                    <li class='nav-item <?php if ($url == "faqs.php") {
                        echo " $ACTIVE";
                    }
                    ?>'><a class='nav-link' href="<?php echo $path_fix ?>faqs.php">
                            <i class="fas fa-question-circle"></i> <?php echo $MSG_FAQ ?></a></li>
                    <?php if (isset($_GET['cid'])) {
                        $cid = intval($_GET['cid']); ?>
                        <li><a>&emsp;</a></li>

                        <li class="active"><a class='btn btn-primary btn-sm'
                                              href="<?php echo $path_fix ?>contest.php?cid=<?php echo $cid ?>">
                                <?php echo $MSG_PROBLEMS ?>
                            </a></li>
                        <li class=" active"><a class='btn btn-warning btn-sm'
                                               href="<?php echo $path_fix ?>status.php?cid=<?php echo $cid ?>">
                                <?php echo $MSG_STATUS ?>
                            </a></li>
                        <li class=" active"><a class='btn btn-danger btn-sm'
                                               href="<?php echo $path_fix ?>contestrank.php?cid=<?php echo $cid ?>">
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

                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i
                                    class="fas fa-user-circle"></i> <span id="profile">Login</span><span
                                    class="caret"></span></a>
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
</header>
