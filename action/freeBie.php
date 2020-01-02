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
$bonus = $row['bonus'];
$balance = $row['balance'];
$balancenew = $balance;
$bonuss = $bonus - time();
$times = $bonuss / 60;
$times = round($times);
$bon = time() + 86400;
if(time() > $bonus)
{
	$balancenew = $balance + $lvl;
	$up = "UPDATE `rubli_user` SET `balance` = '$balancenew', `bonus` = '$bon' WHERE `rubli_user`.`id` = $id;";
	mysql_query($up) or die("Ошибка вставки" . mysql_error());
	$s = "true";
	$message = "На ваш счет зачисленно $lvl DUB!";
}
else
{
	$s = "false";
	$message = "Следующий вывод будет доступен через $times минут.";
}
setlocale(LC_MONETARY, 'en_US');
$balancenew = money_format('%i', $balancenew) . "\n";
// массив для ответа
    $result = array(
	"success" => "$s",
    "message" => "$message",
	"balance" => "$balancenew"
    );
echo json_encode($result);
}
?>