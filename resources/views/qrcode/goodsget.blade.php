<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品</title>
</head>
<body>
<table>
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>图片</td>
        <td>价格</td>
    </tr>
    @foreach($arr as $v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td><img src="http://www.uploads.com/uploads/20190220\f4586a5b60207379cfdb68ca2d88cd2f.jpg" alt="" width="50">   </td>
        <td>{{$v->goods_price}}</td>
    </tr>
    @endforeach
</table>
</body>
</html>
