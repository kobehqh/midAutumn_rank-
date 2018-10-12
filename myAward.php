<?php
require_once "header.php";
require_once "../../php/funcs.php";
require_once "../../php/pvuvLog.class.php";
global $CONFIG;

$conn = connect_to_db();

$PKey = 'fzUnicom';//项目key值
$splitFlag = false;//是否分表 true分表 false没有分表
$pvuvLogObj = new pvuvLog($PKey, $splitFlag);
$pvuvLogObj->visitWeixinID = $openid;//访问当前页面的用户
$pvuvLogObj->kmResult = "";//页面中需要保存的数据;
$url = $_SERVER['PHP_SELF'];
$pageName = substr($url, strrpos($url, '/') + 1);
$pvuvLogObj->urlID = $PKey . "_$pageName";//页面ID 项目key_页面名称

//引导关注绑定
$isFans = isWeixinFans($conn,$openid);
if (!$isFans) {
    $pvuvLogObj->kmResult = "非粉丝 引导关注";
    $pvuvLogObj->saveLog();//保存数据
    header("Location:".$CONFIG['UrlPrefix']."/userSide/followUs.php?campaigns=" . '福州联通博饼活动' . '&indexUrl=userSide/midAutumn/index.php');
    exit();
}
$bindInfo = getBindedMemberInfo($conn, $openid);//绑定
$phone = $bindInfo['phone'];
$isBind = $bindInfo['isbind'];
$isLocUnicom = $bindInfo['isLocUnicom'];
if ($isLocUnicom == '') {
    $isLocUnicom = 0;
}
//$isLocUnicom = 1;
if(!$isBind){
    header("Location:".$CONFIG['UrlPrefix']."/userSide/midAutumn/index.php");
    exit();
}

$userInfo = getWeixinUserInfo($conn, $openid);
$headImg = $userInfo['headimgurl'];
$nickName = $userInfo['nickname'];

$today = date('ymd');
$myPoint = "暂无";
$myRank = "暂无";
$tip = "";
if($isLocUnicom){
    $sql_myPoint = "SELECT * FROM `midAutumnActivity_rank` WHERE openid='$openid' LIMIT 1";
    $res_myPoint = mysql_query($sql_myPoint,$conn);
    if(is_resource($res_myPoint)&&mysql_num_rows($res_myPoint)>0){
        $row_myPoint = mysql_fetch_assoc($res_myPoint);
        $myPoint = $row_myPoint['points'];
        $updateTime = $row_myPoint['updateTime'];
        $sql_myRank = "SELECT count(*) as ct FROM `midAutumnActivity_rank` WHERE points>'$myPoint'";
        $res_myRank = mysql_query($sql_myRank,$conn);
        $row_myRank = mysql_fetch_assoc($res_myRank);
        $rank_diff = $row_myRank['ct'];
        $sql_myrank1 = "SELECT count(*) as ct FROM `midAutumnActivity_rank` WHERE points=$myPoint AND updateTime<'$updateTime'";
        $res_myrank1 = mysql_query($sql_myrank1,$conn);
        $row_myrank1 = mysql_fetch_assoc($res_myrank1);
        $rank_same = $row_myrank1['ct'];
        $myRank = $rank_diff+$rank_same+1;
    }else{
        $myPoint = "暂无";
        $myRank = "暂无";
    }

    if($myRank==1){
        $tip = "一等奖（150元话费）";
    }elseif($myRank<=4){
        $tip = "二等奖（100元话费）";
    }elseif($myRank<=9){
        $tip = "三等奖（50元话费）";
    }elseif($myRank<=39){
        $tip = "幸运奖（10元话费）";
    }elseif($myRank<=1040){
        $tip = "参与奖（300M省内流量）";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的奖品</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="./css/myAward.css">
    <script src="../../assets/js/responsive.js"></script>
    <style>
        .logo img{
            border-radius: 50%;
            width:4rem;
        }
    </style>
</head>
<body>
<header>
    <p>活动时间:2017年10月1日-10月8日</p>
</header>
<div class="container">
    <img src="./img/cloud.png" alt="" id="cloud">
    <div class="logo">
        <img src="<?php echo $headImg;?>" alt="头像加载失败">
    </div>
    <p><?php echo $nickName?></p>
<!--    <p>恭喜您！本次博饼活动中获得第xx名</p>-->
<!--    <p>获得奖品：x等奖（话费xx元）</p>--><!---->
<!--    <p>活动正在进行中，敬请期待开奖！</p>-->
<!--    <p></p>-->
<!--    <p>*所获奖品将在<span>3</span>个工作日内充值到<span>--><?php //echo $phone?><!--</span>手机号中</p>-->
    <?php if($isLocUnicom){
        if($today<=171009){
            echo "<p>活动正在进行中，将在10月10日开奖！</p>";
            echo "<p></p>";
        }else{
            if($myRank=="暂无"){
                echo "<p>您没有参与活动，没有奖品哦</p>";
                echo "<p></p>";
            }elseif($myRank<=1040){
                echo "<p>恭喜您！本次博饼活动中获得第{$myRank}名</p>";
                echo "<p>获得奖品：{$tip}</p>";
            }else{
                echo "<p>很可惜，本次活动您没有获奖</p>";
                echo "<p></p>";
            }
        }
        echo "<p>*所获奖品将在<span>3</span>个工作日内充值到<span>{$phone}</span>手机号中</p>";
    }else{
        echo "<p>您不是本次活动的目标用户</p>";
        echo "<p></p>";
        echo "<p></p>";
     }?>

</div>
<footer>
    <a href="./index.php">
        <span class="button">返回首页</span>
    </a>
</footer>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(function () {
        $("body").height($(window).height());
        $("#back").on("click",function () {
            window.location.href="./index.php";
        });
//        $("#cloud").on("click",function () {
//            alert($(window).width());
//        });
    })
</script>
</html>
<?php
require_once "share.php";
$pvuvLogObj->kmResult = "进入中秋博饼奖品页面：是否绑定{$isBind}是否本地联通{$isLocUnicom}";
$pvuvLogObj->saveLog();//保存数据
?>