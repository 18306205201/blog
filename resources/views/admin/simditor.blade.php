<div class="{{$viewClass['form-group']}}">

  <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

  <div class="{{$viewClass['field']}}">

    @include('admin::form.error')

    <div {!! $attributes !!} style="width: 100%; height: 100%;">
      <textarea  id="editor" name="{{ $name }}">{!! $value !!}</textarea>
    </div>

    @include('admin::form.help-block')

  </div>
</div>

<script require="@simditor">
  $(document).ready(function () {
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
