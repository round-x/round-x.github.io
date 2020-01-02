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

$sql_select = "SELECT COUNT(*) FROM rubli_user WHERE referal='$id'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$refc = $row['COUNT(*)'];

$sql_select221 = "SELECT * FROM rubli_user WHERE referal='$id'";
$result221 = mysql_query($sql_select221);
$row221 = mysql_fetch_array($result221);
do
{
$sql_select423 = "SELECT SUM(suma) FROM rubli_payments WHERE user_id=".$row221['id'];
$result423 = mysql_query($sql_select423);
$row423 = mysql_fetch_array($result423);
	$sumapey = $sumapey + $row423['SUM(suma)'];
$sumref = $sumapey;
}
while($row221 = mysql_fetch_array($result221));
// массив для ответа
    $result = array(
	"success" => true,
    "referalsCount" => "$refc",
	"earnedByReferals" => "$sumref"
    );
echo json_encode($result);
}
?>