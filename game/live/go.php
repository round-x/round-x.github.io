<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$id = $row['id'];
$sql_select = "SELECT * FROM rubli_live_v WHERE `active`='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$v_num = $row['v_num'];
$v_text = $row['v_text'];
$v1_text = $row['v1_text'];
$v2_text = $row['v2_text'];
$v3_text = $row['v3_text'];
$go = $row['go'];
$otvet = $row['otvet'];
$sql_select = "SELECT * FROM rubli_live WHERE user_id='$id' AND nv='$v_num'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$no = $row['no'];
$nv = $row['nv'];
if($go == 1)
{
	$sql_select = "SELECT * FROM rubli_live WHERE nv='".$v_num."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	if($otvet == $row['no'])
	{
		$s = "win";
	}
	else
	{
		$s = "lose";
	}
$update_sql1 = "UPDATE `rubli_live` SET `stat` = '$s' WHERE `rubli_live`.`id` = '".$row['id']."'";
      mysql_query($update_sql1) or die("" . mysql_error());
}
while($row = mysql_fetch_array($result));
}
if(1 == 1)
{
if($no == 1)
{
	$otv1 = <<<HERE
style="
    background: yellow;
"
HERE;
}
if($no == 2)
{
	$otv2 = <<<HERE
style="
    background: yellow;
"
HERE;
}
if($no == 3)
{
	$otv3 = <<<HERE
style="
    background: yellow;
"
HERE;
}
}
if($go == 1)
{
	if($otvet == 1)
{
	$otv1s = <<<HERE
style="
    background: lime;
"
HERE;
}
if($otvet == 2)
{
	$otv2s = <<<HERE
style="
    background: lime;
"
HERE;
}
if($otvet == 3)
{
	$otv3s = <<<HERE
style="
    background: lime;
"
HERE;
}
}
$timedouble = "15";
mysql_connect("localhost","allabo8v_poligon","allabo8v_poligon");
mysql_select_db("allabo8v_poligon");
$result2=mysql_query("SELECT * FROM rubli_live_v WHERE `active`='1'");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show = $row2["data"] - time();
$time_to_show = 0 - $time_to_show;
$time_to_show = $time_to_show - 15;
$timedouble = 0 - $time_to_show;
}
if($timedouble <= 0)
{
	$timedouble = "Время вышло!";
}
echo <<<HERE

<div id="qn-" class="my-3 p-3 bg-white rounded box-shadow" style="display: block;">
<h5 class="border-bottom border-gray pb-2 mb-0">Время: <span>$timedouble</span> <i class="fa fa-clock-o" aria-hidden="true"></i></h5>
 <h5 class="border-bottom border-gray pb-2 mb-0">
<span class="text-muted">#$v_num из 12</span> $v_text</h5>
<div id="v1" $otv1s $otv1 onclick="live('1')" class="media text-muted pt-3">
<div class="media-body pb-3 mb-0 small lh-125">
<span class="d-block"><span class="text-muted">$v1_text</span></span>
</div>
</div>
<div id="v2" $otv2s $otv2 onclick="live('2')" class="media text-muted pt-3">
<div class="media-body pb-3 mb-0 small lh-125">
<span class="d-block"> <span class="text-muted">$v2_text</span></span>
</div>
</div>
<div id="v3" $otv3s $otv3 onclick="live('3')" class="media text-muted pt-3">
<div class="media-body pb-3 mb-0 small lh-125">
<span class="text-left"> <span class="text-muted">$v3_text</span></span>
</div>
</div>
</div>
</div>

HERE;
?>