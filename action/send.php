<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$mess = $_POST["message"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$id = $row['id'];
$prava = $row['prava'];
if($id >= 1)
{
	if($prava == 1 || $prava == 2)
	{
		
	}
	else
	{
		$mess = htmlspecialchars($mess, ENT_QUOTES);

	}
$update_sql1 = "INSERT INTO `rubli_chat` (`user_id`, `message`, `data`) VALUES ('$id', '$mess', '".time()."')";
mysql_query($update_sql1) or die("" . mysql_error());
}
?>