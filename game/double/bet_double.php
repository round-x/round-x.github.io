<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sum = $_POST['sum'];
$types = $_POST['types'];
$sid = $_COOKIE["sid"];
$timedouble = "30";
$result2=mysql_query("SELECT * FROM `rubli_double` WHERE id='1'");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show = $row2["date"] - time();
$time_to_show = 0 - $time_to_show;
$time_to_show = $time_to_show - 30;
$timedouble = 0 - $time_to_show;
$zad = $row2["zad"];
$posit = $row2["position"];
}

$sql_selecta = "SELECT * FROM rubli_user WHERE sid='$sid'";
$resulta = mysql_query($sql_selecta);
$rowa = mysql_fetch_array($resulta);
if($rowa)
{
$balance = $rowa['balance'];
$ids = $rowa['id'];
$ban = $rowa['ban'];
}
if($sum < 1)
{
$error = "3";
	$mes = "Ставки от 1 DUB!";
}
$sum = preg_replace("/[^0-9]/", '', $sum);
if($timedouble <= 3)
{
	$error = "3";
	$mes = "Ставки закрыты Дождитесь следующей игры!";
}
if($balance < $sum)
{
	$error = "1";
	$mes = "Недостаточно средств!";
}
if($ban == 1)
{
	$error = "2";
	$mes = "Аккаунт Заблокирован!";
}
if($error == "")
{
	$banalnew = $balance - $sum;
$un = "UPDATE `rubli_user` SET `balance` = '$banalnew' WHERE `rubli_user`.`id` = {$ids};";
     mysql_query($un);
	 mysql_query("INSERT INTO `rubli_double_users` (`user_id`, `suma`, `type`) VALUES ('$ids', '$sum', '$types')");
	$mes = "Ставка принята!";
}
echo $mes;
?>