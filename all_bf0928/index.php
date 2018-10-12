<?php
require_once "header.php";

$conn = connect_to_db();
//判断身份

//判断机会

//奖励初始化
/*$price = array(0=>rand(1,6),1=>rand(1,6),2=>rand(1,6),3=>rand(1,6),4=>rand(1,6),5=>rand(1,6));*/
?>
    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>标题</title>
        <meta name="format-detection" content="telephone=no,email=no"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <!-- 公用css -->
        <link rel="stylesheet" href="http://cdn.bootcss.com/weui/1.1.0/style/weui.min.css">
        <link rel="stylesheet" href="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/css/jquery-weui.min.css">
        <link rel="stylesheet" href="../../assets/css/reset.css"/>
        <link rel="stylesheet/less" href="css/style.less"/>
        <!--<link rel="stylesheet" href="css/style.css"/>-->
        <!-- 公用js -->
        <script src="../../assets/js/responsive.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
        <style>
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

            .close {
                display: block;
                margin: 3rem auto 0;
                text-align: center;
            }

            .close img {
                width: 2rem;
            }
        </style>
    </head>
    <body>
    <div class="index-container">
        <p class="index-time">活动时间：2017年10月1日-10月8日</p>
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
            <div class="btn-items">
                <a href="">[博饼规则]</a>
                <a href="">[我的奖品]</a>
                <a href="">[积分排行榜]</a>
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
        <a class="close"><img src="./img/fault.png"></a>
    </div>
    <audio id="myaudio" src="music/roll_dice.mp3" controls="controls" hidden="true">
    </audio>
    </body>
    <script src="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/js/jquery-weui.min.js"></script>
    <script src="../../assets/js/jquery.bpopup.js"></script>
    <script>
        $(function () {
            $("body").height($(window).height());
            $(".start").on("click", function () {
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
                        price:<?php echo json_encode_cn($price); ?>,
                        time: "time",
                        token: "token",
                        action: "roll"
                    },
                    async: false,
                    dataType: "json",
                    error: function (data) {
                        $.alert("请求失败");
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
                                            $(".p2 text").html(data.msg['name']);
                                            $("#p3 text").html(data.msg['point']);

                                            if (data.msg['name'] == "没中") {
                                                var pointNew = data.msg['point'];
                                                $(".p1").html("好可惜");
                                                $(".pop text").html("");
                                                $(".p2").html("您没摇中");
                                                $("#p3 text").html("");
                                                $("#p4 text").html("");

                                            }
                                            $(".pop-alert").bPopup({
                                                positionStyle: 'fixed',
                                                modelClose:false,
                                                closeClass: 'close'
                                            });
                                            $(".close").on("click",function(){
                                                window.location.href = "./index.php?rand=" +<?php echo rand();?>;
                                            });
                                            $("#again").on("click",function(){
                                                window.location.href = "./index.php?rand=" +<?php echo rand();?>;
                                            });
                                        }

                                    }, 500);

                                } else {

                                }
                            }, 1000);

                        } else {
                            $.hideLoading();
                            $(".trans").removeClass("active");
                            myAuto.pause();
                            $.alert(data.msg);
                        }

                    }
                });

            });
        })
    </script>
    </html>

<?php
require_once "share.php";
?>