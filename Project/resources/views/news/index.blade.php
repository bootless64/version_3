@extends('master')

@section('title')
    <title>خبرها</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/news/index.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/news/index.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/news/index.css') }}" rel="stylesheet">
    @endif
@endsection

@section('master_content')

    <div class="container my-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">خبرها</a>
        </div>

        <h2 class="mb-5 text-center">خبرها</h2>

        <div class="row gy-4 mb-5">
            @foreach ($news as $item)
                <div class="d-flex col-lg-4 col-sm-6">
                    <div class="card shadow-lg">
                        <img src="{{ $item->image ? asset('storage/news/' . $item->image) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $item->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>

                            <p class="card-text">{{ Str::limit( strip_tags($item->content), 100, '...' ) }}</p>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary">مشاهده خبر</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $news->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
