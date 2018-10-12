<?php
require_once "../../php/funcs.php";
global $CONFIG;


$handler = new RedisSessionHandler(
    'PTUNICOM_AUTH_SESSION', $CONFIG['REDIS']['HOST'], $CONFIG['REDIS']['PORT']
);
require_once "../../php/session_common.php";
if (!session_id()) {
    session_start();
}
//unset($_SESSION['upbicycleOpenid']);exit;
$isWeixinBrowser = isWeixinBrowser();
if ($isWeixinBrowser == 1) {
    if (isset($_SESSION['pt_unicomOpenid']) &&  $_SESSION['pt_unicomOpenid'] != 'unknown') {
        $openid = $_SESSION['pt_unicomOpenid'];
    } else//微信授权oauth2授权，获取code
    {
        $_SESSION['referer']
            = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $redirectUrl = $CONFIG['UrlPrefix']
            . "userSide/login.php";
        $redirectUrl = urlencode($redirectUrl);
        $baseUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            . $CONFIG['appid'] . "&response_type=code&scope=snsapi_base";
        $finalUrl = $baseUrl
            . "&redirect_uri=$redirectUrl&state=ptUnicom#wechat_redirect";
        header("Location:$finalUrl");
        exit();
    }
} else {
   $openid = 'ogMUqwjoPldiRCl2DtCoZK2b0ehY';
//  echo "<h1>请从微信手机端访问，参与活动哦~</h1>";
  //exit();
}

?>
