<?php
$siteurl = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]";
// FXML DLE wiki.forkplayer.tv
if(!function_exists("ChArrToXML")) {
	function ChArrToXML($ChArr,$tag="channel"){
		$res="";
		$res.= "\n<$tag>
		<logo_30x30><![CD"."ATA[".$ChArr["logo_30x30"]."]"."]></logo_30x30>
		<search_on><![CD"."ATA[".$ChArr["search_on"]."]"."]></search_on>
		<playlist_url><![CD"."ATA[".$ChArr["playlist_url"]."]"."]></playlist_url>
		<title><![CD"."ATA[".$ChArr["title"]."]"."]></title>";
		if(is_array($ChArr["submenu"])) foreach($ChArr["submenu"] as $k=>$v) $res.= "\n <submenu>
		  <logo_30x30><![CD"."ATA[$v[logo_30x30]]"."]></logo_30x30>
		  <search_on><![CD"."ATA[$v[search_on]]"."]></search_on>
		  <presearch><![CD"."ATA[$v[presearch]]"."]></presearch>
		  <title><![CD"."ATA[$v[title]]"."]></title>
		  <playlist_url><![CD"."ATA[$v[playlist_url]]"."]></playlist_url>\n</submenu>";			
		$res.= "\n</$tag>";
		return $res;
	}
}


if($fx=="navigation"){
	$np=explode("<span>", $GLOBALS["tpl"]->data["{pages}"]);
	$next_p=$np[count($np)-1];
	$_CH=[];
	preg_match_all("/href=\"(.*?)\".*?>(.*?)</",$next_p,$arr);
	for($i=0;$i<count($arr[0]);$i++){
		$ch[]=[$arr[1][$i]."&p=".$arr[2][$i],$arr[2][$i]];
		if(strpos($arr[2][$i],"http")===0) {
			$_CH[]=["logo_30x30"=>"hidden","title"=>" &raquo; Страница ".$arr[2][$i],"playlist_url"=>$arr[1][$i]."&p=".$arr[2][$i]];	
			if($i==0) $_CH[0]["title"]="&raquo; Следующая страница";
		}
	}



	for($i=0;$i<count($_CH);$i++){		
		echo ChArrToXML($_CH[$i]);
	}
	
	if(strpos($ch[0][0],"http")===0){
		$_CH[]=["title"=>"Следующая страница","playlist_url"=>$ch[0][0]];
		echo "\n<next_page_url><![CD"."ATA[".$ch[0][0]."]"."]></next_page_url>";
	}
	
}
$_MENU=[];
if($fx=="title"){
	if(!empty($_POST["story"])) $ttl="Поиск по сайту \"".$_POST["story"]."\"";
	else $ttl="";
	if($ttl!=""){
		echo "\n<title><![CD"."ATA[$ttl]"."]></title>";
		echo "\n<navigate><![CD"."ATA[$config[home_title] &raquo; $ttl]"."]></navigate>";
	}
}
if($fx=="mainpage"){		
	$cat_info = get_vars("category");
	$_CH=[];
	$_CH[]=["title"=>"Поиск","search_on"=>"Введите поисковый запрос","playlist_url"=>"$siteurl/index.php?do=search#POSTdo=search&subaction=search&search_start=0&full_search=0&result_from=1&story={search}"];
	if (!is_array($cat_info)) {
		$cat_info = array();

		$db->query("SELECT * FROM " . PREFIX . "_category ORDER BY posi ASC");
		while ($row = $db->get_row()) {

			$cat_info[$row['id']] = array();

			foreach ($row as $key => $value) {
				$cat_info[$row['id']][$key] = stripslashes($value);
			}

		}
		set_vars("category", $cat_info);
		$db->free();
	}
	//print_r($cat_info);	
	$sub=[];
	foreach($cat_info as $k=>$v){
		$sub[]=["logo_30x30"=>$v["icon"],"title"=>$v["name"],"playlist_url"=>"$siteurl/index.php?do=cat&category=$v[alt_name]"];
	}
	$_CH[]=["title"=>"Категории","playlist_url"=>"submenu","submenu"=>$sub];
	$sub=[];
	for($i=0;$i<40;$i++){
		$sub[]=["logo_30x30"=>"","title"=>date("Y",time()-$i*365*24*3600),"playlist_url"=>"$siteurl/index.php?do=xfsearch&xfname=year&xf=".date("Y",time()-$i*365*24*3600)];
	}
	$_CH[]=["title"=>"По годам","playlist_url"=>"submenu","submenu"=>$sub];
	$sub=[];
	foreach(["США","Россия","Китай","Украина","Франция"] as $k=>$v){
		$sub[]=["logo_30x30"=>"","title"=>$v,"playlist_url"=>"$siteurl/index.php?do=xfsearch&xfname=country&xf=".urlencode($v)];
	}
	$_CH[]=["title"=>"По странам","playlist_url"=>"submenu","submenu"=>$sub];
	for($i=0;$i<count($_CH);$i++){		
		echo ChArrToXML($_CH[$i]);
	}
	
}
if($fx=="menu"){
	$_MENU[]=["title"=>$config["home_title"],"playlist_url"=>$siteurl];
	$_MENU[]=["title"=>"Поиск","search_on"=>"Введите поисковый запрос","playlist_url"=>"$siteurl/index.php?do=search#POSTdo=search&subaction=search&search_start=0&full_search=0&result_from=1&story={search}"];

	$_MENU[]=["title"=>"Правообладателям","playlist_url"=>"$siteurl/index.php?do=static&page=copyrights"];
	//print_r($GLOBALS);	
	$np=explode("<span>", $GLOBALS["tpl"]->data["{pages}"]);
	$next_p=$np[count($np)-1];
	preg_match_all("/href=\"(.*?)\".*?>(.*?)</",$next_p,$arr);
	for($i=0;$i<count($_MENU);$i++){		
		echo ChArrToXML($_MENU[$i],"menu");

	}	
}







?>