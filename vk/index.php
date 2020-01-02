    <?php

   $client_id = '6287656'; // ID приложения
    $client_secret = 'VmxGF6gjADMPfUgaVNuV'; // Защищённый ключ
    $redirect_uri = 'http://rubli-k.com/vk.php'; // Адрес сайта

    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );

   $link =$url . '?' . urldecode(http_build_query($params));
   echo '<meta http-equiv="refresh" content="0;URL='.$link.'">';
?>