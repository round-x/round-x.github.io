<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");

$sql_select = "SELECT * FROM rubli_upgrade ORDER BY `id` DESC LIMIT 10";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	$sql_select2 = "SELECT * FROM rubli_user WHERE id='".$row['user_id']."'";
$result2 = mysql_query($sql_select2);
$row2 = mysql_fetch_array($result2);
if($row2)
{	
$login = $row2['login'];
}
$login = mb_strtoupper($row2['login']);
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

	  <div class="bubalex">
  <div class="bbll1t" align="center">
    <div class="nikogo">
      <div class="logonik"></div>
      <div class="niklogo">$login</div>
    </div>
    <div style="clear:both;"></div>
    <div class="denr">
      <div class="money5000r" style="top:0px;right:30px;">
        <div class="denc2t"><span>$row[suma] DUB</span></div>
      </div>
    </div>
    <div class="bott"></div>
    <div class="denrbot">
      <div class="money5000r" style="top:0px;right:30px;">
        <div class="denc2tblue"><span>$row[win_suma] DUB</span></div>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div class="ulr">Шанс: $cha</div>
  </div>
</div>
	  
	  
HERE;
}
}
while($row = mysql_fetch_array($result));
?>