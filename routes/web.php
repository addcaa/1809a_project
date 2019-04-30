<?php
use App\Http\Controllers\Goods\GoodsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//微信
Route::get('/weixi/valid','Weixin\WxController@valid');
Route::post('/weixi/valid','Weixin\WxController@index');




Route::get('/goods/index','Goods\GoodsController@index');
Route::get('/goods/cart/{goods_id}','Goods\GoodsController@cart');
Route::get('/goods/list/{id}','Goods\GoodsController@list');

//购物车
Route::get('/cart/index','Cart\CartController@index');
//支付
Route::get('/orders/index','Orders\OrdersController@index');
Route::get('/orders/order','Orders\OrdersController@order');
//微信支付
Route::get('/weixin/test','WxPayController@test');
Route::any('/weixin/notify','WxPayController@notify');
//查询订单状态
Route::get('/orders/paystatus','Orders\OrdersController@paystatus');

Route::get('/jssdk/jssdk','Jssdk\JssdkController@jssdk');
Route::get('/jssdk/geting','Jssdk\JssdkController@geting');
Route::get('/jssdk/getu','Jssdk\JssdkController@getu');


//任务计划
Route::get('/crontab/delorders','Crontab\CrontabController@delorders');


//菜单
Route::get('/menu/menu','Menu\MenuController@menu');
//成功二维码
Route::get('/qrcode/qrcode','Qrcode\QrcodeController@qrcode');
Route::get('/qrcode/generate','Qrcode\QrcodeController@generate');
//一件商品
Route::get('/qrcode/goodsget','Qrcode\QrcodeController@goodsget');

/**授权 */
Route::get('/qrcode/accredit','Qrcode\MenuController@accredit');

//**签到 */
Route::get('/menu/sign','Menu\MenuController@sign');


Route::get('/menu/exam','Exam\ExamController@exam');

/**
 * 后台
 */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
