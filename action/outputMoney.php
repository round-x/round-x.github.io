<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$money = $_POST["money"];
$num = $_POST["num"];
$pass = $_POST["pass"];
$er = 0;
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$lvl = $row['lvl'];
$id = $row['id'];
$bonus = $row['bonus'];
$balance = $row['balance'];
$balancenew = $balance;
$sql_select = "SELECT COUNT(*) FROM rubli_user WHERE sid='$sid' AND pass='$pass'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($money == "")
{
	exit();
}
if($pass == "")
{
	exit();
}
if($num == "")
{
	exit();
}
if($row['COUNT(*)'] == 0)
{
$s = "error";
$message = "Неверный пароль!";
$er = 1;	
}
if($money < 150)
{
	$s = "error";
$message = "Вывод от 150 DUB!";
$er = 2;
}
if($balance < $money)
{
	
		$s = "error";
$message = "Недостаточно средств!";
$er = 3;
}
$datas = date("d.m.Y");
	$datass = date("H:i:s");
	$dt = "$datas $datass";
	$ip = $_SERVER["REMOTE_ADDR"];
	
if($er == 0)
{
	$s = "success";
	$balancenew = $balance - $money;
	$up = "UPDATE `rubli_user` SET `balance` = '$balancenew' WHERE `rubli_user`.`id` = $id;";
	mysql_query($up) or die("Ошибка вставки" . mysql_error());
	$in = "INSERT INTO `rubli_payout` (`user_id`, `suma`, `qiwi`, `status`, `data`, `ip`) VALUES ('$id', '$money', '$num', 'В пути 24ч', '$dt', '$ip')";
	mysql_query($in) or die("Ошибка вставки" . mysql_error());
}
// массив для ответа
    $result = array(
	"success" => "$s",
    "mess" => "$message",
	"balance" => "$balancenew",
	"time" => "$dt"
    );
echo json_encode($result);
}
?>