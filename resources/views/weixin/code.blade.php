<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/qrcode.min.js"></script>
</head>
<body>
<div width="300px" height="300px" border="1">
    <button id="btn1">分享</button>
    <div id="qrcode"></div>

</div>

</body>
</html>
<script src="/js/jquery.min.js"></script>
<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
    var qrcode = new QRCode('qrcode',{
        text:'{{$code_url}}',
        width:256,
        height:256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });


    wx.config({
        //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$js_config['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$js_config['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$js_config['nonceStr']}}", // 必填，生成签名的随机串
        signature: "{{$js_config['signature']}}",// 必填，签名
        jsApiList: ['chooseImage','uploadImage','updateAppMessageShareData'] // 必填，需要使用的JS接口列表
    });
    wx.ready(function () {
        $("#btn1").click(function(){
            wx.updateAppMessageShareData({
                title: "扫码", // 分享标题
                desc: "欢迎回来", // 分享描述
                link: "https://1809zhanghaowei.comcto.com/jsdemo", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQEB8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAydzhXV0p4eU9lWUMxWGQ4ZU5zMUUAAgRNTsVcAwSAOgkA", // 分享图标
                success: function () {
                    alert('分享成功');
                }
            })
        })

    })
</script>