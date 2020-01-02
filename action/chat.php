<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$pravas = $row['prava'];
}
$sql_select = "SELECT * FROM rubli_chat ORDER BY `id` DESC LIMIT 20";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
if($row['user_id'] == 0)
{
	$login = "<span style='color:#346dff;'> ИНФОБОТ</span>";
}
else
{
	$sql_selecta = "SELECT * FROM rubli_user WHERE id='".$row['user_id']."'";
$resulta = mysql_query($sql_selecta);
$rowa = mysql_fetch_array($resulta);
$login = $rowa['login'];
$prava = $rowa['prava'];
$lvl = $rowa['lvl'];
if($pravas == 1)
{
	$adm = <<<HERE
	<span style="color:#6d4ec7;" onclick="alert('У вас нету возможности банить чат!')" data-reactid=".2.0:0.1.0.1">Забанить</span>
HERE;
}
	$sql_selectaa = "SELECT SUM(suma) FROM rubli_payments WHERE user_id='".$row['user_id']."'";
$resultaa = mysql_query($sql_selectaa);
$rowaa = mysql_fetch_array($resultaa);
$sumss = $rowaa['SUM(suma)'];
if($sumss >= 1 && $sumss < 10)
{
	$login = '<span style="color:White;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($sumss >= 10 && $sumss < 50)
{
	$login = '<span style="color:White;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($sumss >= 50 && $sumss < 100)
{
	$login = '<span style="color:blue;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($sumss >= 100 && $sumss < 500)
{
	$login = '<span style="color:lime;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($sumss >= 500 && $sumss < 1000)
{
	$login = '<span style="color:#05fdff;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($sumss >= 1000)
{
	$login = '<span style="color:yellow;"> '.$login.'</span></span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1">['.$lvl.']</span>';
}
if($prava == 2)
{
	$login = $login.' </span><span style="color:#6d4ec7;" data-reactid=".2.0:0.1.0.1"><img src="https://s3.amazonaws.com/mlg-gamebattles-production/assets/arenas/teams/16/296/675/avlg726242301691467213145.png" style="height: 30;width: 30;"></span>';

}
if($prava == 1)
{
	$login = "<span style='color:red;'> $login </span>";

}

}
echo <<<HERE
<div class="bl" data-reactid=".2.0:0">
                        <div class="bl1" data-reactid=".2.0:0.0"></div>
                        <div class="bl2" data-reactid=".2.0:0.1">
                          <div class="title" data-reactid=".2.0:0.1.0"><span data-reactid=".2.0:0.1.0.0">$login $adm</div>
                          <div class="text" data-reactid=".2.0:0.1.1">$row[message]</div>
                        </div>
                      </div>
HERE;
}
while($row = mysql_fetch_array($result));

?> 