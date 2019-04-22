<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
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
            <td>{{$goods_info->goods_num}}</td>
            <td>redis:{{$redis_incr}}</td>

        </tr>
        <tr><td> <a href="/goods/cart/{{$goods_info->goods_id}}">加入购物车</a></td></tr>
    </table>
</body>
</html>
