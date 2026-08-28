@extends('master')

@section('title')
    <title>نمایش مقاله</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/articles/show.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/articles/show.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/articles/show.css') }}" rel="stylesheet">
    @endif
@endsection

@section('master_content')

    <div class="container my-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('articles.index') }}">مقالات بومی</a><span class="px-1"> > </span>
            <a href="#">مشاهده مقاله</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $article->title }}</h2>
                <p class="text-muted small">نوشته شده در {{ $article->getCreatedAt() }}</p>
                <hr>

                <div class="d-flex mb-5 justify-content-center main-image">
                    <img src="{{ $article->image ? asset('storage/articles/' . $article->image) : asset('images/no-image.jpg')}}"
                        class="h-100 shadow-lg" alt="{{ $article->title }}">
                </div>

                <div class="article-content">
                    {!! $article->content !!}
                </div>

                @if ($article->file)
                    <hr>
                    <div class="d-flex align-items-center">
                        <span class="ms-2">فایل پیوست: </span>
                        @php
                            $fileFormat = pathinfo($article->file, PATHINFO_EXTENSION);
                        @endphp
                        <a target="_blank" href="{{ asset('storage/articles/files/' . $article->file) }}" class="d-flex align-items-center">

                            @if ($fileFormat === "pdf")
                                <div class="d-flex file-icon"><img src="{{ asset('icons/pdf-icon.svg') }}" class="img-fluid mx-auto"></div>
                            @elseif ($fileFormat === "docx" || $fileFormat === "doc")
                                <div class="d-flex file-icon"><img src="{{ asset('icons/word-icon.svg') }}" class="img-fluid mx-auto"></div>
                            @endif

                            <span class="small">{{ $article->title }}</span>
                        </a>
                    </div>
                @endif

            </div>
        </div>

        <div class="mt-5">
            <h4>نظرات کاربران</h4>

            @forelse ($article->approvedComments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar m-1 shadow">
                                <img src="{{ $comment->user->avatar ? asset('storage/avatars/' . $comment->user->avatar) : asset('images/no-avatar.png') }}"
                                    class="img-fluid avatar">
                            </div>
                            <h6 class="card-subtitle text-muted mx-1">{{ $comment->user->name }}</h6>
                        </div>
                        <p class="card-text px-2">{!! nl2br(e($comment->content)) !!}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <div class="text-muted">تاکنون نظری ثبت نشده است.</div>
            @endforelse
        </div>

        @if(auth()->user())
            
            <div class="mt-5">
                <h5>ارسال نظر:</h5>
                <form action="{{ route('article.comment', $article->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3" placeholder="نظر خود را بنویسید..." required>{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">ارسال نظر</button>
                </form>
            </div>

        @else
            <div class="mt-5 d-flex">
                <h5 class="ms-3">برای ارسال نظر باید وارد شوید.</h5>
                <a href="{{ route('redirect-after-login', ['redirect_to' => url()->current()]) }}">ورود</a>
            </div>
        @endif

    </div>

@endsection
