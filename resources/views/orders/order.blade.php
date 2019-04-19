<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付订单</title>
</head>
<body>
    <table border=1>
        <tr>
            <td>订单ID</td>
            <td>订单号</td>
            <td>价格</td>
            <td>立刻结算</td>
        </tr>
        @foreach($order_info as $v)
        <tr>
            <td>{{$v->oid}}</td>
            <td>{{$v->on_order}}</td>
            <td>{{$v->totalprices}}</td>
            <td><a href="/weixin/test?on_order={{{$v->on_order}}}">立刻结算</a></td>

        </tr>
        @endforeach
    </table>
</body>
</html>
