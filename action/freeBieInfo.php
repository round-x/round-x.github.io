<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$lvl = $row['lvl'];
$id = $row['id'];
$sql_select = "SELECT SUM(suma) FROM rubli_payments WHERE user_id='$id'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$summa = $row['SUM(suma)'];
if($lvl == 0)
{
	$endxp = "10";
}
if($lvl == 1)
{
	$endxp = "500";
}
if($lvl == 2)
{
	$endxp = "4000";
}
if($lvl == 3)
{
	$endxp = "6000";
}
if($lvl == 4)
{
	$endxp = "8000";
}
if($lvl == 5)
{
	$endxp = "10000";
}
if($lvl == 6)
{
	$endxp = "12000";
}
if($lvl == 7)
{
	$endxp = "14000";
}
if($lvl == 8)
{
	$endxp = "16000";
}
if($lvl == 9)
{
	$endxp = "18000";
}
if($lvl == 10)
{
	$endxp = "20000";
}
	if($summa > 0 && $summa < 10)
	{
		$uplevel = 0;
	}
	if($summa > 10 && $summa < 500)
	{
		$uplevel = 1;
	}
	if($summa > 500 && $summa < 4000)
	{
		$uplevel = 2;
	}
	if($summa > 4000 && $summa < 6000)
	{
		$uplevel = 3;
	}
	if($summa > 6000 && $summa < 8000)
	{
		$uplevel = 4;
	}
	if($summa > 8000 && $summa < 10000)
	{
		$uplevel = 5;
	}
	if($summa > 10000 && $summa < 12000)
	{
		$uplevel = 6;
	}
	if($summa > 12000 && $summa < 14000)
	{
		$uplevel = 7;
	}
	if($summa > 14000 && $summa < 18000)
	{
		$uplevel = 8;
	}
	if($summa > 18000 && $summa < 22000)
	{
		$uplevel = 9;
	}
	if($summa > 22000 && $summa < 24000)
	{
		$uplevel = 10;
	}
	$up = "UPDATE `rubli_user` SET `lvl` = '$uplevel' WHERE `rubli_user`.`id` = $id;";
	mysql_query($up) or die("Ошибка вставки" . mysql_error());
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$lvl = $row['lvl'];
$id = $row['id'];
$sql_select = "SELECT SUM(suma) FROM rubli_payments WHERE user_id='$id'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$summa = $row['SUM(suma)'];
if($lvl == 0)
{
	$endxp = "10";
}
if($lvl == 1)
{
	$endxp = "500";
}
if($lvl == 2)
{
	$endxp = "4000";
}
if($lvl == 3)
{
	$endxp = "6000";
}
if($lvl == 4)
{
	$endxp = "8000";
}
if($lvl == 5)
{
	$endxp = "10000";
}
if($lvl == 6)
{
	$endxp = "12000";
}
if($lvl == 7)
{
	$endxp = "14000";
}
if($lvl == 8)
{
	$endxp = "16000";
}
if($lvl == 9)
{
	$endxp = "18000";
}
if($lvl == 10)
{
	$endxp = "20000";
}
if($summa >= 20000)
{
	$endxp = "0";
}
// массив для ответа
    $result = array(
	"currentLevel" => "$lvl",
    "currentBonus" => "$lvl",
	"currentDeposit" => "$summa",
	"nextLevelDeposit" => "$endxp"
    );
}
echo json_encode($result);
}
?>