 <style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付</title>
</head>
<body>
<div class="flex-center position-ref full-height">
<div class="content">
    <h2>微信支付</h2>
    <!-- code_url:{{$code_url}} -->
    <div class="title m-b-md">
        <div id="qrcode"></div>

    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/qrcode.min.js"></script>
    <script src="\js\jquery-3.1.1.min.js"></script>

    <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), "{{$code_url}}");
        //ajax轮询，检查订单支付状态
        setInterval(function(){
            $.ajax({
                url : '/orders/paystatus?oid=' + "{{$oid}}",
                type: 'get',
                dataType:'json',
                success: function(res){
                    // console.log(res)
                    if(res.status==0){
                        alert("支付成功");
                        location.href = "/cart/index";
                    }
                }
            });
        },8000)
    </script>
    </div>
</div>
</body>
</html>

