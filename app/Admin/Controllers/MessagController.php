<?php

namespace App\Admin\Controllers;

use App\Model\MessageModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
class MessagController extends Controller
{
    use HasResourceActions;
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
        ->header('Index')
        ->description('description')
        ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $Content)
    {
        return $Content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MessageModel);
        $grid->m_id('ID');
        $grid->media_id('media_id');
        $grid->created_at('created_at');
        $grid->type('type');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MessageModel::findOrFail($id));

        $show->m_id('M id');
        $show->openid('Openid');
        $show->m_name('M name');
        $show->m_sex('M sex');
        $show->m_text('M text');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        if($_FILES){
            $tmp_name=$_FILES['img']['tmp_name'];
            $name=$_FILES['img']['name'];
            move_uploaded_file($tmp_name,"/wwwroot/project/public/img/".$name);
            // $res=Storage::put($name,$tmp_name->getBody());//保存
            $access_token=getaccesstoken();
            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=image";
            $client=new Client();
                // dd($access_token);
            $r = $client->request('POST',$url, [
                'multipart' => [
                    [
                        'name'     => 'admin',
                        'contents' => fopen("img/$name", 'r')
                    ],
                ],
            ]);
            $ser=$r->getBody();
            $arr=json_decode($ser,true);
            $message=DB::table('message')->insert($arr);
        }
        $form = new Form(new MessageModel);
        $form->file('img', '添加临时素材');
        return $form;
    }
}
