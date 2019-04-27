<style>
    no-padding {
        padding: 0 !important;
    }
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
        background-color:#fff;
    }

    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd;
    }
    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    div {
        display: block;
    }
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-weight: 400;
        overflow-x: hidden;
        overflow-y: auto;
    }
    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }
    html {
        font-size: 10px;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    html {
        font-family: sans-serif;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .box-header:after, .box-body:after, .box-footer:after {
        clear: both;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>群发</title>
</head>
<body>
<div class="box-body table-responsive no-padding content">
    <table class="table table-hover">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>uid</th>
                <th>openid</th>
                <th>用户名:</th>
                <th>头像</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $v)
            <tr class="openid" openid="{{$v->openid}}">
                <td><input type="checkbox" class="box" openid="{{$v->openid}}" ></td>
                <td>{{$v->uid}}</td>
                <td>{{$v->openid}}</td>
                <td>{{$v->nickname}}</td>
                <td><img src="{{$v->headimgurl}}" alt="暂无图片" width="50"></td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <textarea name="" id="text" cols="90" rows="10"></textarea>
    <input type="file">
    <input type="button" id="sub"  class="btn btn-primary"value="发送">
</div>
</body>
</html>
<script src="\js\jquery-3.1.1.min.js"></script>
<script>
$(function(){
    $("#sub").click(function(){
        var box=$(this).parents('div').find("input[class='box']");
        var openid="";
        box.each(function(index){
            if($(this).prop("checked")==true){
                openid+=$(this).attr("openid")+',';
            }
        })
        openid=openid.substr(0,openid.length-1);
        var text=$("#text").val();
            $.post(
                'addo',
                {openid:openid,text:text},
                function(res){
                    console.log(res);
                }
            )
    })
})
</script>
