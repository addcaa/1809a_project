<?php
    use Illuminate\Support\Facades\Redis;
    /**
     *
     *  获取access_token
     */
    function getaccesstoken(){
        $key="jssdk_access_token";
        $access_token=Redis::get($key);
        if($access_token){
            return  $access_token;
        }else{
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APP_ID').'&secret='.env('WX_APP_SEC');
            $respons=json_decode(file_get_contents($url),true);
            // return $respons;
            if(isset($respons['access_token'])){
                Redis::set($key,$respons['access_token']);
                redis::expire($key,2700);
                return $respons['access_token'];
            }else{
                return false;
            }
        }

    }
    /**
     *
     * 获取jsapi_ticket
     */
    function jsapi_ticket(){
        $key="jsapi_ticket";
        $jsapi_ticket=Redis::get($key);
        if($jsapi_ticket){
            return $jsapi_ticket;
        }else{
            $access_token=getaccesstoken();
            $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";
            $respons=json_decode(file_get_contents($url),true);
            // return $respons;
            if(isset($respons['ticket'])){
                Redis::set($key,$respons['ticket']);
                Redis::expire($key,2700);
            }else{
                return false;
            }
        }
    }
?>
