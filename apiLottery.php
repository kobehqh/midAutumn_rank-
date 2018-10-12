<?php
require_once "header.php";
require_once "../../php/funcs.php";
require_once "../../php/pvuvLog.class.php";

$conn = connect_to_db();

$PKey = 'fzUnicom';//项目key值
$splitFlag = false;//是否分表 true分表 false没有分表
$pvuvLogObj = new pvuvLog($PKey, $splitFlag);
$pvuvLogObj->visitWeixinID = $openid;//访问当前页面的用户
$pvuvLogObj->kmResult = "";//页面中需要保存的数据;
$url = $_SERVER['PHP_SELF'];
$pageName = substr($url, strrpos($url, '/') + 1);
$pvuvLogObj->urlID = $PKey . "_$pageName";//页面ID 项目key_页面名称

$err=0;
$msg="";

$early = 0;
$late = 0;
$today_ymd = date('ymd');
$early = 0;
$late = 0;
if($today_ymd<180901){
    $early = 1;
}elseif($today_ymd>181008){
    $late = 1;
}

if(isset($_POST['time'])&&isset($_POST['token'])&&isset($_POST['action'])){
    $key = "ptUnicom_bobing";
    $postTime = $_POST['time'];
    $apiToken = md5($openid . $key . $postTime);
    $postToken = $_POST['token'];
    if ($apiToken == $postToken) {
        $today = date('Y-m-d');
        if($early){
            $err = 6;
            $msg = "活动尚未开始，敬请期待！";
        }elseif($late){
            $err = 6;
            $msg = "抱歉，活动已经结束咯";
        }else{
            $addNum = 0;
            $queryNum = 0;
            $limit = 3;
            $bindInfo = getBindedMemberInfo($conn, $openid);//绑定
            $isLocUnicom = $bindInfo['isLocUnicom'];
            $phone = $bindInfo['phone'];
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
                    $lotArr = array();
                    $count = array(0, 0, 0, 0, 0, 0);
                    for($i = 0; $i < 6; ++$i){
                        $v = mt_rand(1, 6);
                        array_push($lotArr, $v);
                        ++$count[$v-1];
                    }
                    $result = getResult($count);
                    $result['lotArr'] = $lotArr;
                    $result['count'] = $count;
                    $point = $result['point'];
                    $result_name = $result['name'];
                    $lotJson = json_encode($lotArr);
                    //存储摇奖结果
                    $sql_ins = "INSERT INTO `midAutumnActivity_user`(openid,phone,result,result_name,points,createTime) 
                            VALUES('$openid','$phone','$lotJson','$result_name',$point,NOW())";
                    $res_ins = mysql_query($sql_ins,$conn);
                    if(mysql_affected_rows($conn)==1){
                        $err = 0;
                        $msg = $result;
                        $userInfo = getWeixinUserInfo($conn, $openid);
                        $headImg = $userInfo['headimgurl'];
                        $nickName = $userInfo['nickname'];
                        $sql_rank = "SELECT * FROM `midAutumnActivity_rank` WHERE openid='$openid'";
                        $res_rank = mysql_query($sql_rank,$conn);
                        if(is_resource($res_rank)&&mysql_num_rows($res_rank)>0){
                            $sql_rankUp = "UPDATE `midAutumnActivity_rank` SET headImg='$headImg',nickName='$nickName',points=points+$point,updateTime=NOW() WHERE openid='$openid'";
                            mysql_query($sql_rankUp,$conn);
                        }else{
                            $sql_rankIns = "INSERT IGNORE INTO `midAutumnActivity_rank`(openid,nickName,headImg,points,createTime,updateTime)VALUES('$openid','$nickName','$headImg',$point,NOW(),NOW())";
                            mysql_query($sql_rankIns,$conn);
                        }
                    }else{
                        $err = 500;
                        $msg = "抱歉，服务器出错啦";
                    }

                }else{
                    $err = 9;
                    $msg = "抱歉，今日机会已经用完了哦,明天再来吧";
                    if($addNum==0){
                        $err = 199;
                        $msg = "抱歉，今日机会已经用完了哦,分享可再得一次机会";
                    }
                }

            }else{
                $err = 111;
                $msg = "您不是福州联通用户，不能参加该活动哦";
            }
        }


    }else{
        $err = 112;
        $msg = "未知错误";
    }


}else{
    $err = 110;
    $msg = "未知错误";
}

$res = compact('err','msg');
$res_json = json_encode_cn($res);
$pvuvLogObj->kmResult = $res_json;
$pvuvLogObj->saveLog();//保存数据
echo $res_json;

function getResult($count)
{
    $lotConfig = require_once('lotteryConfig.php');
    $result = array();
    //判断结果
    if ($count[3] == 4 && $count[0] == 2) {
        $result['name'] = $lotConfig['zycjh']['name'];
        $result['point'] = $lotConfig['zycjh']['point'];
    } elseif ($count[3] == 6 || $count[0] == 6 || $count[3] == 5
        || $count[0] == 5 || $count[1] == 5 || $count[2] == 5
        || $count[4] == 5 || $count[5] == 5 || $count[3] == 4
    ) {
        $result['name'] = $lotConfig['zy']['name'];
        $result['point'] = $lotConfig['zy']['point'];
    } elseif ($count[0] == 1 && $count[1] == 1 && $count[2] == 1 &&
        $count[3] == 1 && $count[4] == 1 && $count[5] == 1
    ) {
        $result['name'] = $lotConfig['dt']['name'];
        $result['point'] = $lotConfig['dt']['point'];
    } elseif ($count[3] == 3) {
        $result['name'] = $lotConfig['sh']['name'];
        $result['point'] = $lotConfig['sh']['point'];
    } elseif ($count[0] == 4 || $count[1] == 4 || $count[2] == 4
        || $count[4] == 4 || $count[5] == 4
    ) {
        $result['name'] = $lotConfig['sj']['name'];
        $result['point'] = $lotConfig['sj']['point'];
    } elseif ($count[3] == 2) {
        $result['name'] = $lotConfig['ej']['name'];
        $result['point'] = $lotConfig['ej']['point'];
    } elseif ($count[3] == 1) {
        $result['name'] = $lotConfig['yx']['name'];
        $result['point'] = $lotConfig['yx']['point'];
    } else {
        $result['name'] = $lotConfig['mz']['name'];
        $result['point'] = $lotConfig['mz']['point'];
    }

    return $result;
}