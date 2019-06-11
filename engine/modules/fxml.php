<?php
// FXML DLE wiki.forkplayer.tv https://github.com/alexkdpu/DLE_FXML

//Start Your Settings
$fxmlLogo="http://wiki.forkplayer.tv/w/images/b/bb/Emptydoc.png";  // Небольшой логотип сайта (~64px)

//End Your settings


if ( ! function_exists('is_https'))
{
    /**
     * Is HTTPS?
     *
     * Determines if the application is accessed via an encrypted
     * (HTTPS) connection.
     *
     * @return  bool
     */
    function is_https()
    {
        if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
        {
            return TRUE;
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
        {
            return TRUE;
        }
        elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
        {
            return TRUE;
        }

        return FALSE;
    }
}
if (!function_exists('json_last_error_msg')) {
        function json_last_error_msg() {
            static $ERRORS = array(
                JSON_ERROR_NONE => 'No error',
                JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
                JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
                JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
                JSON_ERROR_SYNTAX => 'Syntax error',
                JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
            );

            $error = json_last_error();
            return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
        }
    }
$siteurl = (is_https()?"https":"http")."://$_SERVER[HTTP_HOST]"; 

if(!function_exists("ChArrToXML")) {
	function ChArrToXML($ChArr,$tag="channel"){
		$res="";
		$res.= "\n<$tag>
		<logo_30x30><![CD"."ATA[".$ChArr["logo_30x30"]."]"."]></logo_30x30>
		<search_on><![CD"."ATA[".$ChArr["search_on"]."]"."]></search_on>
		<playlist_url><![CD"."ATA[".$ChArr["playlist_url"]."]"."]></playlist_url>
		<stream_url><![CD"."ATA[".$ChArr["stream_url"]."]"."]></stream_url>
		<description><![CD"."ATA[".$ChArr["description"]."]"."]></description>
		<title><![CD"."ATA[".$ChArr["title"]."]"."]></title>";
		if(is_array($ChArr["submenu"])) foreach($ChArr["submenu"] as $k=>$v) $res.= "\n <submenu>
		  <logo_30x30><![CD"."ATA[$v[logo_30x30]]"."]></logo_30x30>
		  <search_on><![CD"."ATA[$v[search_on]]"."]></search_on>
		  <presearch><![CD"."ATA[$v[presearch]]"."]></presearch>
		  <title><![CD"."ATA[$v[title]]"."]></title>
		  <playlist_url><![CD"."ATA[$v[playlist_url]]"."]></playlist_url>
		  <stream_url><![CD"."ATA[$v[stream_url]]"."]></stream_url>\n</submenu>";			
		$res.= "\n</$tag>";
		return $res;
	}
}
if(!function_exists("plToCh")) {
	$P=[];
	function plToCh($a,$p){
		if(is_array($a)){
			foreach($a as $k=>$v){
				if(is_array($v["folder"])){
					$p[]=["logo_30x30"=>getPoster(),"title"=>"$v[title]","description"=>"all_description","playlist_url"=>"submenu","submenu"=>plToCh($v["folder"])];
				}
				else{
					$p[]=["logo_30x30"=>getPoster(),"title"=>"$v[title]","stream_url"=>$v["file"]];
				}
			}
		}
		return $p;
	}
}
if(!function_exists("getPoster")) {
	function getPoster($image,$poster){
		global $siteurl;
		if(strpos($poster,"http")===0) return $poster;
		if(strpos($image,"http")===0) return $image;
		//exit;
		$poster=$GLOBALS["tpl"]->data["[xfvalue_poster]"];
		if(empty($poster)){
			$poster=$GLOBALS["images"][0];
		}
		if(empty($poster)){
			preg_match("/<img.*?src=['\"](.*?)['\"]/",$GLOBALS["row"]["full_story"],$a);
			if(isset($a[1])) $poster=$a[1];
		}
		if($poster=="[xfvalue_poster]") $poster="";
		if(empty($poster)) $poster="none";
		return $poster;
	}
}
if($fx=="icon") echo $fxmlLogo;
if($fx=="poster"){
	if(strpos($image,"/")===0||strpos($image,"{")===0) $image="{$siteurl}$image";
	if(strpos($poster,"/")===0||strpos($poster,"{")===0) $poster="{$siteurl}$poster";
	//print "newsid=$newsid poster=$poster image=$image ".strpos($image,'{');
	echo getPoster($image,$poster);
}
if($fx=="playlist"){
	//print_r($GLOBALS["row"]["short_story"]);exit;
	$pl=$GLOBALS["tpl"]->data["[xfvalue_playlist]"];
	if(!empty($pl)){
		$pl=preg_replace("/_(&#.*?;)_/","$1",$pl);
		$pl=html_entity_decode($pl); 
		$playlist=json_decode($pl,true);
		if(!is_array($playlist)) $_CH[]=["logo_30x30"=>"hidden","title"=>"Error json parse 'playlist': ".json_last_error_msg()];	
		
		$_CH=plToCh($playlist);
		for($i=0;$i<count($_CH);$i++){		
			echo ChArrToXML($_CH[$i]);
		}
	}
	
}
if($fx=="navigation"){
	//print_r($GLOBALS);	
	$np=explode("<span>", $GLOBALS["tpl"]->data["{pages}"]);
	$next_p=$np[count($np)-1];
	if($_GET["do"]=="search"){
		preg_match_all("/list_submit\((.*?)\).*?>(.*?)</",$next_p,$arr);
		print_r($arr);
		for($i=0;$i<count($arr[0]);$i++){
			$link="$siteurl/index.php?do=search#POSTdo=search&subaction=search&search_start=".$arr[1][$i]."&full_search=0&result_from=0&story={$_POST[story]}&p=".$arr[2][$i];
			$ch[]=[$link,$arr[2][$i]];
			if(1) {
				$_CH[]=["logo_30x30"=>"hidden","title"=>" &raquo; Страница ".$arr[2][$i],"playlist_url"=>$link];	
				if($i==0) $_CH[0]["title"]="&raquo; Следующая страница";
			}
		}
	}
	else{
		$_CH=[];
		preg_match_all("/href=\"(.*?)\".*?>(.*?)</",$next_p,$arr);
		for($i=0;$i<count($arr[0]);$i++){
			$arr[1][$i]=str_replace("&amp;","&",$arr[1][$i]);
			$ch[]=[$arr[1][$i]."&p=".$arr[2][$i],$arr[2][$i]];
			if(strpos($arr[2][$i],"http")===0) {
				$_CH[]=["logo_30x30"=>"hidden","title"=>" &raquo; Страница ".$arr[2][$i],"playlist_url"=>$arr[1][$i]."&p=".$arr[2][$i]];	
				if($i==0) $_CH[0]["title"]="&raquo; Следующая страница";
			}
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
	elseif(strpos($_SERVER["QUERY_STRING"],"box_mac=")===0) $ttl=$config["home_title"];
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
	$_MENU[]=["logo_30x30"=>"$fxmlLogo","title"=>$config["home_title"],"playlist_url"=>$siteurl];
	$_MENU[]=["title"=>"Поиск","search_on"=>"Введите поисковый запрос","playlist_url"=>"$siteurl/index.php?do=search#POSTdo=search&subaction=search&search_start=0&full_search=0&result_from=1&story={search}"];
	 
	$_MENU[]=["logo_30x30"=>"none","title"=>"Добав. в закладки","playlist_url"=>"AddFavorite(".$config["home_title"].",$fxmlLogo,$siteurl);"];	
	$_MENU[]=["logo_30x30"=>"none","title"=>"Добав. в Глоб. поиск","playlist_url"=>"AddSearch(".$config["home_title"].",$fxmlLogo,$siteurl/index.php?do=search#POSTdo=search&subaction=search&search_start=0&full_search=0&result_from=1&story={search});"];	 
		
		
	for($i=0;$i<count($_MENU);$i++){		
		echo ChArrToXML($_MENU[$i],"menu");
	}	
}






?>