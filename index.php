<?php
require_once "header.php";
require_once "../../php/funcs.php";
require_once "../../php/pvuvLog.class.php";
global $CONFIG;

$conn = connect_to_db();
//此处开始设置监控访问日志需要的监控代码----------------------------------------
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
$isBind = $bindInfo['isbind'];
$isLocUnicom = $bindInfo['isLocUnicom'];
if ($isLocUnicom == '') {
    $isLocUnicom = 0;
}
//$isLocUnicom = 1;

//$phone = $bindInfo['phone'];
//判断机会
$queryNum=0;
$limit=3;
$addNum=0;
$canJoin = 0;
$leftNum = 0;
$myPoint = 0;
$msg = "";
$today = date('Y-m-d');
if($isLocUnicom){
    $sql_check = "SELECT * FROM `midAutumnActivity_user` WHERE openid='$openid' and createTime LIKE '$today%'";
    $res_check = mysql_query($sql_check,$conn);
    if(is_resource($res_check)&&mysql_num_rows($res_check)>0){
        $queryNum = mysql_num_rows($res_check);
    }
    $sql_share = "SELECT * FROM `midAutumnActivity_shareLog` WHERE openid='$openid' and shareTime LIKE '$today%' LIMIT 1";
    $res_share = mysql_query($sql_share,$conn);
    if(is_resource($res_share)&&mysql_num_rows($res_share)>0){
        $addNum=1;
    }
    if($queryNum<($limit+$addNum)){
        $canJoin=1;
    }
    $leftNum = $limit+$addNum-$queryNum;//剩余机会
    $leftNum = $leftNum>=0? $leftNum:0;
    $sql_point = "SELECT * FROM `midAutumnActivity_rank` WHERE openid = '$openid'";//当前总积分
    $res_point = mysql_query($sql_point,$conn);
    if(is_resource($res_point)&&mysql_num_rows($res_point)>0){
        $row_point = mysql_fetch_assoc($res_point);
        $myPoint = $row_point['points'];
    }
    if($canJoin==0){
        $msg = "抱歉，您今日博饼机会已经用完了哦,明天再来吧";
        if($addNum==0){
            $msg = "抱歉，您今日博饼机会已经用完了,分享可再得一次机会哦";
        }
    }

}

$today_ymd = date('ymd');
$early = 0;
$late = 0;
if($today_ymd<180901){
    $early = 1;
}elseif($today_ymd>181008){
    $late = 1;
}

//奖励初始化

?>
    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>中秋博饼</title>
        <meta name="format-detection" content="telephone=no,email=no"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <!-- 公用css -->
        <link rel="stylesheet" href="http://cdn.bootcss.com/weui/1.1.0/style/weui.min.css">
        <link rel="stylesheet" href="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/css/jquery-weui.min.css">
        <link rel="stylesheet" href="../../assets/css/reset.css"/>
        <link rel="stylesheet/less" href="css/style_white.less"/>
