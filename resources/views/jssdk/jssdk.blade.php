<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jssdk</title>
</head>
<body>
    <button id="btn1">请选择照片</button>

<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。 -->
        appId:"{{$arr['appId']}}",
        timestamp:"{{$arr['timestamp']}}" ,
        nonceStr: "{{$arr['nonceStr']}}",
        signature: "{{$arr['signature']}}",
        jsApiList: "['chooseImage']"
    });

    wx.ready(function(){
        $("#btn1").click(function(){
            // alert(11);
            wx.chooseImage({
                count: 3, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                }
                // console.log(localIds);
            });
        })
    })
</script>
</body>
</html>

