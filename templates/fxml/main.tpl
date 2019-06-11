<?xml version="1.0"?>
<items>
<style>
	<cssid>
		<site>
			<background><![CDATA[url(http://wiki.forkplayer.tv/w/images/8/80/Spiderman.jpg)]]></background>
			<before><![CDATA[
				<div style='position:absolute;top:86%;left:91%;z-index:1;'>
				<img border="0" src="http://www.warlog.ru/counter/?i=3003" alt="счетчик посещений" title="счетчик посещений" />
				</div>
			]]>
			</before>
		</site>
		<menu>
			<background>none #585858</background>
			<color>#f3f3f3</color>
		</menu>
		<infoList>
			<background>none #363636</background>
			<color>#f3f3f3</color>
		</infoList>
	</cssid>
</style>
<style>
	<channels>
		<parent>
			<default>
				<background>none #2b2b2b</background>
				<color>#e0dfdc</color>
			</default>
			<selected>
				<background>none #2b2b2b</background>
				<color>#DD4B39</color>
			</selected>
		</parent>
	</channels>	
</style> 
<allvast><![CDATA[http://xml.forkplayer.tv/?do=/plugin&id=advert&mode=vast]]></allvast>
{include file="engine/modules/fxml.php?fx=title"}
{include file="engine/modules/fxml.php?fx=menu"}
[aviable=main][page-count=1] 
<icon>{include file="engine/modules/fxml.php?fx=icon"}</icon>
{include file="engine/modules/fxml.php?fx=mainpage"} 
[/page-count][/aviable]
{content} 
</items>