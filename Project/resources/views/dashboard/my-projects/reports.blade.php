@extends('dashboard.index')

@section('title')
    <title>گزارشات پروژه</title>
@endsection

@section('dashboard_style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/dashboard/my-projects/reports.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/dashboard/my-projects/reports.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/dashboard/my-projects/reports.css') }}" rel="stylesheet">
    @endif
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.my-projects.index') }}">پروژه‌های من</a><span class="px-1"> > </span>
            <a href="#">مشاهده گزارش</a>
        </div>

        <h2 class="mb-5 text-center">گزارشات پروژه</h2>

        <div class="d-flex justify-content-center mb-5">
            <div dir="ltr" class="overflow-auto diagram-container">
                <div class="d-flex align-items-center process-flow">
                    <a href="#request_submission" class="{{ $project->status === 'request_submission' ? 'active-state' : '' }}">ثبت درخواست</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#initial_audit" class="{{ $project->status === 'initial_audit' ? 'active-state' : '' }}">ممیزی اولیه</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#contract_signing" class="{{ $project->status === 'contract_signing' ? 'active-state' : '' }}">انعقاد توافق‌نامه</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#testing_and_monitoring" class="{{ $project->status === 'testing_and_monitoring' ? 'active-state' : '' }}">تست و پایش</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#final_confirmation" class="{{ $project->status === 'final_confirmation' ? 'active-state' : '' }}">تایید نهایی</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#final_report_submission" class="{{ $project->status === 'final_report_submission' ? 'active-state' : '' }}">ارائه گزارش نهایی</a>
                    <div>
                        <img src="{{ asset('icons/next-arrow-black.svg') }}">
                    </div>

                    <a href="#end_of_contract" class="{{ $project->status === 'end_of_contract' ? 'active-state' : '' }}">پایان توافق‌نامه</a>
                </div>
            </div>
        </div>

        <div class="px-5 mb-5" style="text-align: justify">
            <div>
                <h5 id="request_submission">ثبت درخواست</h5>
                {!! nl2br(e($project->request_submission)) !!}

                @if ($project->request_submission_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->request_submission_file]) }}">{{ $project->request_submission_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="initial_audit">ممیزی اولیه</h5>
                {!! nl2br(e($project->initial_audit)) !!}

                @if ($project->initial_audit_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->initial_audit_file]) }}">{{ $project->initial_audit_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="contract_signing">انعقاد توافق‌نامه</h5>
                {!! nl2br(e($project->contract_signing)) !!}

                @if ($project->contract_signing_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->contract_signing_file]) }}">{{ $project->contract_signing_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="testing_and_monitoring">تست و پایش</h5>
                {!! nl2br(e($project->testing_and_monitoring)) !!}

                @if ($project->testing_and_monitoring_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->testing_and_monitoring_file]) }}">{{ $project->testing_and_monitoring_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="final_confirmation">تایید نهایی</h5>
                {!! nl2br(e($project->final_confirmation)) !!}

                @if ($project->final_confirmation_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->final_confirmation_file]) }}">{{ $project->final_confirmation_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="final_report_submission">ارائه گزارش نهایی</h5>
                {!! nl2br(e($project->final_report_submission)) !!}

                @if ($project->final_report_submission_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->final_report_submission_file]) }}">{{ $project->final_report_submission_file }}</a>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            <div>
                <h5 id="end_of_contract">پایان توافق‌نامه</h5>
                {!! nl2br(e($project->end_of_contract)) !!}

                @if ($project->end_of_contract_file)
                    <div class="mt-1">فایل پیوست:
                        <a dir="ltr" href="{{ route('dashboard.my-projects.reports.download-file', [$project->id, $project->end_of_contract_file]) }}">{{ $project->end_of_contract_file }}</a>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
