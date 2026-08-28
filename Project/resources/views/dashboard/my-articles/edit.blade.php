@extends('dashboard.index')

@section('title')
    <title>ویرایش مقاله</title>
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
            <a href="#">ویرایش مقاله</a>
        </div>

        <h2 class="mb-4">ویرایش مقاله</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.my-articles.update', $article->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="title" class="form-label">عنوان مقاله</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}">
            </div>

            @if($article->image)
                <p>تصویر فعلی مقاله: </p>
                <div class="d-flex mb-3" style="height: 150px">
                    <img src="{{ asset('storage/articles/' . $article->image) }}" alt="تصویر فعلی مقاله" class="img-fluid rounded">
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="remove_image" value="1" id="removeImage" class="form-check-input border-dark">
                    <label class="form-check-label" for="removeImage">مقاله بدون تصویر باشد.</label>
                </div>
            @endif
            <div class="mb-5">
                <label for="image" class="form-label">تغییر تصویر مقاله</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <div class="mt-5">
                @if($article->file)
                    <p>فایل فعلی مقاله: {{ $article->file }}</p>
                    <div class="mb-3">
                        <input type="checkbox" name="remove_file" value="1" id="removeFile" class="form-check-input border-dark">
                        <label class="form-check-label" for="removeFile">
                            مقاله بدون فایل <span class="small text-muted">(پیوست)</span> باشد.
                        </label>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="file" class="form-label">تغییر فایل مقاله <span class="small text-muted">(پیوست)</span></label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf, .doc, .docx">
                </div>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">متن مقاله</label>
                <textarea name="content" id="content" class="form-control" rows="8">{!! old('content', $article->content) !!}</textarea>
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-primary mx-auto">ویرایش مقاله</button>
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
