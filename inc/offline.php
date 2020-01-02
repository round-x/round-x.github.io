<?php
require("bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");

require_once 'qiwi.php';
$qiwi = new Qiwi("$qiwi", "$token");
$getHistory = $qiwi->getPaymentsHistory([
	'rows' => '1'
]);
$transaction = $getHistory['data'][0]['trmTxnId'];
$date = $getHistory['data'][0]['date'];
$type = $getHistory['data'][0]['type'];
$suma = $getHistory['data'][0]['sum']['amount'];
$qiwis = $getHistory['data'][0]['view']['account'];
$coment = $getHistory['data'][0]['comment'];
if($type == "IN")
{

						 $sql_select1 = "SELECT COUNT(*) FROM `rvuti_payments` WHERE transaction='{$transaction}'";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
if($row1['COUNT(*)'] == 0)
{
	$idmoney = str_replace("-$payname", '', $coment);
		if (is_numeric($idmoney))
		{
									 $sql_select1 = "SELECT COUNT(*) FROM `rvuti_payments` WHERE transaction='{$transaction}'";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
if($row1['COUNT(*)'] == 0)
{
		$sql_select = "SELECT * FROM rvuti_users WHERE id='$idmoney'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$balance = $row['balance'];
$ref = $row['referer'];
}
	$sumaref = ($suma / 100) * 10;
if($ref >= 1)
{	
			$sql_select = "SELECT * FROM rvuti_users WHERE id='$ref'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$balanceref = $row['balance'];
$balancerefs = $balanceref + $sumaref;
$update_sql1 = "Update rvuti_users set balance='$balancerefs' WHERE id='$ref'";
    mysql_query($update_sql1) or die("" . mysql_error());
}
}
$balancenew = $balance + $suma;
$update_sql1 = "Update rvuti_users set balance='$balancenew' WHERE id='$idmoney'";
    mysql_query($update_sql1) or die("" . mysql_error());
			$insert_sql1 = "
			INSERT INTO `rvuti_payments` (`user_id`, `suma`, `data`, `qiwi`, `transaction`) 
			VALUES ('{$idmoney}', '{$suma}', '{$date}', '{$qiwis}', '{$transaction}')
			";
mysql_query($insert_sql1);
}

}
}
}

//qiwi///
?>