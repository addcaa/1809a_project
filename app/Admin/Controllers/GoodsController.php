<?php

namespace App\Admin\Controllers;

use App\Model\GoodsModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
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
    public function create(Content $content)
    {
        return $content
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
        $grid = new Grid(new GoodsModel);

        $grid->goods_id('ID');
        $grid->goods_name('商品名称');
        $grid->goods_img('商品图片')->display(function($img){
            return '<img src="http://www.uploads.com/uploads/'.$img.'" width="20">';
        });
        $grid->goods_price('商品价格');
        $grid->goods_core('Goods core');
        $grid->goods_stock('Goods stock');
        $grid->goods_static('Goods static');
        $grid->status('Status');
        $grid->goods_desc('Goods desc');
        $grid->goods_num('Goods num');
        $grid->goods_sales('Goods sales');

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
        $show = new Show(GoodsModel::findOrFail($id));

        $show->goods_id('Goods id');
        $show->goods_name('Goods name');
        $show->goods_img('Goods img');
        $show->slider_img('Slider img');
        $show->goods_price('Goods price');
        $show->is_show('Is show');
        $show->cate_id('Cate id');
        $show->brand_id('Brand id');
        $show->market_price('Market price');
        $show->goods_core('Goods core');
        $show->goods_stock('Goods stock');
        $show->goods_static('Goods static');
        $show->status('Status');
        $show->goods_desc('Goods desc');
        $show->goods_num('Goods num');
        $show->goods_sales('Goods sales');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsModel);

        $form->number('goods_id', 'Goods id');
        $form->text('goods_name', 'Goods name');
        $form->text('goods_img', 'Goods img');
        $form->text('slider_img', 'Slider img');
        $form->decimal('goods_price', 'Goods price');
        $form->text('is_show', 'Is show')->default('1');
        $form->number('cate_id', 'Cate id');
        $form->number('brand_id', 'Brand id');
        $form->decimal('market_price', 'Market price');
        $form->text('goods_core', 'Goods core');
        $form->text('goods_stock', 'Goods stock');
        $form->text('goods_static', 'Goods static');
        $form->text('status', 'Status')->default('1');
        $form->text('goods_desc', 'Goods desc');
        $form->number('goods_num', 'Goods num');
        $form->number('goods_sales', 'Goods sales');

        return $form;
    }
}
