    <?php
require($_SERVER['DOCUMENT_ROOT']."/inc/bd.php");
require($_SERVER['DOCUMENT_ROOT']."/setting.php");

    $client_id = '6287656'; // ID приложения
    $client_secret = 'VmxGF6gjADMPfUgaVNuV'; // Защищённый ключ
    $redirect_uri = 'http://rubli-k.com/vk.php'; // Адрес сайта

    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );
	if (isset($_GET['code'])) {
    $result = false;
    $params = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri
    );

    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
    if (isset($token['access_token'])) {
        $params = array(
            'uids'         => $token['user_id'],
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token'],
			'v'         => '3'
        );

        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['uid'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }

    if ($result) {
		$sql_select = "SELECT COUNT(*) FROM rubli_user WHERE vk_id='".$userInfo['uid']."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$count = $row['COUNT(*)'];
}
if($count == 1)
{
			$sql_selects = "SELECT * FROM rubli_user WHERE vk_id='".$userInfo['uid']."'";
$results = mysql_query($sql_selects);
$rows = mysql_fetch_array($results);
if($rows)
{
	$sid = $rows['sid'];
	setcookie('sid', $sid, time()+36000, '/');
}
}
else
{
			$chars3="qazxswedcvfrtgnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
$max3=32; 
$size3=StrLen($chars3)-1; 
$passwords3=null; 
while($max3--) 
$hash.=$chars3[rand(32,$size3)];
$ip = $_SERVER["REMOTE_ADDR"];
$ref = $_COOKIE["ref"];
$datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";
$login = $userInfo['first_name']." ".$userInfo['last_name'];
	mysql_query("INSERT INTO `rubli_user` (`vk_id`,`login`, `pass`, `sid`, `ip`, `ip_reg`, `email`, `balance`, `referal`, `data`) VALUES ('".$userInfo['uid']."', '$login', 'NO PASS', '$hash', '$ip', '$ip', 'NO EMAIL', '0.00','$ref', '$data')");
	setcookie('sid', $sid, time()+36000, '/');
		
}
$login = $userInfo['first_name']." ".$userInfo['last_name'];
$update_sql1 = "INSERT INTO `rubli_chat` (`user_id`, `message`, `data`) VALUES ('0', 'Новый участник: $login', '".time()."')";
mysql_query($update_sql1) or die("" . mysql_error());	

setcookie('name', "1111ddd", time()+3600, '~/', './');
     echo '<meta http-equiv="refresh" content="0;URL=/?sid='.$sid.'">';  
    }
}
?>