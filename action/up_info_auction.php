<?php
$winid = "0";
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
$somisiya = 10;

$result=mysql_query("SELECT * FROM `rubli_auction` ORDER BY `date` DESC LIMIT 1");
while ($row=mysql_fetch_array($result))
{

$userid = $row["user_id"];
}
$sql_select54351 = "SELECT SUM(stavka) FROM rubli_auction";
$result14324234 = mysql_query($sql_select54351);
$row7567 = mysql_fetch_array($result14324234);
$bank = $row7567['SUM(stavka)'];

///
$sql_sel = "SELECT Max(id) FROM rubli_auction";
$resu = mysql_query($sql_sel);
$row7 = mysql_fetch_array($resu);
$usergames = $row7['Max(id)'];
///
if(empty($bank))
{
	$bank = "0";
}
$result1=mysql_query("SELECT * FROM `p_win4` WHERE id=5");
while ($row1=mysql_fetch_array($result1))
{
$stavka = $row1["win_id"];
}

$result=mysql_query("SELECT * FROM rubli_user WHERE id= $userid");
while ($row=mysql_fetch_array($result))
{
$vkid = $row["vk_id"];
$user_login = $row["login"];
$balance = $row["balance"];
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
//$betsum = "1";//сумма ставки
$idvk = "$vk_id";// вк последней ставки
$namebet = "$user_login";//имя последней ставки
//$time_to_show = time();//таймер дописать!
$proc = "60";
$result2=mysql_query("SELECT * FROM `rubli_auction` ORDER BY `date` DESC LIMIT 1");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show2 = $row2["date"] - time();
$time_to_show2 = 0 - $time_to_show2;
$time_to_show2 = $time_to_show2 - 60;
$time_to_show2 = 0 - $time_to_show2;

}
if($time_to_show2 >= 0)
{
$game = "0";	
$winid = "0";
}
else
{
	$winid = "1";
	$banknew = $bank;
	if($usergames > 1)
	{
	$formula = $bank/100 * $somisiya;

$banknew = $bank - $formula;
	}
	
		$data_stavki = time();
	$insert_sql = "INSERT INTO rubli_auction_game (user_id,summawin, date) VALUES('{$userid}', '{$banknew}', '{$data_stavki}')";
mysql_query($insert_sql);

$sql_select = "SELECT * FROM rubli_user WHERE id='$userid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$logina = $row['login'];
}

$update_sql1 = "INSERT INTO `rubli_chat` (`user_id`, `message`, `data`) VALUES ('0', 'Аукцион на сумму: $banknew DUB Завершен<br>Победитель: $logina', '".time()."')";
mysql_query($update_sql1) or die("" . mysql_error());	

$balanceusernew = $balance + $banknew;
	$update_sql13 = "Update rubli_user set balance='$balanceusernew' WHERE id='$userid'";
    mysql_query($update_sql13) or die("" . mysql_error());
	
	$host = 'localhost';
$user = 'sashokox_basa';
$password = 'sashokox_basa';
$database = 'sashokox_basa'; 
    $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link)); 
    $query ="TRUNCATE TABLE `rubli_auction`";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    mysqli_close($link);
	
	 $update_sql1 = "Update p_win4 set win_id='no' WHERE id='5'";
      mysql_query($update_sql1) or die("" . mysql_error());
	$time_to_show = "0";
	$game = "1";
	$data_roulette = date("Y-m-d H:i:s");
}
if($game == "0")
{
$result2=mysql_query("SELECT * FROM `rubli_auction` ORDER BY `date` DESC LIMIT 1");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show = $row2["date"] - time();
$time_to_show = 0 - $time_to_show;
$time_to_show = $time_to_show - 60;
$time_to_show = 0 - $time_to_show;
}
}
$data_roulette = time();
$formula_progressa = floor(($time_to_show * 100)/$proc);
$progress_bar = '<div style="color: #fff;">Подождите...<br>Осталось '.$time_to_show.' сек.</div><progress title="осталось '.$time_to_show.' сек." value="'.$formula_progressa.'" max="100"></progress>';
// массив для ответа
$result = array(
	'bank' => "$bank",
	'betsum' => "$betsum",
	'stavka' => "$stavka",
	'timer' => "$progress_bar",
	'namebet' => "$namebet",
);
echo json_encode($result);

?>