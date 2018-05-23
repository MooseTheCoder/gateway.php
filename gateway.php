<?php

$site = "<h1>NO SITE</h1>";

if(isset($_GET['site'])){
	$url = $_GET['site'];
	// Do the magic here
	$site = file_get_contents($url);
	//find everything to replace
	$matches = [];
	$contentToReplace = [];
	preg_match_all('/src="([^">]+)"|href="([^">]+)"/',$site,$matches);
	unset($matches[0]);
	foreach($matches as $matchList){
		foreach($matchList as $match){
			if(!preg_match('/http(s)?:(\/\/)|\/\//g/',$match)){
				$contentToReplace[]=['raw'=>$match];
			}
		}
	}
	foreach($contentToReplace as $content){
		if(!$content == ""){
			if(preg_match('^\/',$content['raw'])){
				//First char is /
				$content['replace'] = $_GET['site'].$content['raw'];
			}else{	
				$content['replace'] = $_GET['site'].'/'.$content['raw'];
			}

			$site = str_replace($content['raw'],$content['replace'],$site);
		}
	}
	echo $site;
}else{
	echo $site;
}
