<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
$login = $_POST['login'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$passre = $_POST['passre'];
$erro = 0;
	$sql_select = "SELECT * FROM rubli_user WHERE login='".$login."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$sid = $row["sid"];
if(!$sid == "")
{
	$erro = "3";
	$fa = "error";
	$mess = "Такой логин уже существует!";
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
	$dllogin = strlen($login);
if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login)) 
{
	$mess = "Введите корректный логин";
	$fa = "error";
	$erro = 3;
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
} 
if($dllogin < 4 || $dllogin > 15)
{
	$erro = 4;
	$fa = "error";
	$mess = 'Логин от 4 до 15 символов';
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
if($login == "")
{
	$erro = 4;
	$fa = "error";
	$mess = 'Логин от 4 до 15 символов';
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
if($email == "")
{
	$erro = 4;
	$fa = "error";
	$mess = 'Введите Email';
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
if($pass == "")
{
	$erro = 4;
	$fa = "error";
	$mess = 'Введите Пароль';
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
	$sql_select = "SELECT * FROM rubli_user WHERE email='".$email."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$sids = $row["sid"];
if(!$sids == "")
{
	$erro = "2";
	$fa = "error";
	$mess = "Такой Email уже существует!";
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
if($erro == 0)
{
		$chars3="qazxswedcvfrtgnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
$max3=32; 
$size3=StrLen($chars3)-1; 
$passwords3=null; 
while($max3--) 
$hash.=$chars3[rand(32,$size3)];
$ip = $_SERVER["REMOTE_ADDR"];
$ref = $_COOKIE["ref"];
$datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";

	mysql_query("INSERT INTO `rubli_user` (`login`, `pass`, `sid`, `ip`, `ip_reg`, `email`, `balance`, `referal`, `data`) VALUES ('$login', '$pass', '$hash', '$ip', '$ip', '$email', '0.00','$ref', '$data')");
$fa = "success";
	setcookie('sid', $sid, time()+360000, '/');
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'sid' => "$hash",
	'error' => "$mess"
    );
}
	echo json_encode($result);

?>