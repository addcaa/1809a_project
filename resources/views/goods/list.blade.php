<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
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
            <td>{{$goods_info->goods_num}}  O(∩_∩)O~    redis:{{$redis_incr}}</td>
        </tr>
        <tr>><td> <a href="/goods/cart/{{$goods_info->goods_id}}">加入购物车</a></td></tr>
    </table>
    <h2>浏览历史</h2>
    <table border=1>
        <tr>
            <td>ID:</td>
            <td>商品id</td>
            <td>价格</td>
            <td>图片</td>
        </tr>
        @foreach($arr_info as $v)
        <tr>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_price}}</td>
            <td><img src="http://www.uploads.com/uploads/{{$v->goods_img}}" alt="" width="40"></td>
        </tr>
        @endforeach
    </table>
    <a href="{{$url}}">扫描查看</a>
</body>
</html>
<script src="\js\qrcode.min.js"></script>


