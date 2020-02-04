<?php 

	$dir=basename(getcwd());
	if($dir=="discuss3"||$dir=="admin") $path_fix="../";
	else $path_fix="";
?>

<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>bootstrap4.min.css">

<!-- Font Awesome 5 图标库 -->
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>fontawesome/css/all.css">

<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/$OJ_CSS"?>">
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>katex.min.css">
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>mathjax.css">
