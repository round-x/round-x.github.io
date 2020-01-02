<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sum = $_POST["val"];
$chans = $_POST["ch"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$lvl = $row['lvl'];
$ids = $row['id'];
$bonus = $row['bonus'];
$balance = $row['balance'];
$balancenew = $balance;
if($chans == "1")
{
$arr = array("win", "lose"); //массив эл-ов
$per = array("50", "50");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$liks = "1.5";
$iks = $arr[$found];

}
if($chans == "2")
{
$arr = array("win", "lose"); //массив эл-ов
$per = array("39", "61");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$liks = "2";
$iks = $arr[$found];

}
if($chans == "3")
{
$arr = array("win", "lose"); //массив эл-ов
$per = array("25", "75");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$liks = "5";
$iks = $arr[$found];

}
if($chans == "4")
{
$arr = array("win", "lose"); //массив эл-ов
$per = array("10", "90");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$liks = "10";
$iks = $arr[$found];

}
if($chans == "5")
{
$arr = array("win", "lose"); //массив эл-ов
$per = array("4", "96");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$liks = "20";
$iks = $arr[$found];

}
$error = 0;
if($sum < 10)
{
$s = "error";
$error = 2;
$mess = "Ставки от 10 DUB!";
$go = "lose";
}
$sum = preg_replace("/[^0-9]/", '', $sum);
if($balance < $sum)
{
$s = "error";
$error = 1;
$mess = "Недостаточной средств!";
$go = "lose";
}
if($chans < 0)
{
$s = "error";
$error = 1;
$mess = "Ошибка!";
$go = "lose";
}
if($error == 0)
{
$s = "success";
$balancenew = $balance - $sum;
$un = "UPDATE `rubli_user` SET `balance` = '$balancenew' WHERE `rubli_user`.`id` = {$ids};";
     mysql_query($un);

if($iks == "win")
{
$sumas = $sum * $liks;
$balancenews = $balancenew + $sumas;
$un = "UPDATE `rubli_user` SET `balance` = '$balancenews' WHERE `rubli_user`.`id` = {$ids};";
     mysql_query($un);
$go = "win";
$ip = $_SERVER["REMOTE_ADDR"];
$stor = "INSERT INTO `rubli_upgrade` (`user_id`, `chans`, `suma`, `ip`, `type`, `win_suma`) VALUES ('$ids', '$liks', '$sum', '$ip', '$go', '$sumas')";
mysql_query($stor);
}
else
{
$go = "lose";
$sumas = "0";
$ip = $_SERVER["REMOTE_ADDR"];
$stor = "INSERT INTO `rubli_upgrade` (`user_id`, `chans`, `suma`, `ip`, `type`, `win_suma`) VALUES ('$ids', '$liks', '$sum', '$ip', '$go', '$sumas')";
mysql_query($stor);
}
}
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$balance = $row['balance'];
}
setlocale(LC_MONETARY, 'en_US');
$balance = money_format('%i', $balance) . "\n";
// массив для ответа
    $result = array(
	"success" => "$s",
    "messages" => "$mess",
    "go" => "$go",
    "balance" => "$balance"
    );
echo json_encode($result);
}
?>