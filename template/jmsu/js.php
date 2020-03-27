<script src="<?php echo $OJ_CDN_URL . $path_fix . "template/$OJ_TEMPLATE/" ?>jquery.min.js"></script>
<script src="<?php echo $OJ_CDN_URL . $path_fix . "template/$OJ_TEMPLATE/" ?>popper.min.js"></script>
<script src="<?php echo $OJ_CDN_URL . $path_fix . "template/$OJ_TEMPLATE/bootstrap/js/" ?>bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/echarts/4.7.0/echarts.min.js"></script>

<?php
if (file_exists("./admin/msg.txt")) {
    $view_marquee_msg = file_get_contents($OJ_SAE ? "saestor://web/msg.txt" : "./admin/msg.txt");
}
if (file_exists("../admin/msg.txt")) {
    $view_marquee_msg = file_get_contents($OJ_SAE ? "saestor://web/msg.txt" : "../admin/msg.txt");
}


?>
<!--  to enable mathjax in hustoj:
svn export http://github.com/mathjax/MathJax/trunk /home/judge/src/web/mathjax
<script type="text/javascript"
  src="mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
or
<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>

-->
<script>
    $(document).ready(function () {
        const msg = <?php echo json_encode($view_marquee_msg); ?> +"";
        $("main > .container").prepend(msg);
        $("form").append("<div id='csrf' />");
        $("#csrf").load("<?php echo $path_fix?>csrf.php");
        <?php
        if (isset($_SESSION[$OJ_NAME . "_administrator"])) {
            echo "admin_mod();";
        }
        ?>
    });

    $(".hint pre").each(function () {
        let plus = "<span class='glyphicon glyphicon-plus'>Click</span>";
        let content = $(this);
        $(this).before(plus);
        $(this).prev().click(function () {
            content.toggle();
        });

    });

    function admin_mod() {
        $("div[fd=source]").each(function () {
            let pid = $(this).attr('pid');
            $(this).append("<span><span class='label label-success' pid='" + pid + "' onclick='problem_add_source(this," + pid + ");'>+</span></span>");

        });
        $("span[fd=time_limit]").each(function () {
            let sp = $(this);
            let pid = $(this).attr('pid');
            $(this).dblclick(function () {
                let time = sp.text();
                console.log("pid:" + pid + "  time_limit:" + time);
                sp.html("<form onsubmit='return false;'><input type=hidden name='m' value='problem_update_time'><input type='hidden' name='pid' value='" + pid + "'><input type='text' name='t' value='" + time + "' selected='true' class='input-mini' size=2 ></form>");
                let ipt = sp.find("input[name=t]");
                ipt.focus();
                ipt[0].select();
                sp.find("input").change(function () {
                    let newtime = sp.find("input[name=t]").val();
                    $.post("admin/ajax.php", sp.find("form").serialize()).done(function () {
                        console.log("new time_limit:" + time);
                        sp.html(newtime);
                    });

                });
            });

        });
    }

    function problem_add_source(sp, pid) {
        console.log("pid:" + pid);
        let p = $(sp).parent();
        p.html("<form onsubmit='return false;'><input type='hidden' name='m' value='problem_add_source'><input type='hidden' name='pid' value='" + pid + "'><input type='text' class='input input-large' name='ns'></form>");
        p.find("input").focus();
        p.find("input").change(function () {
            console.log(p.find("form").serialize());
            let ns = p.find("input[name=ns]").val();
            console.log("new source:" + ns);
            $.post("admin/ajax.php", p.find("form").serialize());
            p.parent().append("<span class='label label-success'>" + ns + "</span>");
            p.html("<span class='label label-success' pid='" + pid + "' onclick='problem_add_source(this," + pid + ");'>+</span>");
        });
    }
</script>

