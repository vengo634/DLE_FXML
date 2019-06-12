[xfgiven_moonwalk]    
<channel>
    <logo_30x30><![CDATA[{include file="engine/modules/fxml.php?fx=poster"}]]></logo_30x30>
	
    <stream_url><![CDATA[[xfvalue_moonwalk]]]></stream_url>
    <title><![CDATA[{title} - moonwalk]]></title>
    <description><![CDATA[
		<style>
	a{
	color:inherit;
	}
	</style>
	<div id="poster" style="float:left;padding:4px;	background-color:#EEEEEE;margin:0px 13px 1px 0px;">
	<img src="{include file="engine/modules/fxml.php?fx=poster&poster=[xfvalue_poster]&image={image-1}&newsid={news-id}"}" style="width:180px;float:left;" />
	</div>
	<span style="color:#3090F0">{title}</span><br>
	Категория: {category}<br>
	{full-story limit="800"}

]]></description>
</channel>
[/xfgiven_moonwalk] 
[xfgiven_hdgo] 
<channel>
    <logo_30x30><![CDATA[{include file="engine/modules/fxml.php?fx=poster"}]]></logo_30x30>
	<menu_url>hdgo</menu_url>
    <stream_url><![CDATA[[xfvalue_hdgo]]]></stream_url>
    <title><![CDATA[{title} - hdgo]]></title>
    <description><![CDATA[
			<style> 
	a{
	color:inherit;
	}
	</style> 
	<div id="poster" style="float:left;padding:4px;	background-color:#EEEEEE;margin:0px 13px 1px 0px;">
	<img src="{include file="engine/modules/fxml.php?fx=poster&poster=[xfvalue_poster]&image={image-1}&newsid={news-id}"}" style="width:180px;float:left;" />
	</div>
	<span style="color:#3090F0">{title}</span><br>
	Категория: {category}<br>
	{full-story limit="800"}

]]></description>
</channel>
[/xfgiven_hdgo] 
 
[xfgiven_playlist]
     <all_description><![CDATA[
			<style>
	a{
	color:inherit;
	}
	</style>
	<div id="poster" style="float:left;padding:4px;	background-color:#EEEEEE;margin:0px 13px 1px 0px;">
	<img src="{include file="engine/modules/fxml.php?fx=poster&poster=[xfvalue_poster]&image={image-1}&newsid={news-id}"}" style="width:180px;float:left;" />
	</div>
	<span style="color:#3090F0">{title}</span><br>
	Категория: {category}<br>
	{full-story limit="800"}

]]></all_description>
{include file="engine/modules/fxml.php?fx=playlist&newsid={news-id}&title={title}"}
[/xfgiven_playlist] 