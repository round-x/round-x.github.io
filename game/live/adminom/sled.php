<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$i = $_POST['type'];
$update_sql1 = "UPDATE `rubli_live_v` SET `active` = '0',`go` = '0'";
    mysql_query($update_sql1) or die("" . mysql_error());
	
	$update_sql12 = "UPDATE `rubli_live_v` SET `active` = '1', `data` = '".time()."', `go` = '0'  WHERE `rubli_live_v`.`v_num` = '".$i."';";
    mysql_query($update_sql12) or die("" . mysql_error());
echo "Успех";
?>