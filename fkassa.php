<?php
$merchant_id = "77658";
$merchant_secret = "5arzoz5q";
 
    $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

    if ($sign != $_REQUEST['SIGN']) {
    die('wrong sign');
    }

$label = $_GET['intid'];
$idmoney = $_GET['MERCHANT_ORDER_ID'];
$data = date('d-m-Y H:i:s');
$yandex = $_GET['P_PHONE'];
$suma = $_GET['AMOUNT'];
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
		if (is_numeric($idmoney))
		{
		$sql_select = "SELECT * FROM rubli_user WHERE id='$idmoney'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$balance = $row['balance'];
$ref = $row['referal'];
}
	$sumaref = ($suma / 100) * 10;
if($ref >= 1)
{	
			$sql_select = "SELECT * FROM rubli_user WHERE id='$ref'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$balanceref = $row['balance'];
$balancerefs = $balanceref + $sumaref;
$update_sql1 = "Update rubli_user set balance='$balancerefs' WHERE id='$ref'";
    mysql_query($update_sql1) or die("" . mysql_error());
}
} 
if($depobon == 0){
$balancenew = $row['balance'] + $suma;
}else{
$bonusuma = ($suma / 100) * 10;
$balancenew = $row['balance'] + $suma + $bonusuma;
} 
$update_sql1 = "Update rubli_user set balance='$balancenew' WHERE id='$idmoney'";
    mysql_query($update_sql1) or die("" . mysql_error());
			$insert_sql1 = "
			INSERT INTO `rubli_payments` (`user_id`, `suma`, `data`, `qiwi`, `transaction`) 
			VALUES ('{$idmoney}', '{$suma}', '{$data}', '{$yandex}', '{$label}')
			";
mysql_query($insert_sql1);
} 

    die('YES');
?>