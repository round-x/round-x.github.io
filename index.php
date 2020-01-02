<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");
if($_COOKIE["sid"] == "")
{
	if($_GET["sid"] == "")
	{
	}
	else
	{
	$sids = $_GET["sid"]
?>
<script>
document.cookie = "sid=<?php echo $sids; ?>";
</script>
<?php
 echo '<meta http-equiv="refresh" content="0;URL=/">';
}
}
if($_GET['i'])
{
setcookie('ref', $_GET['i'], time()+36000);
}

if($_COOKIE["sid"] == "")
{
include(".//pages/no_auth.php");	
}
else
{
	$sql_select = "SELECT * FROM rubli_user WHERE sid='".$_COOKIE["sid"]."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$sid = $row["sid"];
	if($sid == $_COOKIE["sid"])
	{
	include(".//pages/auth.php");
	}
	else
	{
		setcookie('sid', "", time()-360000, '/');
		include(".//pages/no_auth.php");
	}
}


?>
<a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/15.png"></a>