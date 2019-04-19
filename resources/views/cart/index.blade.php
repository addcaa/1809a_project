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
            <td>商品名称</td>
            <td>商品价格</td>
            <td>商品数量</td>
            <td>添加时间</td>
            <td>添加订单</td>
        </tr>
        @foreach($cart_info as $v)
        <tr>
            <td>{{$v->cart_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_price}}</td>
            <td>{{$v->cart_num}}</td>
            <td><?php // echo strtotime('2019-8-21');
                echo date('Y-m-d',$v->cart_time);?></td>
            <td><a href="/orders/index?cart_id={{$v->cart_id}}">立即购买</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
