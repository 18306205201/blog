@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')
  <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 topic-content">
    <div class="card">
      <div class="card-body">
        <h1 class="text-center mt-3 mb-3">
          {{ $topic->title }}
        </h1>

        <div class="article-meta text-center text-secondary">
          {{ $topic->created_at->diffForHumans() }}
          ⋅
          <i class="far fa-comment"></i>
          {{ $topic->reply_count }}
        </div>

        <div class="topic-body mt-4 mb-4">
          {!! $topic->body !!}
        </div>
{{--
        @can('update', $topic)
          <div class="operate">
            <hr>
            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
              <i class="far fa-edit"></i> 编辑
            </a>
            <form action="{{ route('topics.destroy', $topic->id) }}" method="post"
                  style="display: inline-block;"
                  onsubmit="return confirm('您确定要删除吗？');">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="far fa-trash-alt"></i> 删除
              </button>
            </form>
          </div>
        @endcan
--}}
      </div>
    </div>
    {{-- 点赞按钮开始 --}}
    <div class="topic-thumb-up mt-4">
      <div class="col-md-10 text-center">
        @if(!$thumbed)
          <button class="btn btn-success btn-thumb-up" data-id="{{ $topic->id }}">点赞</button>
        @else
          <button class="btn btn-success btn-thumb-down" data-id="{{ $topic->id }}">取消点赞</button>
        @endif
      </div>
    </div>
    {{-- 点赞按钮结束 --}}

    {{-- 用户回复列表 --}}
    <div class="card topic-reply mt-4">
      <div class="card-body">
        @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
        @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
      </div>
    </div>

  </div>

  {{--    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">--}}
  {{--      <div class="card ">--}}
  {{--        <div class="card-body">--}}
  {{--          <div class="text-center">--}}
  {{--            作者：{{ $topic->user->name }}--}}
  {{--          </div>--}}
  {{--          <hr>--}}
  {{--          <div class="media">--}}
  {{--            <div align="center">--}}
  {{--              <a href="{{ route('users.show', $topic->user->id) }}">--}}
  {{--                <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px" height="300px">--}}
  {{--              </a>--}}
  {{--            </div>--}}
  {{--          </div>--}}
  {{--        </div>--}}
  {{--      </div>--}}
  {{--    </div>--}}

  </div>
@stop
@section('scripts')
  <script>
    $(document).ready(function () {
      // 监听点赞按钮的点击事件
      $('.btn-thumb-up').on('click', function () {
        // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
        axios.post('{{ route('topics.thumb', ['topic' => $topic->id]) }}')
          .then(function () { // 请求成功会执行这个回调
            swal('点赞成功', '', 'success');
            location.reload();
          }, function (error) { // 请求失败会执行这个回调
            // 如果返回码是 401 代表没登录
            if (error.response && error.response.status === 401) {
              swal('请先登录', '', 'error');
            } else if (error.response && (error.response.data.msg || error.response.data.message)) {
              // 其他有 msg 或者 message 字段的情况，将 msg 提示给用户
              swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
            } else {
              // 其他情况应该是系统挂了
              swal('系统错误', '', 'error');
            }
          });
      });
      // 取消点赞
      $('.btn-thumb-down').on('click', function () {
        // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
        axios.post('{{ route('topics.unthumb', ['topic' => $topic->id]) }}')
          .then(function () { // 请求成功会执行这个回调
            swal('取消成功', '', 'success');
            location.reload();
          }, function (error) { // 请求失败会执行这个回调
            // 如果返回码是 401 代表没登录
            if (error.response && error.response.status === 401) {
              swal('请先登录', '', 'error');
            } else if (error.response && (error.response.data.msg || error.response.data.message)) {
              // 其他有 msg 或者 message 字段的情况，将 msg 提示给用户
              swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
            } else {
              // 其他情况应该是系统挂了
              swal('系统错误', '', 'error');
            }
          });
      });

    });
  </script>
@endsection
