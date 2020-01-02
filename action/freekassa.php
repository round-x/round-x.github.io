<?php
$post = $_POST['amount'];
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$user_id = $row['id'];
$podpis = md5('77658:'.$post.':5arzoz5q:'. $user_id);
$url = "http://www.free-kassa.ru/merchant/cash.php?m=77658&oa={$post}&o={$user_id}&s=".$podpis."";
echo "<meta http-equiv='refresh' content='0;URL=$url'>";
?>