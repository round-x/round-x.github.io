<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$promo = $_POST["promo"];
	if(empty($promo))  
{	
$error = 1;
$fa = "error";
$mess = "Введите Промокод";
}
$sql_select = "SELECT * FROM rubli_promo WHERE promo='$promo'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$active = $row['active'];
$activelimit = $row['activelimit'];
$idactive = $row['idactive'];
$summa = $row['summa'];
$sql_select1 = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
if($row1)
{	
$user_id = $row1['id'];
$balance = $row1['balance'];
}
if($active >= $activelimit)
{
		$error = 3;
$fa = "error";
$mess = "Количество активаций исчерпано";
}
	if (preg_match("/$user_id /",$idactive))  {	
	$error = 3;
$fa = "error";
$mess = "Вы уже активировали данный промокод!";
}
}
else
{
	$error = 2;
$fa = "error";
$mess = "Промокод не существует";
}
if($error == 0)
{
	  $balancenew = $balance + $summa;
	  $activeupd = $active + "1";
      $idupd = "$user_id $idactive";
	  $update_sql = "Update rubli_promo set idactive='$idupd',active='$activeupd' WHERE promo='$promo'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
	  $update_sql1 = "Update rubli_user set balance='$balancenew' WHERE sid='$sid'";
      mysql_query($update_sql1) or die("" . mysql_error());
setlocale(LC_MONETARY, 'en_US');
$summa = money_format('%i', $summa) . "\n";
$mess = "Промокод на сумму: {$summa} DUB Активирован!";
	  
}
// массив для ответа
echo '<div align="center" class="error"><span>'.$mess.'</span></div>';
?>