<!--        <link rel="stylesheet" href="css/style.css"/>-->
        <!-- 公用js -->
        <script src="../../assets/js/responsive.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--        <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>-->
        <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
        <?php
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){

        }else{ ?>
            <style>
                *{
                    -webkit-backface-visibility: hidden;
                    -moz-backface-visibility: hidden;
                    -ms-backface-visibility: hidden;
                    backface-visibility: hidden;

                    -webkit-perspective: 1000;
                    -moz-perspective: 1000;
                    -ms-perspective: 1000;
                    perspective: 1000;
                }
            </style>

        <?php } ?>
        <style>
            body{
                background: #f2e4db;
            }
            .pop-alert {
                background: url("./img/result.png") no-repeat;
                background-size: contain;
                background-position: center;
                width: 22rem;
                height: 20rem;
                text-align: center;
                box-sizing: border-box;
            }

            .pop {
                display: none;
            }

            .p1, .p2 {
                letter-spacing: 0.2rem;
                font-size: 1.2rem;
                color: #E32A32;
            }

            .p1 {
                margin-top: 6rem;
            }

            .p34 {
                font-size: 0.9rem;
                color: #9B9798;
                padding: 0 5rem;
            }

            .p2 text {
                color: #E9BC38;
            }

            .act {
                margin-top: 1rem;
            }

            .pop input {
                width: 7rem;
                height: 2.5rem;
                line-height: 2.5rem;
                border-radius: 5px;
                font-size: 1rem;
            }

            #toRank {
                border: 0.5px solid #E9BC38;
                background-color: white;
                color: #DE4F55;
            }

            #again {
                background-color: #DE4F55;
                color: white;
                border: 0;
            }

            .close1 {
                display: block;
                margin: 3rem auto 0;
                text-align: center;
            }

            .close1 img {
                width: 2rem;
            }
            .index-btn p{
                color: #7C6F66;
                font-size: 1rem;
                margin-top: 0.2rem;
            }
        </style>
    </head>
    <body>
    <div class="index-container">
        <img  style="width: 20%" src="img/logo-unicom.png" alt="">
        <p class="index-time" style="padding-top: 38%">活动时间：2017年10月1日-10月8日</p>
        <div class="index-bowl">
            <img class="bowl-item1" src="img/index-bowl1.png" alt="">
            <div class="index" style="display: none">
                <img src="img/bowl.png">
                <div class="bowl">
                    <div class="trans trans1">
                        <div id="1" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>
                    <div class="trans trans2">
                        <div id="2" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>
                    <div class="trans trans1">
                        <div id="3" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>

                    <div class="trans trans2">
                        <div id="4" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>
                    <div class="trans trans1">
                        <div id="5" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>
                    <div class="trans trans2">
                        <div id="6" class="dice">
                            <div class="side front">
                                <span class="pip"></span>
                            </div>
                            <div class="side front inner"></div>
                            <div class="side top">
                                <span class="pip"></span>
                                <span class="pip"></span>
                            </div>
                            <div class="side top inner"></div>
                            <div class="side right">
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side right inner"></div>
                            <div class="side left">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side left inner"></div>
                            <div class="side bottom">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side bottom inner"></div>
                            <div class="side back">
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                                <div class="column">
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                    <span class="pip"></span>
                                </div>
                            </div>
                            <div class="side back inner"></div>
                            <div class="side cover x"></div>
                            <div class="side cover y"></div>
                            <div class="side cover z"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="index-btn">
            <a class="start">开始博饼</a>
            <p>您的博饼次数剩余【<?php echo $leftNum;?>】次</p>
            <div class="btn-items">
                <a href="./rule.php">[博饼规则]</a>
                <a href="./myAward.php">[我的奖品]</a>
                <a href="./rank.php">[积分排行榜]</a>
            </div>
        </div>
    </div>
    <div class="pop-alert pop">
        <div style="height: 8.5rem">
            <p class="p1">恭喜您</p>
            <p class="p2">获得
                <text>状元</text>!
            </p>
            <p class="p34" id="p3">本次博饼获得积分
                <text></text>
                分
            </p>
            <p class="p34" id="p4">目前您的博饼总积分为
                <text></text>
                分
            </p>
        </div>
        <div class="act"><input type="button" value="查看排行榜" id="toRank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                type="button" value="再博一次" id="again"></div>
        <a class="close1"><img src="./img/fault.png" class="close"></a>
    </div>
    <audio id="myaudio" src="music/roll_dice.mp3" controls="controls" hidden="true">
    </audio>
    </body>
    <script src="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/js/jquery-weui.min.js"></script>
    <script src="../../assets/js/jquery.bpopup.js"></script>
    <script>
        <?php if(!$isBind){?>
        $.alert("您还未绑定福州联通，绑定后才可参加活动哦", "提示", function () {
            window.location.href='http://unicom.lovemojito.com/fzUnicom/userSide/bind/bind.php?activity=midAutumn';
        });
        <?php } ?>
        $(function () {
            var width = $(window).width();
            var addHeight = 0;
            if(width==412){
//                $(".btn-items").css("margin-bottom","10rem");
            }
            var height = $(window).height();
            $("body").height(height);
            var msg = '<?php echo $msg?>';
            var myPoints = <?php echo $myPoint;?>;
            var isLoc = <?php echo $isLocUnicom;?>;
            var canJoin = <?php echo $canJoin?>;
            var early = <?php echo $early?>;
            var late = <?php echo $late?>;
            var click = true;
            $(".start").on("click", function () {
                if(isLoc){
                    if(early){
                        $.alert("活动尚未开始，敬请期待！");
                    }else if(late){
                        $.alert("抱歉，活动已经结束咯");
                    }else{
                        if(canJoin){
                            if(click){
                                click = false;
                                <?php
                                $key = "ptUnicom_bobing";
                                $time = time();
                                $token = md5($openid . $key . $time);
                                ?>
                                var time = '<?php echo $time;?>';
                                var token = '<?php echo $token;?>';
                                $(".bowl-item1").hide();
                                $(".index").show();
                                $(".trans").addClass("active");
                                var myAuto = document.getElementById('myaudio');
                                myAuto.play();
                                //调接口
                                $.showLoading();
                                $.ajax({//获取次数并，减少一次机会。
                                    type: "post",
                                    url: "apiLottery.php",
                                    data: {
                                        time: time,
                                        token: token,
                                        action: "roll"
                                    },
                                    async: false,
                                    dataType: "json",
                                    error: function (data) {
                                        $.alert("请求失败");
                                        click = true;
                                    },
                                    success: function (data) {
                                        if (data.err == 0) {
                                            for (i = 0; i < 7; i++) {
                                                $("#" + (i+1)).addClass("active" + data.msg['lotArr'][i]);
                                                console.log(data.msg['lotArr'][i]);
                                            }
                                            var count=1;
                                            var c = setInterval(function () {
                                                count--;
                                                if (count < 0) {
                                                    $(".trans").removeClass("active");
                                                    myAuto.pause();
                                                    clearInterval(c);
                                                    $.hideLoading();
                                                    var count2=1;
                                                    var b = setInterval(function () {
                                                        count2--;
                                                        if (count2 < 0) {
                                                            clearInterval(b);

                                                            var pointNew = data.msg['point'];
                                                            var pointAll = pointNew+myPoints;

                                                            if (data.msg['name'] == "没中") {
                                                                $(".p1").html("好可惜");
                                                                $(".pop text").html("");
                                                                $(".p2").html("您没博中");
                                                                $("#p3 text").html("0");
                                                                $("#p4 text").html(pointAll);
                                                            }else{
                                                                $(".p2 text").html(data.msg['name']);
                                                                $("#p3 text").html(data.msg['point']);
                                                                $("#p4 text").html(pointAll);
                                                            }
                                                            debugger;
                                                            $(".trans").hide();

                                                            $(".pop-alert").bPopup({
                                                                modalClose: false,
                                                                positionStyle: 'fixed',
                                                                closeClass: 'close'
                                                            });
                                                            $(".close").on("click",function(){
                                                                window.location.href = "./index.php?rand=" +<?php echo rand();?>;
                                                            });
                                                            $("#again").on("click",function(){
                                                                window.location.href = "./index.php?rand=" +<?php echo rand();?>;
                                                            });
                                                            $("#toRank").on("click",function(){
                                                                window.location.href = "./rank.php";
                                                            });
                                                        }

                                                    }, 1000);

                                                } else {

                                                }
                                            }, 1000);

                                        } else {
                                            $.hideLoading();
                                            $(".trans").removeClass("active");
                                            $(".trans").hide();

                                            myAuto.pause();
                                            $.alert(data.msg);
                                            click = true;
                                        }

                                    }
                                });
                            }

                        }else{
                            $.alert(msg);
                        }
                    }


                }else{
                    $.alert("抱歉，您不是福州联通用户，不能参与活动哦");
                }


            });
        })
    </script>
    </html>

<?php
require_once "share.php";
$pvuvLogObj->kmResult = "进入中秋博饼页面：是否绑定{$isBind}是否本地联通{$isLocUnicom}";
$pvuvLogObj->saveLog();//保存数据
?>