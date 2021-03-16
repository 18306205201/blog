<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Topic;
use App\Http\Requests\Request;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;
use Dcat\Admin\Admin;

class TopicController extends AdminController
{
    protected $title = '文章';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Topic::with(['category', 'adminUser']), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('id', 'ID')->sortable();
            $grid->column('title');
            $grid->column('body')->width('35%');
            $grid->column('admin_user.name', '作者');
            $grid->column('category.name', '分类');
            $grid->column('reply_count');
            $grid->column('view_count');
            $grid->column('order');
            $grid->column('excerpt');
            $grid->column('slug');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->fixColumns(2, -3);
            $grid->disableViewButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        return Form::make(Topic::with('adminUser'), function (Form $form) {
            // 获取所有分类
            $categories = Cache::remember('categories', '5', function () {
                $cates = Category::all();
                $category = [];
                foreach ($cates as $cate) {
                    $category[$cate->id] = $cate->name;
                }
                return $category;
            });
            $form->select('category_id')->options($categories);
            $form->text('title');
            $form->editor('body');
            $form->hidden('user_id');
            $form->saving(function (Form $form) {
                $form->user_id = Admin::user()->getKey();
            });
        });
    }
}
