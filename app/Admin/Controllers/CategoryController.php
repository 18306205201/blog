<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Category(), function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();
            $grid->column('name', '名称');
            $grid->column('description', '描述');
            $grid->column('post_count', '文章总数');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            // 禁用详情按钮
            $grid->disableViewButton();
            // 禁用删除按钮
            $grid->disableDeleteButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Category(), function (Form $form) {
            $form->text('name', '名称');
            $form->text('description', '描述');
            $form->disableDeleteButton();
            $form->disableViewButton();
        });
    }
}
