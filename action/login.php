<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
$login = $_POST['login'];
$pass = $_POST['pass'];
$login = trim($login, "'");
$pass = trim($pass, "'");

$login = trim($login, '"');
$pass = trim($pass, '"');

$login = trim($login, " ");
$pass = trim($pass, " ");

$login = trim($login, "=");
$pass = trim($pass, "=");

$login = trim($login, "'OR");
$pass = trim($pass, "'OR");

$login = trim($login, '"OR');
$pass = trim($pass, '"OR');

	$sql_select = "SELECT * FROM rubli_user WHERE login='".$login."' AND pass='".$pass."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$sid = $row["sid"];
$ban = $row["ban"];
if($sid == "")
{
	$fa = "error";
	$mess = "Неверый Логин или Пароль.";
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$mess"
    );
}
else
{
	if($ban == 0)
	{
	$fa = "success";
	setcookie('sid', $sid, time()+360000, '/');
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'sid' => "$sid",
	'error' => "$mess"
    );
	}
	else
	{
		$fa = "error";
	$mess = "Аккаунт заблокирован.";
	// массив для ответа
    $result = array(
    'success' => "$fa",
	'error' => "$messя"
    );
	}
}
	echo json_encode($result);

?>