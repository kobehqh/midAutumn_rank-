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

$bindInfo = getBindedMemberInfo($conn, $openid);//个人信息
$isBind = $bindInfo['isbind'];
//$isLocUnicom = $bindInfo['isLocUnicom'];
$phone = $bindInfo['phone'];
if(!$isBind){
    header("Location:".$CONFIG['UrlPrefix']."/userSide/midAutumn/index.php");
    exit();
}
$userInfo = getWeixinUserInfo($conn, $openid);
$headImg = $userInfo['headimgurl'];
$nickName = $userInfo['nickname'];
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
//排行榜部分(前39名)
$rankArr = array();
$sql_rank = "SELECT * FROM `midAutumnActivity_rank` ORDER BY points DESC,updateTime limit 15";
$res_rank = mysql_query($sql_rank,$conn);
while($row_rank=mysql_fetch_assoc($res_rank)){
    $rankArr[] = $row_rank;
}

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
    <link rel="stylesheet" href="./css/rank.css"/>

    <!-- 公用js -->
    <script src="../../assets/js/responsive.js"></script>
    <script src='../../assets/js/jquery-2.1.3.min.js'></script>

</head>
<body>
<div class="main">
    <div class="moon">
        <div class="headImg">
            <img src="<?php echo $headImg;?>">
        </div>
        <p class="p1"><?php echo $nickName;?></p>
        <p class="pr">手机号：<?php echo $phone;?></p>
        <p class="pr">积分：<text><?php echo $myPoint;?></text>&nbsp;&nbsp;&nbsp;排名：<text><?php echo $myRank;?></text></p>
    </div>
    <div class="rank">
            <table class="firstTb">
                <tr class="tr1">
                    <td class="td1">头像</td>
                    <td class="td2">昵称</td>
                    <td class="td3">时间</td>
                    <td class="td4">总积分</td>
                    <td class="td5">排名</td>
                </tr>
            </table>
        <div class='scroll'>
            <table>
            <?php if(count($rankArr)==0){
                echo "<div class='tip'><p>———暂无信息———</p></div>";
            }else{
                for($i=1;$i<=count($rankArr);$i++){
                    echo "<tr class='tr2'><td class='td21'><div class='tdImg'><img src='{$rankArr[$i-1]['headImg']}'></div></td>";
                    echo "<td class='td22'>{$rankArr[$i-1]['nickName']}</td>";
                    echo "<td class='td23'>{$rankArr[$i-1]['updateTime']}</td>";
                    echo "<td class='td24'>{$rankArr[$i-1]['points']}</td>";
                    if($i==1){
                        echo "<td><div class='td25'><img src='./img/first.png'></div></td></tr>";
                    }elseif($i==2){
                        echo "<td><div class='td25'><img src='./img/second.png'></div></td></tr>";
                    }elseif($i==3){
                        echo "<td><div class='td25'><img src='./img/third.png'></div></td></tr>";
                    }else{
                        echo "<td class='td26'><div>{$i}</div></td></tr>";
                    }

                }

            }
            echo "</table>";
            echo "";
            if(count($rankArr)>0&&count($rankArr)<39){
                echo "<div class='tip'><p>———暂无其它排名信息———</p></div>";
            }elseif(count($rankArr)>=39){
                echo "<div class='tip'><p>———排行榜仅显示前39名哦———</p></div>";
            }

            ?>

        </div>
    </div>
    <div class="rankBottom">
        <input type="button" value="返回首页" id="back">
    </div>
</div>
</body>
<script src="http://cdn.bootcss.com/jquery-weui/1.0.0-rc.0/js/jquery-weui.min.js"></script>
<script>
$(function () {
    $(".main").height($(window).height());
    $(".main").css("padding-top","1.5rem");
    $("#back").on("click",function () {
        window.location.href="./index.php";
    });
//    $(".td1").on("click",function () {
//        $.alert($(window).width());
//    });

})
</script>
</html>
<?php
require_once "share.php";
$pvuvLogObj->kmResult = "进入中秋博饼排行榜页面：是否绑定{$isBind}是否本地联通{$isLocUnicom}";
$pvuvLogObj->saveLog();//保存数据
?>