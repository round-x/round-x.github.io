<?php
require("../inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$prava = $row['prava'];
	$login = $row['login'];
}
if($prava == 1)
{

$rz = $_POST['rz'];
if($rz == "balic")
{
	$types = $_POST['types'];
	$num = $_POST['num'];
	$update_sql1 = "UPDATE `rubli_user` SET `balance` = '$num' WHERE `id` = $types";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Выдано $num Руб|ID: $types";
}
if($rz == "banoff")
{
	$types = $_POST['types'];
	$num = $_POST['num'];
	$update_sql1 = "UPDATE `rubli_user` SET `ban` = '0' WHERE `id` = $types";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Разбанен|ID: $types";
}
if($rz == "banon")
{
	$types = $_POST['types'];
	$num = $_POST['num'];
	$update_sql1 = "UPDATE `rubli_user` SET `ban` = '1' WHERE `id` = $types";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Забанен|ID: $types";
}
if($rz == "payout")
{
	$types = $_POST['types'];
	$id = $_POST['id'];
	$update_sql1 = "UPDATE `rubli_payout` SET `status` = '$types' WHERE `id`='$id'";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Успешно ! статус: $types";
}
if($rz == "crash")
{
	echo "Х Крашнул на: 0.00х";
}
if($rz == "podkr")
{
	$num = $_POST['num'];
	echo "Максимальный Х: $num";
}
if($rz == "pda")
{
$type = $_POST['type'];
$p = 0;
$pds = "Выключена!";
if($type == "off")
{
	$p = 0;
	$pds = "Выключена!";
}
if($type == "on")
{
	$p = 1;
	$pds = "Включена!";
}
$update_sql1 = "UPDATE `rvuti_admin` SET `pd` = '$p' WHERE `id` = 1";
    mysql_query($update_sql1) or die("" . mysql_error());
echo "Подкрутка $pds";
}
}
else
{
	include("/error404.php");
}
?>