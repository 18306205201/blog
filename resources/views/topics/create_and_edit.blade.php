@extends('layouts.app')
@section('title', $topic->id ? '编辑文章' : '新建文章')

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">
                <div class="card-body">
                    <h3 class="text-center">
                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                        @if($topic->id)
                            编辑博文
                        @else
                            新建博文
                        @endif
                    </h3>

                    <hr>

                    @if($topic->id)
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required />
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected': '' }}>{{
                                                $value->name
                                                }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
                                    </div>
{{--                                    <div id="test-editormd">--}}
{{--                                        <textarea name="body"  style="display:none;"></textarea>--}}
{{--                                    </div>--}}
{{--                                    <div id="wordsView">--}}
{{--                                        <textarea style="display:none;" name="editormd-markdown-doc">这里写入md格式内容</textarea>--}}
{{--                                    </div>--}}

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/simditor.css') }}">
    @endsection

    @section('scripts')
        <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

        <script>
            $(document).ready(function (){
                var editor = new Simditor({
                    textarea: $('#editor'),
                    upload: {
                        url: '{{ route('topics.upload_image') }}',
                        params: {
                            _token: '{{ csrf_token() }}',
                        },
                        fileKey: 'upload_file',
                        connectionCount: 3,
                        leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                    },
                    pasteImage: true,
                });
            });
        </script>
    @endsection
@endsection
