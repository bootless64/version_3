@extends('master')

@section('title')
    <title>نمایش خبر</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/news/show.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/news/show.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/news/show.css') }}" rel="stylesheet">
    @endif
@endsection

@section('master_content')

    <div class="container mt-5 mb-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('news.index') }}">خبرها</a></a><span class="px-1"> > </span>
            <a href="#">مشاهده خبر</a>
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
                <h2 class="card-title">{{ $news->title }}</h2>
                <p class="text-muted small">نوشته شده در {{ $news->getCreatedAt() }}</p>
                <hr>

                <div class="d-flex mb-5 justify-content-center main-image">
                    <img src="{{ $news->image ? asset('storage/news/' . $news->image) : asset('images/no-image.jpg')}}"
                        class="h-100 shadow-lg" alt="{{ $news->title }}">
                </div>

                <div class="news-content mb-5">
                    {!! $news->content !!}
                </div>

                @if ($news->slider_images)
                    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($news->slider_images as $index => $img)
                                <button type="button" data-bs-target="#newsCarousel"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($news->slider_images as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/news/' . $img) }}" class="w-100 h-100">
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                @endif

            </div>
        </div>

        <div class="mt-5">
            <h4>نظرات کاربران</h4>

            @forelse ($news->approvedComments as $comment)
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
                <div class="d-flex align-items-center">
                    <div class="avatar m-1 shadow">
                        <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/no-avatar.png') }}"
                            class="img-fluid avatar">
                    </div>
                    <h6 class="mx-1 my-0 text-muted">{{ auth()->user()->name . ':'}}</h6>
                </div>
                <form action="{{ route('news.comment', $news->id) }}" method="POST">
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
