<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");


$sid = $_COOKIE["sid"];
$sql_select = "SELECT * FROM rubli_user WHERE sid='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$prava = $row['prava'];
	$login = $row['login'];
}
if($prava == 2)
{
?>
<html xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Админка Викторины</title>
<link href="../files/st.css" rel="stylesheet" type="text/css">
<script src="../files/js.cookie.js" type="text/javascript"></script>



<style type="text/css">

html, body, #container {height: 100%; background-color:#fbfbfb;}
body > #container { height: auto; min-height: 100%; background-color:#fbfbfb; } 

#footer {
clear: both;
position: relative;
z-index: 10;
height: 3em;
margin-top: -3em;
} 

#content { padding-bottom: 3em; } 

</style>
</head>

<body>
<div id="container">
<div id="content">


<table style="margin-top:20px;" align="center" width="884" border="0" cellspacing="0" cellpadding="0">



</table>
<table align="center" style="border: 1px solid #cccccc; border-radius: 4px; padding: 10px; margin-top: 5px; font-size: 15px; background-color: #fff;" width="875" class="tbl" cellpadding="5" cellspacing="0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<tbody><tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Номер Вопроса</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Вопрос</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Ответ</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">#1</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">#2</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">#3</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Итоги</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">След</td></tr>
<script>
function itog(type)
{
			 $.ajax({
        type: "POST",
        url: "..//game/live/adminom/itog.php",
        data: {type:type}
    }).done(function( result )
        {
			alert(result);	
        });
}
function sled(type)
{
			 $.ajax({
        type: "POST",
        url: "..//game/live/adminom/sled.php",
        data: {type:type}
    }).done(function( result )
        {
			alert(result);	
        });
}
</script>
<?php
$sql_select = "SELECT * FROM rubli_live_v ORDER BY `id`";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
		$sql_select1 = "SELECT * FROM rubli_user WHERE id=".$row['user_id'];
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
$login = ucfirst($row1['login']);
$s = $row['v_num'] + 1;
	echo <<<HERE
	<tr>
	<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="50"><a ">$row[v_num]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="200"><a> $row[v_text]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><a href="/admin/index.php?act=payouts&payid=$row[id]">$row[otvet]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><b><a href="/admin/index.php?act=user&id=$row[user_id]">$row[v1_text]</a></b></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><a href="/admin/index.php?act=payouts&payid=$row[id]">$row[v2_text]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><a href="/admin/index.php?act=payouts&payid=$row[id]">$row[v3_text]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><a onclick="itog('$row[v_num]')">Итоги $row[v_num]</a></td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300"><a onclick="sled('$row[v_num]')">Запустить $row[v_num] вопрос</a></td>
</tr>
HERE;
}
while($row = mysql_fetch_array($result));
?>
</tbody></table>

<?php
}
?>