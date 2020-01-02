<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sql_select = "SELECT * FROM rubli_game_double ORDER BY `id` DESC LIMIT 6";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

do
{
	echo <<<HERE
		<hr>
	<div class='number $row[st]-light'>$row[num]</div>
HERE;

}
while($row = mysql_fetch_array($result));
?>