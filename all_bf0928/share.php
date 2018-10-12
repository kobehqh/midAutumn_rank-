<?php
if(!isset($conn)){
	$conn = connect_to_db();
}
$signPackage = getSignPackage($conn);
$phpfile = "/userSide/midAutumn/index.php";

$unixtime = time();
$key = "hugjmk5AA4giest5weixinTencentCC@#fKM";
$token = md5($openid . $key . $unixtime);
$campaignID = '2017_01_01_ptUnicom';
$shareUrl = addWeixinShareParameters($phpfile,$openid,$campaignID);
$shareImg = "http://wx.ptunicom.com/share/unicom.jpg";
mysql_close($conn);
$shareDesc = '国庆中秋欢乐博饼';
//$shareDescs = '我参加了“壕礼大转盘”，韩国游、铂金装、迪士尼亲子游…超多福利！你也快来试试手气吧～';
$shareTitle = '国庆中秋欢乐博饼';
?>

<script>	
	var customConfig = {
	PKey: 'ptUnicom',
    srcWeixinID: '',
    visitWeixinID: '<?php echo $openid; ?>',
	unixtime: '<?php echo $unixtime; ?>',
	token: '<?php echo $token; ?>',
	referUrl: top.location.href,
        logUrl: '<?php echo $CONFIG['UrlPrefix']."/share/shareTracklog.php"; ?>', // 日志接口url
	shareToFriendData: { // 分享给朋友的数据
        "shareImgurl":'<?php echo $shareImg;?>',
        "shareUrl":'<?php echo $shareUrl;?>',
        "shareDesc":'<?php echo $shareDesc;?>',
        "shareTitle":'<?php echo $shareTitle;?>'
    },
    shareToTimelineData: { // 分享到朋友圈的数据
        "shareImgurl":'<?php echo $shareImg;?>',
        "shareUrl":'<?php echo $shareUrl;?>',
        "shareTitle":'<?php echo $shareDesc;?>'
    },
    shareToWeiboData: { // 分享到腾讯微博的数据
        "shareImgurl":'<?php echo $shareImg;?>',
        "shareUrl":'<?php echo $shareUrl;?>',
        "shareDesc":'<?php echo $shareDesc;?>',
        "shareTitle":'<?php echo $shareTitle;?>！'
    }
    
};
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
		// 所有要调用的 API 都要加到这个列表中
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo'
    ]
  });
</script>
<script type="text/javascript" src="<?php echo $CONFIG['UrlPrefix']."/share/share.js" ?>"></script>
