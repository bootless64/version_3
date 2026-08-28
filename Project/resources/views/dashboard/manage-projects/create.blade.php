@extends('dashboard.index')

@section('title')
    <title>ایجاد پروژه</title>
@endsection

@section('dashboard_content')

    <div class="container p-4 mb-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-projects.index') }}">مدیریت پروژه‌ها</a><span class="px-1"> > </span>
            <a href="#">ایجاد پروژه جدید</a>
        </div>

        <h2 class="mb-4">ایجاد پروژه</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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

        <form method="POST" action="{{ route('dashboard.manage-projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="applicant_id" class="col-form-label col-md-2 col-6">ID متقاضی: </label>
                <div class="col-md-3 col-6">
                    <input type="text" name="applicant_id" id="applicant_id" value="{{ old('applicant_id') }}" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <label for="assessment_request_id" class="col-form-label col-md-2 col-6">ID درخواست: </label>
                <div class="col-md-3 col-6">
                    <input type="text" name="assessment_request_id" id="assessment_request_id" value="{{ old('assessment_request_id') }}" class="form-control">
                </div>
            </div>

            <div class="row my-5 gy-2">
                <label for="primary_coach_id" class="col-form-label col-md-2 col-6">مسئول اصلی: </label>
                <div class="col-md-3 col-6">
                    <select name="primary_coach_id" class="form-select">
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('primary_coach_id') == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="secondary_coach_id" class="col-form-label col-md-2 col-6 me-md-5">مسئول دوم: </label>
                <div class="col-md-3 col-6">
                    <select name="secondary_coach_id" class="form-select">
                        <option value=""></option>
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('secondary_coach_id') == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="title" class="col-form-label">عنوان پروژه</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
            </div>

            <div class="row my-5">
                <label for="status" class="col-form-label col-md-2 col-6">وضعیت فعلی: </label>
                <div class="col-md-3 col-6">
                    <select name="status" class="form-select">
                        <option value="request_submission" {{ old('status') === 'request_submission' ? 'selected' : '' }}>ثبت درخواست</option>
                        <option value="initial_audit" {{ old('status') === 'initial_audit' ? 'selected' : '' }}>ممیزی اولیه</option>
                        <option value="contract_signing" {{ old('status') === 'contract_signing' ? 'selected' : '' }}>انعقاد توافق‌نامه</option>
                        <option value="testing_and_monitoring" {{ old('status') === 'testing_and_monitoring' ? 'selected' : '' }}>تست و پایش</option>
                        <option value="final_confirmation" {{ old('status') === 'final_confirmation' ? 'selected' : '' }}>تایید نهایی</option>
                        <option value="final_report_submission" {{ old('status') === 'final_report_submission' ? 'selected' : '' }}>ارائه گزارش نهایی</option>
                        <option value="end_of_contract" {{ old('status') === 'end_of_contract' ? 'selected' : '' }}>پایان توافق‌نامه</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <label for="request_submission" class="col-form-label">ثبت درخواست</label>
                <textarea name="request_submission" id="request_submission" class="form-control" rows="4">{{ old('request_submission') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="request_submission_file" class="col-form-label">فایل ثبت درخواست</label>
                <input type="file" name="request_submission_file" id="request_submission_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="initial_audit" class="col-form-label">ممیزی اولیه</label>
                <textarea name="initial_audit" id="initial_audit" class="form-control" rows="4">{{ old('initial_audit') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="initial_audit_file" class="col-form-label">فایل ممیزی اولیه</label>
                <input type="file" name="initial_audit_file" id="initial_audit_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="contract_signing" class="col-form-label">انعقاد توافق‌نامه</label>
                <textarea name="contract_signing" id="contract_signing" class="form-control" rows="4">{{ old('contract_signing') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="contract_signing_file" class="col-form-label">فایل انعقاد توافق‌نامه</label>
                <input type="file" name="contract_signing_file" id="contract_signing_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="testing_and_monitoring" class="col-form-label">تست و پایش</label>
                <textarea name="testing_and_monitoring" id="testing_and_monitoring" class="form-control" rows="4">{{ old('testing_and_monitoring') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="testing_and_monitoring_file" class="col-form-label">فایل تست و پایش</label>
                <input type="file" name="testing_and_monitoring_file" id="testing_and_monitoring_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="final_confirmation" class="col-form-label">تایید نهایی</label>
                <textarea name="final_confirmation" id="final_confirmation" class="form-control" rows="4">{{ old('final_confirmation') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="final_confirmation_file" class="col-form-label">فایل تایید نهایی</label>
                <input type="file" name="final_confirmation_file" id="final_confirmation_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="final_report_submission" class="col-form-label">ارائه گزارش نهایی</label>
                <textarea name="final_report_submission" id="final_report_submission" class="form-control" rows="4">{{ old('final_report_submission') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="final_report_submission_file" class="col-form-label">فایل ارائه گزارش نهایی</label>
                <input type="file" name="final_report_submission_file" id="final_report_submission_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-2">
                <label for="end_of_contract" class="col-form-label">پایان توافق‌نامه</label>
                <textarea name="end_of_contract" id="end_of_contract" class="form-control" rows="4">{{ old('end_of_contract') }}</textarea>
            </div>
            <div class="mb-5">
                <label for="end_of_contract_file" class="col-form-label">فایل پایان توافق‌نامه</label>
                <input type="file" name="end_of_contract_file" id="end_of_contract_file" class="form-control" accept=".pdf, .doc, .docx">
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-primary mx-auto">ایجاد پروژه</button>
            </div>
        </form>
    </div>

@endsection
