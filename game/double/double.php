<?php
session_start();
$timedouble = "15";
mysql_connect("localhost","sashokox_basa","sashokox_basa");
mysql_select_db("sashokox_basa");
$result2=mysql_query("SELECT * FROM `rubli_double` WHERE id='1'");
while ($row2=mysql_fetch_array($result2))
{
$time_to_show = $row2["date"] - time();
$time_to_show = 0 - $time_to_show;
$time_to_show = $time_to_show - 15;
$timedouble = 0 - $time_to_show;
$zad = $row2["zad"];
$posit = $row2["position"];
}
if($timedouble <= "0")
{
	$timedouble = "0";
}
$result2=mysql_query("SELECT * FROM `rubli_game_double`");
while ($row2=mysql_fetch_array($result2))
{
$posit1 = $row2["position"];
}
$lol = "НАЧ";
	$ff="<canvas id='game_double' style='margin: 0px 0px; display: block; transform: rotate(".$posit1."deg); transform-origin: 50% 50% 0px;' width='300' height='300'></canvas>";
if($_SESSION['dabltoc'] == "")
{
 $_SESSION['dabltoc'] = "$posit1";
}
if($_SESSION['dabltoc'] >= 360)
{
	 $_SESSION['dabltoc'] = "0";
}
if($timedouble <= "0")
{
	$dabl1 = $_SESSION['dabltoc'];
if($dabl1 == $posit)
{
	//начало
	$l14 = rand(1, 16);
$arr = array($l14); //массив эл-ов
$per = array(100);//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$random_elem = $arr[$found];

if($random_elem == 1)
{
	$st = "red";
	$elem = "350";
}
if($random_elem == 2)
{
	$elem = "325";
	$st = "black";
}
if($random_elem == 3)
{
	$st = "green";
	$elem = "305";
}
if($random_elem == 4)
{
	$st = "black";
	$elem = "285";
}
if($random_elem == 5)
{
	$st = "red";
	$elem = "260";
}
if($random_elem == 6)
{
	$st = "black";
	$elem = "235";
}
if($random_elem == 7)
{
	$st = "red";
	$elem = "215";
}
if($random_elem == 8)
{
	$st = "black";
	$elem = "195";
}
if($random_elem == 9)
{
	$st = "red";
	$elem = "170";
}
if($random_elem == 10)
{
	$st = "black";
	$elem = "145";
}
if($random_elem == 11)
{
	$st = "black";
	$st = "red";
	$elem = "125";
}
if($random_elem == 12)
{
	$st = "black";
	$elem = "100";
}
if($random_elem == 13)
{
	$st = "red";
	$elem = "80";
}
if($random_elem == 14)
{
	$st = "black";
	$elem = "55";
}
if($random_elem == 15)
{
	$st = "red";
	$elem = "35";
}
if($random_elem == 16)
{
	$st = "black";
	$elem = "10";
}
mysql_connect("localhost","sashokox_basa","sashokox_basa");
mysql_select_db("sashokox_basa");
$result2=mysql_query("SELECT * FROM rubli_double WHERE id='1'");
while ($row2=mysql_fetch_array($result2))
{
$posit = $row2["position"];
}
if($posit == 350)
{
	$random_elem = 1;
	$st = "red";
}
if($posit == 325)
{
	$random_elem = 2;
	$st = "black";
}
if($posit == 305)
{
	$random_elem = 3;
	$st = "green";
}
if($posit == 285)
{
	$random_elem = 4;
	$st = "black";
}
if($posit == 260)
{
	$random_elem = 5;
	$st = "red";
}
if($posit == 235)
{
	$random_elem = 6;
	$st = "black";
}
if($posit == 215)
{
	$random_elem = 7;
	$st = "red";
}
if($posit == 195)
{
	$random_elem = 8;
	$st = "black";
}
if($posit == 170)
{
	$random_elem = 9;
	$st = "red";
}
if($posit == 145)
{
	$random_elem = 10;
	$st = "black";
}
if($posit == 125)
{
	$random_elem = 11;
	$st = "red";
}
if($posit == 100)
{
	$random_elem = 12;
	$st = "black";
}
if($posit == 80)
{
	$random_elem = 13;
	$st = "red";
}
if($posit == 55)
{
	$random_elem = 14;
	$st = "black";
}
if($posit == 35)
{
	$random_elem = 15;
	$st = "red";
}
if($posit == 10)
{
	$random_elem = 16;
	$st = "black";
}
//выгрузка в историю
$insert_sql = "INSERT INTO rubli_game_double (num, st, position) VALUES('{$random_elem}', '{$st}', '{$posit}')";
     mysql_query($insert_sql);
	 //
	$l14 = rand(1, 16);
$arr = array($l14); //массив эл-ов
$per = array(100);//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$random_elem = $arr[$found];

if($random_elem == 1)
{
	$st2 = "red";
	$elem = "350";
}
if($random_elem == 2)
{
	$elem = "325";
	$st2 = "black";
}
if($random_elem == 3)
{
	$st2 = "green";
	$elem = "305";
}
if($random_elem == 4)
{
	$st2 = "black";
	$elem = "285";
}
if($random_elem == 5)
{
	$st2 = "red";
	$elem = "260";
}
if($random_elem == 6)
{
	$st2 = "black";
	$elem = "235";
}
if($random_elem == 7)
{
	$st2 = "red";
	$elem = "215";
}
if($random_elem == 8)
{
	$st2 = "black";
	$elem = "195";
}
if($random_elem == 9)
{
	$st2 = "red";
	$elem = "170";
}
if($random_elem == 10)
{
	$st2 = "black";
	$elem = "145";
}
if($random_elem == 11)
{
	$st2 = "red";
	$elem = "125";
}
if($random_elem == 12)
{
	$st2 = "black";
	$elem = "100";
}
if($random_elem == 13)
{
	$st2 = "red";
	$elem = "80";
}
if($random_elem == 14)
{
	$st2 = "black";
	$elem = "55";
}
if($random_elem == 15)
{
	$st2 = "red";
	$elem = "35";
}
if($random_elem == 16)
{
	$st2 = "black";
	$elem = "10";
}
      require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
	  $sql_selectq = "SELECT * FROM rubli_double WHERE id=1";
$resultq = mysql_query($sql_selectq);
$rowq = mysql_fetch_array($resultq);
$posq = $rowq['zad'];
	$dt = time();
	$update_sql1 = "Update rubli_double set date='$dt',position='$elem', zad='$st2', cisl='$random_elem'WHERE id='1'";
		$data_roulette = date("Y-m-d H:i:s");
      mysql_query($update_sql1) or die("" . mysql_error());
	  $_SESSION['set1'] = "";	  
//Вин пользователей


	  //Вин пользователей
      require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
$sql_select = "SELECT * FROM rubli_double_users";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
	if($row["type"] == "black")
	{
		$umn = 2;
	}
	if($row["type"] == "red")
	{
		$umn = 2;
	}
	if($row["type"] == "green")
	{
		$umn = 7;
	}
	
	if($row['type'] == $posq)
	{
		$sql_selecta = "SELECT * FROM rubli_user WHERE id='".$row['user_id']."'";
$resulta = mysql_query($sql_selecta);
$rowa = mysql_fetch_array($resulta);
$balances = $rowa['balance'];
$ids = $rowa['id'];

$balan = $row['suma'] * $umn;
$banalnew = $balances + $balan;
$un = "UPDATE `rubli_user` SET `balance` = '$banalnew' WHERE `rubli_user`.`id` = ".$row['user_id'].";";
     mysql_query($un);
	}
	$del = "DELETE FROM `rubli_double_users` WHERE `rubli_double_users`.`id` = '".$row['id']."'";
     mysql_query($del);
}
while($row = mysql_fetch_array($result));


	  //Вин пользователей
	  
//конец
	$ff="<canvas id='game_double' style='margin: 0px 0px; display: block; transform: rotate(".$posit."deg); transform-origin: 50% 50% 0px;' width='300' height='300'></canvas>";
$timedouble = "0";
	$lol = "даа";

exit();
}
else
{
	$dabl1 = $_SESSION['dabltoc'];
	$dabl = $dabl1 + 5;
	$ff="<canvas id='game_double' style='margin: 0px 0px; display: block; transform: rotate(".$dabl1."deg); transform-origin: 50% 50% 0px;' width='300' height='300'></canvas>";
$lol = "НЕТ";
}
}
$result = array(
	"timer" => $timedouble,
	"progresdouble" => "$ff",
	"progresst" => $posit1
);
echo json_encode($result);
$_SESSION['dabltoc'] = "$dabl";
?>