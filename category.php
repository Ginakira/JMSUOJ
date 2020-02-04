<?php
////////////////////////////Common head
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
        require_once('./include/db_info.inc.php');
        require_once('./include/const.inc.php');
        require_once('./include/memcache.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
 $result=false;	
///////////////////////////MAIN	
	
	$view_category="";
	$sql=	"select distinct source "
			."FROM `problem` where defunct='N'"
			."LIMIT 500";
	$result=mysql_query_cache($sql);//mysql_escape_string($sql));
	$category=array();
        foreach ($result as $row){
		$cate=explode(" ",$row['source']);
		foreach($cate as $cat){
			array_push($category,trim($cat));	
		}
	}
	$category=array_unique($category);
	if (!$result){
		$view_category= "<h3>No Category Now!</h3>";
	}else{
		$view_category.= "<div style='word-wrap:break-word;'><p>";
		foreach ($category as $cat){
			if(trim($cat)=="") continue;
			$hash_num=hexdec(substr(md5($cat),0,7));
			$label_theme=$color_theme[$hash_num%count($color_theme)];
			if($label_theme=="") $label_theme="default";
			$view_category.= "<a class='badge badge-$label_theme' style='font-size: 15px; display: inline-block;' href='problemset.php?search=".urlencode(htmlentities($cat,ENT_QUOTES,'UTF-8'))."'>".$cat."</a>&nbsp;";
		}
		
		$view_category.= "</p></div>";
	}

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/category.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
