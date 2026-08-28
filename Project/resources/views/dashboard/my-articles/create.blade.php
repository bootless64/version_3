@extends('dashboard.index')

@section('title')
    <title>ثبت مقاله جدید</title>
@endsection

@section('dashboard_style')
    <link href="{{ asset('summernote-0.8.18/summernote-lite.min.css') }}" rel="stylesheet">

    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/summernote.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/summernote.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/summernote.css') }}" rel="stylesheet">
    @endif
@endsection

@section('dashboard_content')

    <div class="container p-4 mb-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.my-articles.index') }}">مقاله‌های من</a><span class="px-1"> > </span>
            <a href="#">ثبت مقاله جدید</a>
        </div>

        <h2 class="mb-4">ثبت مقاله جدید</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.my-articles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">عنوان مقاله</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">تصویر مقاله</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">فایل مقاله <span class="small text-muted">(پیوست)</span></label>
                <input type="file" name="file" id="file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">متن مقاله</label>
                <textarea name="content" id="content" class="form-control" rows="8">{!! old('content') !!}</textarea>
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-primary mx-auto">ثبت مقاله</button>
            </div>
        </form>

    </div>

@endsection

@section('dashboard_script')

    <script src="{{ asset('jquery-3.6.0/jquery.min.js') }}"></script>
    <script src="{{ asset('summernote-0.8.18/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('summernote-0.8.18/lang/summernote-fa-IR.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#content').summernote({
                lang: 'fa-IR',
                placeholder: 'متن مقاله را وارد کنید...',
                height: 300,
                tabsize: 4,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'table']],
                    ['view', ['codeview']],
                    ['misc', ['undo', 'redo']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            fileSizeKB = parseInt( files[i].size / 1024 );
                            if (fileSizeKB > 500) {
                                alert("حجم عکس آپلود شده نباید بیشتر از 500 کیلوبایت باشد.");
                                return;
                            }
                            sendImage(files[i]);
                        }
                    }
                }

            });
        });

        function sendImage(file) {
            var data = new FormData();
            data.append("image", file);
            data.append("contentType", "articles");
            $.ajax({
                url: '{{ route("summernote.upload") }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#content').summernote('insertImage', url);
                },
                error: function(data) {
                    alert("آپلود با خطا مواجه شد.");
                }
            });
        }

    </script>
@endsection
