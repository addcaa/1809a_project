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
    <img src="" alt="" id="imgs0" width="300">
    <img src="" alt="" id="imgs1" width="300">
    <img src="" alt="" id="imgs2" width="300">
<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId:"{{$arr['appId']}}", // 必填，公众号的唯一标识
        timestamp:"{{$arr['timestamp']}}" , // 必填，生成签名的时间戳
        nonceStr: "{{$arr['nonceStr']}}", // 必填，生成签名的随机串
        signature: "{{$arr['signature']}}",// 必填，签名
        jsApiList: ['chooseImage','uploadImage','downloadImage'] // 必填，需要使用的JS接口列表
    });
    wx.ready(function(){
        $("#btn1").click(function(){
        wx.chooseImage({
            count: 3, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    var img="";
                    $.each(localIds,function(i,v){
                        img+=v+",";
                        var node = "#imgs"+i;
                        $(node).attr('src',v);
                        //上传图片
                        wx.uploadImage({
                            localId:v, // 需要上传的图片的本地ID，由chooseImage接口获得
                            isShowProgressTips: 1, // 默认为1，显示进度提示
                            success: function (res) {
                                var serverId = res.serverId; // 返回图片的服务器端ID
                            }
                        });
                    })
                    $.ajax({
                        url:'/jssdk/geting?img='+img,  //将上传的图片id发送给后端
                        type: 'get',
                        success:function(d){
                            console.log(d);
                        }
                    })
                }
            });
        })
    })

</script>
</body>
</html>

