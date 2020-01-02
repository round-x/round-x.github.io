<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$lvl = $row['lvl'];
$ids = $row['id'];
}
$sql_select = "SELECT * FROM rubli_upgrade WHERE user_id='$ids' ORDER BY `id` DESC";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	if($row['chans'] == "1.5")
	{
		$cha = "ОЧЕНЬ ВЫСОКИЙ";
	}
	if($row['chans'] == "2")
	{
		$cha = "ВЫСОКИЙ";
	}
	if($row['chans'] == "5")
	{
		$cha = "СРЕДНИЙ";
	}
	if($row['chans'] == "10")
	{
		$cha = "НИЗКИЙ";
	}
	if($row['chans'] == "20")
	{
		$cha = "ТЫ ТОЧНО ЭТОГО ХОЧЕШЬ?";
	}
if($row['type'] == "win")
{
	echo <<<HERE
	
	<div class="loggg">
        <div class="ava5"><img src="/img/pal2.png" alt=""></div>
        <div class="textava">
          <div class="textava13">Вы смогли улучшить <b>$row[suma] DUB до $row[win_suma] DUB</b></div>
          <div class="textava23">Шанс: $cha</div>
        </div>
        <div class="den2new" align="right">
          <div class="money10bAd"><img style="top:0px;right:20px;" src="/img/5000.png" alt=""></div>
        </div>
        <div style="clear:both;"></div>
      </div>
	  
HERE;
}
else
{
	echo <<<HERE
	<div class="loggg1">
        <div class="ava5"><img src="/img/pal1.png" alt=""></div>
        <div class="textava">
          <div class="textava13">Вы не смогли улучшить <b>$row[suma] DUB</b></div>
          <div class="textava23">Шанс: $cha</div>
        </div>
        <div class="den2new" align="right">
          <div class="noboom"><img src="/img/noboom.png" alt=""></div>
        </div>
        <div style="clear:both;"></div>
      </div>
	  
HERE;
}
}
while($row = mysql_fetch_array($result));
?>