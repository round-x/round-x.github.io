<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
session_start();
$dats = $_SESSION['vremyaauc'];
if($dats == "")
{
}
else
{
	$vr = $dats + 2;
$tim = time();
if($tim < $vr) {	
$error = 7;
echo '<span style="color: red;">Подождите 2 секунды!</span>';
}
};
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$id = $row['id'];

$sql_select1 = "SELECT SUM(stavka) FROM rubli_auction";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
$bank = $row1['SUM(stavka)'];

$result=mysql_query("SELECT * FROM rubli_user WHERE id= $id");
while ($row=mysql_fetch_array($result))
{
$vk_id = $row["vk_id"];
$user_login = $row["login"];
$balance = $row["balance"];
}
$result=mysql_query("SELECT * FROM `rubli_auction` ORDER BY `date` DESC LIMIT 1");
while ($row=mysql_fetch_array($result))
{
$userid = $row["user_id"];

}
$result=mysql_query("SELECT * FROM `rubli_auction` WHERE user_id='$id'");
while ($row=mysql_fetch_array($result))
{
	$stv = $row["stavka"];

}
$betsum = "1";
if($bank <= "10" && $bank >= "10")
{
	$betsum = "1";
}
if($bank >= "11" && $bank < "20")
{
	$betsum = "2";
}
if($bank >= "21" && $bank < "50")
{
	$betsum = "5";
}
if($bank >= "51" && $bank < "100")
{
	$betsum = "10";
}
if($bank >= "101" && $bank < "500")
{
	$betsum = "50";
}
if($bank >= "501")
{
	$betsum = "100";
}
if(preg_match("/[^0-9]/",$betsum)) 
{		
$error = 2;
echo '<span style="color: red;">Сумма указана неверно!</span>';
}
elseif($balance <$betsum) {	
$error = 3;
echo '<span style="color: red;">На балансе не достаточно средств для Ставки!</span>';
}
if($error == 0)
{
if($balance < $betsum)
{	
	$error = 3;
	echo '<span style="color: red;">На балансе не достаточно средств для Ставки!</span>';     
}
{
	if($tim < $vr) 
	{
		echo '<span style="color: red;">Подождите 2 секунды!</span>';
	}
	else
	{
	 $update_sql1 = "Update p_win4 set win_id='yes' WHERE id='5'";
      mysql_query($update_sql1) or die("" . mysql_error());
	  
	//$update_sql1 = "Update p_users set user_ball='{$user_ball}' WHERE user_id='$id'";
   // mysql_query($update_sql1) or die("" . mysql_error());
	  $balanceusernew = $balance - $betsum;
	$update_sql1 = "Update rubli_user set balance='$balanceusernew' WHERE id='$id'";
    mysql_query($update_sql1) or die("" . mysql_error());

		$data_roulette = time();
	 $sel = "SELECT * FROM rubli_auction WHERE user_id='$id'";
 $res = mysql_query($sel); 
 $num = mysql_num_rows($res);
 
 if($num == 0) {
	 $sels = "SELECT * FROM rubli_auction";
 $ress = mysql_query($sels); 
 $nums = mysql_num_rows($ress);
	 if($nums == 0)
	 {
		 $update_sql1 = "INSERT INTO `rubli_chat` (`user_id`, `message`, `data`) VALUES ('0', 'Аукцион начат!<br>Удачной игры!', '".time()."')";
mysql_query($update_sql1) or die("" . mysql_error());
	 }
    $insert_sql = "INSERT INTO rubli_auction (user_id, stavka, date) VALUES('{$id}', '{$betsum}', '{$data_roulette}')";
mysql_query($insert_sql);

 
 }
 else 
 {
	 	 $sels = "SELECT * FROM rubli_auction";
 $ress = mysql_query($sels); 
 $nums = mysql_num_rows($ress);
	 if($nums == 0)
	 {
		 $update_sql1 = "INSERT INTO `rubli_chat` (`user_id`, `message`, `data`) VALUES ('0', 'Аукцион начат!<br>Удачной игры!', '".time()."')";
mysql_query($update_sql1) or die("" . mysql_error());
	 }
	 $betsum1 = $betsum + $stv;
	 $update_sql22 = "Update rubli_auction set date='$data_roulette', stavka='$betsum1' WHERE user_id='$id'";
    mysql_query($update_sql22) or die("" . mysql_error());
	 
	 }
 
 
echo '<span style="color: Lime;">Ставка принята!</span>';
}
}
}
$_SESSION['vremyaauc'] = time();
?>