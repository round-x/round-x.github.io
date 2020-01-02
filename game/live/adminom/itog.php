<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$i = $_POST['type'];
$update_sql1 = "UPDATE `rubli_live_v` SET `active` = '1',`go` = '1'  WHERE `rubli_live_v`.`v_num` = '".$i."';";
    mysql_query($update_sql1) or die("" . mysql_error());
echo "Успех";
?>