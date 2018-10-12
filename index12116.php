<?php
require_once "header.php";

$conn = connect_to_db();
$queryNum=0;
$limit=3;
$addNum=0;
$canJoin = 0;
$today = date('Y-m-d');
$sql_check = "SELECT * FROM `midAutumnActivity_user` WHERE openid='$openid' and createTime LIKE '$today%'";
$res_check = mysql_query($sql_check,$conn);
if(is_resource($res_check)&&mysql_num_rows($res_check)>0){
    $queryNum = mysql_num_rows($res_check);
}
$sql_share = "SELECT * FROM `midAutumnActivity_user` WHERE openid='$openid' and shareTime LIKE '$today%' LIMIT 1";
$res_share = mysql_query($sql_share,$conn);
if(is_resource($res_share)&&mysql_num_rows($res_share)>0){
    $addNum=1;
}
if($queryNum<($limit+$addNum)){
    $canJoin=1;
}
$leftNum = $limit+$addNum-$queryNum;

$sql_point = "";
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>中秋博饼</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- 公用css -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/weui/1.1.0/style/weui.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/css/jquery-weui.min.css">
    <link rel="stylesheet" href="../../assets/css/reset.css"/>
    <link rel="stylesheet" href="./css/index12116.css"/>

    <!-- 公用js -->
    <script src="../../assets/js/responsive.js"></script>
    <script src='../../assets/js/jquery-2.1.3.min.js'></script>
    <style>

    </style>
</head>
<body>
<div class="main">
    <div class="moon">
        <img src="./img/title.png">
        <p>活动时间：2017年10月1日-10月8日</p>
    </div>
    <div class="wan">
        <img src="./img/wan.png">
    </div>
    <div class="action">
        <input type="button" value="开始博饼" id="begin"/>
        <p>您的博饼次数还剩【<?php echo $queryNum;?>】次</p>
    </div>
    <div class="bottom">
        <span class="rule">【博饼规则】</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="myAward">【我的奖品】</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="rank">【积分排行榜】</span>
    </div>
    <div class="pop-alert pop">
        <p class="p1">恭喜您</p>
        <p class="p2">获得<text>状元</text>!</p>
        <p class="p34" id="p3">本次博饼获得积分<text></text>分</p>
        <p class="p34" id="p4">目前您的博饼总积分为<text></text>分</p>
        <div class="act"><input type="button" value="查看排行榜" id="toRank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="再博一次" id="again"></div>
        <a class="close"><img src="./img/fault.png" width="10%"></a>
    </div>
    <audio id="bgMusic" hidden>
        <source = src="./music/roll_dice.mp3" type="audio/mp3">
        <source = src="./music/roll_dice.ogg" type="audio/ogg">
    </audio>
</div>
</body>
<script src="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/js/jquery-weui.min.js"></script>
<script>
$(function () {
    $(".main").height($(window).height());
    var audio = document.getElementById("bgMusic");
    var canJoin =<?php echo $canJoin;?>;
    var time=0;
    var t;
    var click = true;
    $("#begin").on("click",function () {
        if(click){
            click=false;
            if(canJoin){
                audio.play();
                $.showLoading();
                $.ajax({
                    url: "apiLottery.php",
                    type: 'post',
                    async: true,
                    dataType: "json",
                    data: {
                        time: "time",
                        token: "token",
                        action: "roll"
                    },
                    success: function (data) {
                        if(data.err==0){
                            $.hideLoading();
//                            console.log(data);
//                            console.log("结果"+data.msg['name']);
//                            console.log("获得积分："+data.msg['point']);
//                            for(i=0;i<6;i++){
//                                console.log(data.msg['lotArr'][i]);
//                            }
//                            $.alert("恭喜您获得"+data.msg['name'],function () {
//                                window.location.href="./index.php?rand="+<?php //echo rand();?>//;
//                            });
                            if(data.msg['name']=="没中"){
                                var pointNew = data.msg['point'];
                                $(".p1").html("好可惜");
                                $(".pop text").html("");
                                $(".p2").html("您没摇中");
                                $("#p3 text").html("");
                                $("#p4 text").html("");
                            }
                            $(".pop-alert").bPopup({
                                positionStyle: 'fixed',
                                closeClass: 'close'
                            });
                        }else{
                            $.hideLoading();
                            $.alert(data.msg);
                        }

                    }

                })
            }else if(canJoin==0){
                $.alert("今日次数已经用完了哦");
                click = true;
            }
        }
    });

})
</script>
</html>
<?php
require_once "share.php";
?>