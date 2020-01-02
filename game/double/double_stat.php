<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sql_select = "SELECT * FROM rubli_double_users ORDER BY `suma` DESC";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{

		$sql_selectsa = "SELECT COUNT(*) FROM rubli_double_users";
$resultsa = mysql_query($sql_selectsa);
$rowsa = mysql_fetch_array($resultsa);
$count = $rowsa['COUNT(*)'];


if($rowsa['COUNT(*)'] == 0)
{
		echo <<<HERE

HERE;
}
else
{
	$sql_selects = "SELECT * FROM rubli_user WHERE id='".$row['user_id']."'";
$results = mysql_query($sql_selects);
$rows = mysql_fetch_array($results);
$login = ucfirst($rows['login']);
$bl = $row['suma'];	
$d = $row['type'];
setlocale(LC_MONETARY, 'en_US');
$sumaa = money_format('%i', $bl) . "\n";

if($d == "red")
{
$l = "Красное";
}
if($d == "black")
{
$l = "Чёрное";
}
if($d == "green")
{
$l = "Зелёное";
}
	$bet =  <<<HERE
	$bet
	<div class="loggg" data-reactid=".5.0">
                          <div class="name" data-reactid=".5.0.0">$login</div>
                          <div class="den1" data-reactid=".5.0.1">
                            <div class="denc" data-reactid=".5.0.1.0"><span data-reactid=".5.0.1.0.0">$sumaa DUB</span></div>
                            
                            
                            
                            <div class="money-mob money5000" style="top:6px;left:0px;" data-reactid=".5.0.1.1:3"></div>
                          </div>
                          <div class="koe" data-reactid=".5.0.2">
                            <div class="koef" data-reactid=".5.0.2.0" style="
    background-image: url(../img/koefic.png);
">
                              <div class="kk" data-reactid=".5.0.2.0.0">$l</div>
                            </div>
                          </div>
                          
                        </div>
HERE;
}
}
while($row = mysql_fetch_array($result));
			$sql_selectsa = "SELECT SUM(suma) FROM rubli_double_users";
$resultsa = mysql_query($sql_selectsa);
$rowsa = mysql_fetch_array($resultsa);
$sums = $rowsa['SUM(suma)'];
if($sums == "")
{
	$sums = "0";
}
setlocale(LC_MONETARY, 'en_US');
$sums = money_format('%i', $sums) . "\n";
// массив для ответа
    $result = array(
	"bet" => "$bet",
    "usr" => "$count",
	"sum" => "$sums"
    );
echo json_encode($result);
?>