<?php
require_once "oj-header.php";
require_once "discuss_func.inc.php";
$parm = "";
if (isset($_GET['pid'])) {
    $pid = intval($_GET['pid']);
    $parm = "pid=" . $pid;
} else {
    $pid = 0;
}
if (isset($_GET['cid'])) {
    $cid = intval($_GET['cid']);
} else {
    $cid = 0;
}
$parm .= "&cid=" . $cid;
$prob_exist = problem_exist($pid, $cid);
require_once "oj-header.php";
echo "<title>HUST Online Judge WebBoard</title>";
?>
<center>
    <div style="width:98%">
        <?php
        if ($prob_exist) { ?>
            <div style="text-align:left;font-size:80%">
                <a class="btn btn-primary" href="newpost.php<?php
                                        if ($pid != 0 && $cid != null) {
                                            echo "?pid=" . $pid . "&cid=" . $cid;
                                        } elseif ($pid != 0) {
                                            echo "?pid=" . $pid;
                                        } elseif ($cid != 0) {
                                            echo "?cid=" . $cid;
                                        }
                                        ?>
		"><i class="fas fa-file"></i> 发布新帖</a></div>
            <div style="float:left;text-align:left;font-size:80%">
                当前版块 :
                <?php if ($cid != null) {
                                            echo "<a href=\"discuss.php?cid=" . $cid . "\">Contest " . $cid . "</a>";
                                        } else {
                                            echo "<a href=\"discuss.php\">MainBoard</a>";
                                        }

                if ($pid != null && $pid != 0) {
                    $query = "?pid=$pid";
                    if ($cid != 0) {
                        $query .= "&cid=$cid";
                        $PAL = pdo_query("select num from contest_problem where contest_id=? and problem_id=?", $cid, $pid)[0][0];
                        echo " >> <a href=\"discuss.php" . $query . "\">Problem " . $PID[$PAL] . "</a>";
                    } else {
                        echo " >> <a href=\"discuss.php" . $query . "\">Problem " . $pid . "</a>";
                    }
                }
                ?>
            </div>
            <div style="float:right;font-size:80%;color:red;font-weight:bold">
                <?php if ($pid != null && $pid != 0 && ($cid == '' || $cid == null)) { ?>
                    <a href="../problem.php?id=<?php echo $pid ?>">See the problem</a>
                <?php } ?>
            </div>
        <?php
        }
        $sql = "SELECT `tid`, `title`, `top_level`, `t`.`status`, `cid`, `pid`, CONVERT(MIN(`r`.`time`),DATE) `posttime`,
		MAX(`r`.`time`) `lastupdate`, `t`.`author_id`, COUNT(`rid`) `count`
		FROM `topic` t left join `reply` r on t.tid=r.topic_id
		WHERE `t`.`status`!=2  ";
        if (isset($_REQUEST['cid'])) {
            $cid = intval($_REQUEST['cid']);

            $sql = "SELECT `tid`, t.`title`, `top_level`, `t`.`status`, `cid`, `pid`, CONVERT(MIN(`r`.`time`),DATE) `posttime`,
		MAX(`r`.`time`) `lastupdate`, `t`.`author_id`, COUNT(`rid`) `count`,cp.num
		FROM `topic` t left join `reply` r on t.tid=r.topic_id left join contest_problem cp on t.pid=cp.problem_id and cp.contest_id=$cid
		WHERE `t`.`status`!=2  ";
            //echo $sql;
        }
        if (array_key_exists("cid", $_REQUEST) && $_REQUEST['cid'] != '') {
            $sql .= " AND ( `cid` = '" . intval($_REQUEST['cid']) . "'";
        } else {
            $sql .= " AND (`cid`=0 ";
        }

        $sql .= " OR `top_level` = 3 )";
        if (array_key_exists("pid", $_REQUEST) && $_REQUEST['pid'] != '') {
            $sql .= " AND ( `pid` = '" . intval($_REQUEST['pid']) . "' OR `top_level` >= 2 )";
            $level = "";
        } else {
            $level = " - ( `top_level` = 1 )";
        }
        $sql .= " GROUP BY t.tid ORDER BY `top_level`$level DESC, MAX(`r`.`time`) DESC";
        $sql .= " LIMIT 30";
        //echo $sql;
        $result = pdo_query($sql);
        $rows_cnt = count($result);
        $cnt = 0;
        $isadmin = isset($_SESSION[$OJ_NAME . '_' . 'administrator']);
        ?>
        <table class="table table-stripped" style="clear:both; width:100%">
            <tr align=center class='toprow'>
                <td width="2%"><?php if ($isadmin) {
            echo "<input type=checkbox>";
        }
                                ?></td>
                <td width="3%"></td>
                <td width="4%">题号</td>
                <td width="12%">发布者</td>
                <td width="44%">标题</td>
                <td width="10%">发帖时间</td>
                <td width="16%">最后回复</td>
                <td width="3%">回复</td>
            </tr>
            <?php if ($rows_cnt == 0) {
                                    echo("<tr class=\"evenrow\"><td colspan=4></td><td style=\"text-align:center\">还没人发帖哦～</td></tr>");
                                }

            $i = 0;
            foreach ($result as $row) {
                if ($cnt) {
                    echo "<tr align=center class='oddrow'>";
                } else {
                    echo "<tr align=center class='evenrow'>";
                }

                $cnt = 1 - $cnt;
                if ($isadmin) {
                    echo "<td><input type=checkbox></td>";
                } else {
                    echo("<td></td>");
                }

                echo "<td>";
                if ($row['top_level'] != 0) {
                    if ($row['top_level'] != 1 || $row['pid'] == ($pid == '' ? 0 : $pid)) {
                        echo "<b class=\"Top{$row['top_level']} text-info\">Top</b>";
                    }
                } elseif ($row['status'] == 1) {
                    echo "<b class=\"Lock text-secondary\">Lock</b>";
                } elseif ($row['count'] > 20) {
                    echo "<b class=\"Hot\" text-danger>Hot</b>";
                }

                echo "</td>";
                echo "<td>";
                if ($row['pid'] != 0) {
                    if ($row['cid']) {
                        echo "<a href=\"discuss.php?pid={$row['pid']}" . "&cid={$row['cid']}\">";
                        echo "{$PID[$row['num']]}</a>";
                    } else {
                        echo "<a href=\"discuss.php?pid={$row['pid']}\">";
                        echo "{$row['pid']}</a>";
                    }
                }
                echo "</td>";
                echo "<td><a href=\"../userinfo.php?user={$row['author_id']}\">{$row['author_id']}</a></td>";
                if ($row['cid']) {
                    echo "<td><a href=\"thread.php?tid={$row['tid']}&cid={$row['cid']}\">" . htmlentities($row['title'], ENT_QUOTES, "UTF-8") . "</a></td>";
                } else {
                    echo "<td><a href=\"thread.php?tid={$row['tid']}\">" . htmlentities($row['title'], ENT_QUOTES, "UTF-8") . "</a></td>";
                }

                echo "<td class='small'>{$row['posttime']}</td>";
                echo "<td class='small'>{$row['lastupdate']}</td>";
                echo "<td>" . ($row['count'] - 1) . "</td>";
                echo "</tr>";
                $i++;
            }

            ?>

        </table>
    </div>
</center>
<?php require_once "../template/$OJ_TEMPLATE/discuss.php" ?>