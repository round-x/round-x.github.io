<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");

$sid = $_COOKIE["sid"];
$time = time() + 5;
$ip = $_SERVER["REMOTE_ADDR"];
$update_sql1 = "Update rubli_user set online='1', online_time='$time', ip='$ip' WHERE sid='$sid'";
    mysql_query($update_sql1) or die("" . mysql_error());

$sql_select = "SELECT COUNT(*) FROM rubli_user WHERE online='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$count = $row['COUNT(*)'];
echo $count;
?>