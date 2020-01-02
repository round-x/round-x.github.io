<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
setlocale(LC_MONETARY, 'en_US');
$summa = money_format('%i', $row['balance']) . "\n";
echo $summa;
?>