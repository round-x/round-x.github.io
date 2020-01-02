<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$type = $_POST['type'];
$betSize = $_POST['betSize'];
$betPercent = $_POST['betPercent'];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$balance = $row['balance'];
if($balance < $betSize)
{
	echo "Недостаточно Средств!";
}
else
{
$rand = rand(0,999999);
$newbalic = $balance - $betSize;
		$update_sql1 = "Update rubli_user set balance='$newbalic' WHERE sid='$sid'";
    mysql_query($update_sql1) or die("" . mysql_error());
if($type == "max")
{
	$min = ($betPercent / 100) * 999999;
    $min = explode( '.', $min )[0];
	
	if($rand <= $min)
	{
		$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$balance = $row['balance'];
		$suma = round(((100 / $betPercent) * $betSize), 2);
		$newbalic = $balance + $suma;
		$update_sql1 = "Update rubli_user set balance='$newbalic' WHERE sid='$sid'";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Выиграли: $suma";
	}
	else
	{
		echo "Вы проиграли: $rand";
	}
}

if($type == "min")
{
		$max = (999999 - (($betPercent / 100) * 999999));
$max = explode( '.', $max )[0];
$max = round($max, -1);
	
	if($rand >= $max)
	{
				$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$balance = $row['balance'];
		$suma = round(((100 / $betPercent) * $betSize), 2);
		$newbalic = $balance + $suma;
		$update_sql1 = "Update rubli_user set balance='$newbalic' WHERE sid='$sid'";
    mysql_query($update_sql1) or die("" . mysql_error());
	echo "Выиграли: $suma";
	}
	else
	{
		echo "Вы проиграли: $rand";
	}
}
}
?>