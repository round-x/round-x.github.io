<?
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$v = $_POST['type'];

$sql_select = "SELECT * FROM rubli_live_v WHERE `active`='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$v_num = $row['v_num'];

$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$id = $row['id'];

$sql_select = "SELECT COUNT(*) FROM rubli_live WHERE user_id='$id' AND nv='$v_num'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$con = $row['COUNT(*)'];
$timedouble = "15";
$result2=mysql_query("SELECT * FROM rubli_live_v WHERE `active`='1'");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show = $row2["data"] - time();
$time_to_show = 0 - $time_to_show;
$time_to_show = $time_to_show - 15;
$timedouble = 0 - $time_to_show;
}
if($timedouble <= 0)
{
	$timedouble = "0";
}
	if($timedouble > 0)
{
if($con == 0)
{
	if($timedouble > 0)
{
	$sql_select = "SELECT COUNT(*) FROM rubli_live WHERE user_id='$id' AND stat='lose'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$l = $row['COUNT(*)'];
	if($l == 0)
	{
mysql_query("INSERT INTO `rubli_live` (`user_id`, `nv`, `no`) VALUES ('$id', '$v_num', '$v')");
	echo "Ответ принят!";
	}
	else
	{
		echo "Вы выбыли!";
	}
}
else
{
	echo "Время вышло!";
}
}
}
else
{
	echo "Время вышло!";
}
?>