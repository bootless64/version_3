@extends('master')

@section('title')
    <title>مقالات بومی</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/articles/index.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/articles/index.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/articles/index.css') }}" rel="stylesheet">
    @endif
@endsection

@section('master_content')

    <div class="container my-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">مقالات بومی</a>
        </div>

        <h2 class="mb-5 text-center">مقالات بومی</h2>

        <div class="row gy-4 mb-5">
            @forelse ($articles as $item)
                <div class="d-flex col-md-6">
                    <div class="card shadow-lg">
                        <img src="{{ $item->image ? asset('storage/articles/' . $item->image) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $item->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit( strip_tags($item->content), 300, '...' ) }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('article.show', $item->id) }}" class="btn btn-primary">مشاهده مقاله</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">
                    مقاله‌ای یافت نشد.
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
