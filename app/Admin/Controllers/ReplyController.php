<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ReplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Reply::with(['topic' => function($query) {
            $query->select('id', 'title');
        }, 'user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('topic_id');
            $grid->column('topic.title', '文章标题');
            $grid->column('user_id');
            $grid->column('user.name', '用户');
            $grid->column('content');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('topic_id');
            });
            $grid->disableEditButton();
            $grid->disableCreateButton();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Reply(), function (Show $show) {
            $show->field('id');
            $show->field('topic_id');
            $show->field('user_id');
            $show->field('content');
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableEditButton();
            $show->disableQuickEdit();
        });
    }

    protected function form()
    {
        return Form::make(new Reply(), function(){});
    }
}
