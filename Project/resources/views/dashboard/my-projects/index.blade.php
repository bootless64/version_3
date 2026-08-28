@extends('dashboard.index')

@section('title')
    <title>پروژه‌های من</title>
@endsection

@section('dashboard_style')
    
@endsection

@section('dashboard_content')

    <div class="container py-4 px-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">پروژه‌های من</a>
        </div>

        <h2 class="mb-5 text-center">پروژه‌های من</h2>

        <hr>
        <h4 class="text-center my-3">پروژه‌های درخواستی من:</h4>
        <hr>
        <div class="row gy-4 mb-5">
            @forelse($projects_as_applicant as $project)
                <div class="d-flex col-md-6">
                    <div class="card shadow-lg w-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>

                            <p class="text-muted">مسئول اصلی پروژه: {{ $project->primaryCoach->name }}</p>

                            <p class="card-text">{{ Str::limit($project->request_submission, 200, '...') }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('dashboard.my-projects.reports', $project->id) }}" class="btn btn-primary ms-1">مشاهده گزارش</a>
                                <a href="{{ route('dashboard.my-projects.tickets', $project->id) }}" class="btn btn-outline-dark">تیکت‌های پروژه</a>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="alert alert-warning text-center">
                    پروژه‌ای یافت نشد.
                </div>
            @endforelse

        </div>

        @if ($projects_as_coach->isNotEmpty())
            <hr>
            <h4 class="text-center my-3">پروژه‌های تحت مسئولیت من:</h4>
            <hr>
            <div class="row gy-4 mb-5">
                @forelse($projects_as_coach as $project)
                    <div class="d-flex col-md-6">
                        <div class="card shadow-lg w-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $project->title }}</h5>

                                <p class="text-muted">متقاضی پروژه: {{ $project->applicant->name }}</p>

                                <p class="card-text">{{ Str::limit($project->request_submission, 200, '...') }}</p>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('dashboard.my-projects.reports', $project->id) }}" class="btn btn-primary ms-1">مشاهده گزارش</a>
                                    <a href="{{ route('dashboard.my-projects.tickets', $project->id) }}" class="btn btn-outline-dark">تیکت‌های پروژه</a>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="alert alert-warning text-center">
                        پروژه‌ای یافت نشد.
                    </div>
                @endforelse
            </div>
        @endif

    </div>

@endsection
