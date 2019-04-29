<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script src="/js/qrcode.min.js"></script>
<script src="/qrcode.min.js"></script>

<body>
    <table border=1>
        <tr>
            <td>ID</td>
            <td>{{$goods_info->goods_id}}</td>
        </tr>
        <tr>
            <td>商品名称：</td>
            <td>{{$goods_info->goods_name}}</td>
        </tr>
        <tr>
            <td>商品价格：</td>
            <td>{{$goods_info->goods_price}}</td>
        </tr>
        <tr>
            <td>商品图片</td>
            <td><img src="http://www.uploads.com/uploads/{{$goods_info->goods_img}}" alt='暂无图片' width="40px;"></td>
        </tr>
        <tr>
            <td>浏览量</td>
            <td>{{$goods_info->goods_num}}  O(∩_∩)O~ </td>
        </tr>
        <tr>><td> <a href="/goods/cart/{{$goods_info->goods_id}}">加入购物车</a></td></tr>
    </table>
   {{$url}}

   <div id="qrcode"></div>
</body>
</html>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/qrcode.min.js"></script>
    <script src="\js\jquery-3.1.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
    new QRCode(document.getElementById("qrcode"), "{{$url}}");
</script>
<script>
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$wxconfig['appId']}}", // 必填，公众号的唯一标识
        timestamp:"{{$wxconfig['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$wxconfig['nonceStr']}}", // 必填，生成签名的随机串
        signature: "{{$wxconfig['signature']}}",// 必填，签名
        jsApiList: [
            'onMenuShareAppMessage',
            'updateAppMessageShareData'
        ] // 必填，需要使用的JS接口列表
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        // wx.onMenuShareAppMessage({
        //     title: '电视', // 分享标题
        //     desc: '对对对', // 分享描述
        //     link: document.URL, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        //     imgUrl: 'http://img.zcool.cn/community/01bbc7597aed60a8012193a3463d04.jpg', // 分享图标
        //     success: function () {
        //     // 用户点击了分享后执行的回调函数
        //     }
        // });
        wx.updateAppMessageShareData({
            title: '电视', // 分享标题
            desc: '对对对', // 分享描述
            link: document.URL, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://img.zcool.cn/community/01bbc7597aed60a8012193a3463d04.jpg', // 分享图标
            success: function () {
            // 设置成功
        }
});

    });
</script>



