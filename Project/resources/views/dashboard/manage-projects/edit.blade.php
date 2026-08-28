@extends('dashboard.index')

@section('title')
    <title>ویرایش پروژه</title>
@endsection

@section('dashboard_content')
    <div class="container p-4 mb-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-projects.index') }}">مدیریت پروژه‌ها</a><span class="px-1"> > </span>
            <a href="#">ویرایش</a>
        </div>

        <h2 class="mb-4">ویرایش پروژه</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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

        <form method="POST" action="{{ route('dashboard.manage-projects.update', $project->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row mb-3">
                <label for="applicant_id" class="col-form-label col-md-2 col-6">ID متقاضی: </label>
                <div class="col-md-3 col-6">
                    <input type="text" name="applicant_id" id="applicant_id" value="{{ old('applicant_id', $project->applicant_id) }}" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <label for="assessment_request_id" class="col-form-label col-md-2 col-6">ID درخواست: </label>
                <div class="col-md-3 col-6">
                    <input type="text" name="assessment_request_id" id="assessment_request_id" value="{{ old('assessment_request_id', $project->assessment_request_id) }}" class="form-control">
                </div>
            </div>

            <div class="row my-5 gy-2">
                <label for="primary_coach_id" class="col-form-label col-md-2 col-6">مسئول اصلی: </label>
                <div class="col-md-3 col-6">
                    <select name="primary_coach_id" class="form-select">
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('primary_coach_id', $project->primary_coach_id) == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="secondary_coach_id" class="col-form-label col-md-2 col-6 me-md-5">مسئول دوم: </label>
                <div class="col-md-3 col-6">
                    <select name="secondary_coach_id" class="form-select">
                        <option value=""></option>
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('secondary_coach_id', $project->secondary_coach_id) == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="title" class="col-form-label">عنوان پروژه: </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" class="form-control">
            </div>

            <div class="row my-5">
                <label for="status" class="col-form-label col-md-2 col-6">وضعیت فعلی: </label>
                <div class="col-md-3 col-6">
                    <select name="status" class="form-select">
                        <option value="request_submission" {{ old('status', $project->status) === 'request_submission' ? 'selected' : '' }}>ثبت درخواست</option>
                        <option value="initial_audit" {{ old('status', $project->status) === 'initial_audit' ? 'selected' : '' }}>ممیزی اولیه</option>
                        <option value="contract_signing" {{ old('status', $project->status) === 'contract_signing' ? 'selected' : '' }}>انعقاد توافق‌نامه</option>
                        <option value="testing_and_monitoring" {{ old('status', $project->status) === 'testing_and_monitoring' ? 'selected' : '' }}>تست و پایش</option>
                        <option value="final_confirmation" {{ old('status', $project->status) === 'final_confirmation' ? 'selected' : '' }}>تایید نهایی</option>
                        <option value="final_report_submission" {{ old('status', $project->status) === 'final_report_submission' ? 'selected' : '' }}>ارائه گزارش نهایی</option>
                        <option value="end_of_contract" {{ old('status', $project->status) === 'end_of_contract' ? 'selected' : '' }}>پایان توافق‌نامه</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <label for="request_submission" class="col-form-label">ثبت درخواست</label>
                <textarea name="request_submission" id="request_submission" class="form-control" rows="4">{{ old('request_submission', $project->request_submission) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="request_submission_file" class="col-form-label">تغییر فایل ثبت درخواست</label>
                <input type="file" name="request_submission_file" id="request_submission_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->request_submission_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->request_submission_file]) }}">{{ $project->request_submission_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_request_submission_file" value="1" id="remove_request_submission_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_request_submission_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="initial_audit" class="col-form-label">ممیزی اولیه</label>
                <textarea name="initial_audit" id="initial_audit" class="form-control" rows="4">{{ old('initial_audit', $project->initial_audit) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="initial_audit_file" class="col-form-label">تغییر فایل ممیزی اولیه</label>
                <input type="file" name="initial_audit_file" id="initial_audit_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->initial_audit_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->initial_audit_file]) }}">{{ $project->initial_audit_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_initial_audit_file" value="1" id="remove_initial_audit_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_initial_audit_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="contract_signing" class="col-form-label">انعقاد توافق‌نامه</label>
                <textarea name="contract_signing" id="contract_signing" class="form-control" rows="4">{{ old('contract_signing', $project->contract_signing) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="contract_signing_file" class="col-form-label">تغییر فایل انعقاد توافق‌نامه</label>
                <input type="file" name="contract_signing_file" id="contract_signing_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->contract_signing_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->contract_signing_file]) }}">{{ $project->contract_signing_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_contract_signing_file" value="1" id="remove_contract_signing_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_contract_signing_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="testing_and_monitoring" class="col-form-label">تست و پایش</label>
                <textarea name="testing_and_monitoring" id="testing_and_monitoring" class="form-control" rows="4">{{ old('testing_and_monitoring', $project->testing_and_monitoring) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="testing_and_monitoring_file" class="col-form-label">تغییر فایل تست و پایش</label>
                <input type="file" name="testing_and_monitoring_file" id="testing_and_monitoring_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->testing_and_monitoring_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->testing_and_monitoring_file]) }}">{{ $project->testing_and_monitoring_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_testing_and_monitoring_file" value="1" id="remove_testing_and_monitoring_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_testing_and_monitoring_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="final_confirmation" class="col-form-label">تایید نهایی</label>
                <textarea name="final_confirmation" id="final_confirmation" class="form-control" rows="4">{{ old('final_confirmation', $project->final_confirmation) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="final_confirmation_file" class="col-form-label">تغییر فایل تایید نهایی</label>
                <input type="file" name="final_confirmation_file" id="final_confirmation_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->final_confirmation_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->final_confirmation_file]) }}">{{ $project->final_confirmation_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_final_confirmation_file" value="1" id="remove_final_confirmation_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_final_confirmation_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="final_report_submission" class="col-form-label">ارائه گزارش نهایی</label>
                <textarea name="final_report_submission" id="final_report_submission" class="form-control" rows="4">{{ old('final_report_submission', $project->final_report_submission) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="final_report_submission_file" class="col-form-label">تغییر فایل ارائه گزارش نهایی</label>
                <input type="file" name="final_report_submission_file" id="final_report_submission_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->final_report_submission_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->final_report_submission_file]) }}">{{ $project->final_report_submission_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_final_report_submission_file" value="1" id="remove_final_report_submission_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_final_report_submission_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="mb-2">
                <label for="end_of_contract" class="col-form-label">پایان توافق‌نامه</label>
                <textarea name="end_of_contract" id="end_of_contract" class="form-control" rows="4">{{ old('end_of_contract', $project->end_of_contract) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="end_of_contract_file" class="col-form-label">تغییر فایل پایان توافق‌نامه</label>
                <input type="file" name="end_of_contract_file" id="end_of_contract_file" class="form-control" accept=".pdf, .doc, .docx">
                @if ($project->end_of_contract_file)
                    <div class="mt-1">فایل فعلی:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.download-file', [$project->id, $project->end_of_contract_file]) }}">{{ $project->end_of_contract_file }}</a>
                    </div>
                    <div class="mt-1">
                        <input type="checkbox" name="remove_end_of_contract_file" value="1" id="remove_end_of_contract_file" class="form-check-input border-dark">
                        <label class="form-check-label" for="remove_end_of_contract_file">حذف فایل فعلی</label>
                    </div>
                @endif
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-primary mx-auto">ویرایش پروژه</button>
            </div>
        </form>
    </div>
@endsection
