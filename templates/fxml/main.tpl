<?xml version="1.0"?>
<items>
<style>
	<cssid>
		<site>
			<background><![CDATA[url(http://wiki.forkplayer.tv/w/images/8/80/Spiderman.jpg)]]></background>
			<before><![CDATA[
				<div style="    position: absolute;    top: 573px;    left: 1190px;    width: 72px;    text-align: right;    background-color: #e2e2e2;    color: black;    border-radius: 3px;    padding: 1px 5px;    font-size: 50%;">
				{include file="engine/modules/fxml.php?fx=counterhits"}
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
<is_iptv>false</is_iptv>
<icon>{include file="engine/modules/fxml.php?fx=icon"}</icon>
{include file="engine/modules/fxml.php?fx=mainpage"} 
[/page-count][/aviable]
{content} 
</items>