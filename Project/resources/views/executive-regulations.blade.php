@extends('master')

@section('title')
    <title>آیین‌نامه‌های اجرایی</title>
@endsection

@section('style')
    <link href="{{ asset('photoswipe-5.4.4/photoswipe.css') }}" rel="stylesheet">
@endsection

@section('master_content')

    <div class="mx-5 mt-3 mb-5" style="text-align: justify;">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">آیین‌نامه‌های اجرایی</a>
        </div>

        <h2 class="text-center mb-5">آیین‌نامه‌های اجرایی</h2>

        <div class="mb-5 gallery1">
            <a href="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" data-pswp-width="16384" data-pswp-height="5663">
                <img src="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" class="img-fluid rounded shadow-lg" style="cursor:zoom-in" alt="گردش کاری">
            </a>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('photoswipe-5.4.4/umd/photoswipe.umd.min.js') }}"></script>
    <script src="{{ asset('photoswipe-5.4.4/umd/photoswipe-lightbox.umd.min.js') }}"></script>

    <script>
        const lightbox1 = new PhotoSwipeLightbox({
            gallery: '.gallery1',
            children: 'a',
            pswpModule: PhotoSwipe,
            wheelToZoom: true,
            initialZoomLevel: 'fit',
            maxZoomLevel: 0.5,
        });
        lightbox1.init();
    </script>
@endsection
