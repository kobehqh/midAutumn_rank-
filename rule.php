<?php
require_once "header.php";
//require_once "../../php/pvuvLog.class.php";

$conn = connect_to_db();

//$PKey = 'fzUnicom';//项目key值
//$splitFlag = false;//是否分表 true分表 false没有分表
//$pvuvLogObj = new pvuvLog($PKey, $splitFlag);
//$pvuvLogObj->visitWeixinID = $openid;//访问当前页面的用户
//$pvuvLogObj->kmResult = "";//页面中需要保存的数据;
//$url = $_SERVER['PHP_SELF'];
//$pageName = substr($url, strrpos($url, '/') + 1);
//$pvuvLogObj->urlID = $PKey . "_$pageName";//页面ID 项目key_页面名称

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>博饼规则</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="./css/rule.css">
    <script src="../../assets/js/responsive.js"></script>
</head>
<body>
<header>
    <div class="title">
        <img src="./img/title.png" alt="图片未正常显示">
        <p>佳节博礼，沃等你来</p>
    </div>
</header>
<div class="container">
    <h3>活动规则</h3>
    <ul >
        <li>
            <img src="./img/logo1.png" alt="">
            <div>
                <span>活动主题：中秋博饼</span>
            </div>

        </li>
        <li>
            <img src="./img/logo2.png" alt="">
            <div>
                <span>活动时间：2017年10月1日-10月8日</span>
            </div>


        </li>
        <li>
            <img src="./img/logo3.png" alt="">
            <div>
                <span>活动对象：福州联通手机用户</span>
            </div>
        </li>
        <li>
            <img src="./img/logo4.png" alt="">
            <div  class="common">
                <span>活动内容：每天博一博，积分赢大奖。</span>
            </div>
        </li>
        <li>
            <img src="./img/logo5.png" alt="">
            <div>
                <span>活动奖品：</span>
            </div>
        </li>
        <li style="margin-top: 5rem">
                <pre style="color: white;margin-top: -3rem;font-size: 110%;line-height:1.3rem">
         一等奖：150元话费（1名，第1名）
         二等奖：100元话费（3名，第2-4名）
         三等奖：50元话费（5名，第5-9名）
         幸运奖：10元话费（30名，第10-39名）
         参与奖：300M省内流量(第40-1040名)
                </pre>
        </li>
        <li>
            <img src="./img/logo6.png" alt="">
            <div  class="common">
                <span>活动规则：</span>
            </div>
        </li>
        <li style="margin-top: 10.3rem">
                <pre style="color: white;margin: -6.5rem 0 0 -0.2rem;font-size: 110%;line-height:1.3rem;text-align: justify">
 1、参与用户需先关注绑定官方微信公众号，用户每天
 有三次博饼机会，将活动分享可再得1次博饼机会（分
 享得博饼机会每天仅限1次）。每次博饼结果根据“积
 分说明”获得相应积分。
 2、本活动通过博饼积分高低进行排名，用户可至
 “积分排行榜”中查看自身博饼的积分详情。该页面
 中，将取参加活动用户积分前39名者进行排名显示
 （若积分相同，将按参加博饼时间先后进行调整）。
 3、活动奖品将于10月10号前在“我的奖品”页面进
 行公布。奖品赠送仅限福州本地联通手机用户并将在
 活动奖品公布后的3个工作日内送达，其中流量仅限当
 月使用，次月失效。
                </pre>
        </li>
        <li style="margin-top: 2.5rem">
            <img src="./img/logo7.png" alt="">
            <div  class="common">
                <span>积分说明如下：</span>
            </div>
        </li>
    </ul>
    <div id="table">
        <img src="./img/rule.png" alt="" style="width: 85%;display: block;margin: 1rem auto 0">
    </div>
</div>
<footer>
    <a href="./index.php">
        <span class="button">返回首页</span>
    </a>
</footer>



</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</html>
<?php
require_once "share.php";
//$pvuvLogObj->kmResult = "进入中秋博饼规则页面";
//$pvuvLogObj->saveLog();//保存数据
?>

