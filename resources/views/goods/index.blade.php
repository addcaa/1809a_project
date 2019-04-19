<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品展示</title>
</head>
<body>
    <h3>欢迎<samp style="color:chartreuse">{{$user_name}}</samp>登陆</h3>
    <table border=1>
        <tr>
            <td>ID</td>
            <td>商品名称：</td>
            <td>商品价格：</td>
            <td>商品图片</td>
            <td>商品已售：</td>
            <td>加入购物车：</td>
        </tr>
        @foreach($goods_info as $v)
        <tr>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_price}}</td>
            <td><img src="http://www.uploads.com/uploads/{{$v->goods_img}}" alt='暂无图片' width="40px;"></td>
            <td>{{$v->goods_sales}}</td>
            <td> <a href="/goods/cart/{{$v->goods_id}}">加入购物车</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
