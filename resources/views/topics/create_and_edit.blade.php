@extends('layouts.app')
@section('title', $topic->id ? '编辑博文' : '新建博文')

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
{{--        <link rel="stylesheet" href="{{ asset('editormd/css/editormd.css') }}" />--}}
    @endsection

    @section('scripts')
        <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

{{--        <script src="{{ asset('editormd/editormd.js') }}"></script>--}}

{{--        <script src="{{ asset('editormd/lib/marked.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/prettify.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/raphael.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/underscore.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/sequence-diagram.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/flowchart.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/lib/jquery.flowchart.min.js') }}"></script>--}}
{{--        <script src="{{ asset('editormd/editormd.js') }}"></script>--}}

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
                // var testEditor;
                // $(function() {
                //     $.get("examples/test.md", function(md){
                //         testEditor = editormd("test-editormd", {
                //             width: "98%",
                //             height: 730,
                //             path : 'lib/',
                //             markdown : md,
                //             codeFold : true,
                //             saveHTMLToTextarea : true,
                //             searchReplace : true,
                //             htmlDecode : "style,script,iframe|on*",
                //             emoji : true,
                //             taskList : true,
                //             tocm            : true,         // Using [TOCM]
                //             tex : true,                   // 开启科学公式TeX语言支持，默认关闭
                //             flowChart : true,             // 开启流程图支持，默认关闭
                //             sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
                //             imageUpload : true,
                //             imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                //             imageUploadURL : "examples/php/upload.php",
                //             onload : function() {
                //                 console.log('onload', this);
                //             }
                //         });
                //     });
                // });
                //
                // var wordsView;
                // wordsView = editormd.markdownToHTML("wordsView", {
                //     htmlDecode      : "style,script,iframe",  // you can filter tags decode
                //     emoji           : true,
                //     taskList        : true,
                //     tex             : true,  // 默认不解析
                //     flowChart       : true,  // 默认不解析
                //     sequenceDiagram : true,  // 默认不解析
                // });
            });
        </script>
    @endsection
@endsection