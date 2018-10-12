<?php
require_once "../../php/funcs.php";
global $CONFIG;

$handler = new RedisSessionHandler(
    'FZUNICOM_AUTH_SESSION', $CONFIG['REDIS']['HOST'], $CONFIG['REDIS']['PORT']
);

require_once "../../php/session_common.php";
if (!session_id()) {
    session_start();
}
//unset($_SESSION['upbicycleOpenid']);exit;
$isWeixinBrowser = isWeixinBrowser();
if ($isWeixinBrowser = 0 ) {
    if (isset($_SESSION['fz_unicomOpenid']) && $_SESSION['fz_unicomOpenid'] != 'unknown') {
        $openid = $_SESSION['fz_unicomOpenid'];
    } else//微信授权oauth2授权，获取code
    {
        $_SESSION['referer']
            = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $redirectUrl = $CONFIG['UrlPrefix']
            . "/userSide/login.php";
        $redirectUrl = urlencode($redirectUrl);
        $baseUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            . $CONFIG['appid'] . "&response_type=code&scope=snsapi_base";
        $finalUrl = $baseUrl
            . "&redirect_uri=$redirectUrl&state=fzUnicom#wechat_redirect";
        header("Location:$finalUrl");
        exit();
    }
} else {
//   $openid = 'o3M-NuM50oFAMrwIjH_Q5iLmW1212IQ';
//    $openid = 'o3M-NuGQZI0K9ilC45UKtMLudXIM';
//    $openid = 'o3M-NuLtT0nhwGy35Qk__NSgnWbY';
    $openid = 'o3M-NuMJXgepDkhE-dJFabzUVbkI';
//    $openid = 'o3M-NuGnQ5VWDDZV5Die9oaFKHws';
//    $openid = 'o3M-NuOA2KvfJfNZ2FjA5WP-PKyI';
//    $openid = 'o3M-NuI7VKDiN86LA4_Wm3YgtReE';
//    echo "<h1>请从微信手机端访问，参与活动哦~</h1>";
//    exit();
}

?>
