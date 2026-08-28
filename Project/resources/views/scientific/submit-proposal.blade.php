@extends('master')

@section('title')
    <title>پیشنهاد مقاله، پایان‌نامه و رساله | مرکز آسا</title>
@endsection

@section('style')
    <style>
        .page-header {
            background: linear-gradient(135deg, #1a472a, #2d7a3d, #4caf50);
            color: white;
            padding: 60px 0 40px;
        }
        .content-section {
            padding: 40px 0;
        }
        .proposal-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            background: white;
        }
        .guideline-list {
            list-style: none;
            padding: 0;
        }
        .guideline-list li {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .guideline-list li:before {
            content: "• ";
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .proposal-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 15px;
            background: #fafafa;
            transition: all 0.3s ease;
        }
        .proposal-item:hover {
            border-color: #2d7a3d;
        }

        .type-selector .btn-check:checked + .btn {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(45, 122, 61, 0.25);
        }

        .submission-form {
            transition: all 0.4s ease;
        }
        .hidden-form {
            display: none;
        }
    </style>
@endsection

@section('master_content')

    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">پیشنهاد مقاله، پایان‌نامه و رساله</h1>
            <p class="lead mt-2">مرکز پژوهشی آسا شرق از پژوهشگران، دانشجویان و اساتید محترم برای ارائه پیشنهادات پژوهشی در حوزه امنیت سایبری استقبال می‌نماید.</p>
        </div>
    </div>

    <div class="content-section">
        <div class="container">

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

            <div class="row">
                
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">انتخاب نوع ارسال</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-4 text-center type-selector">
                                <div class="row g-2" role="group" aria-label="نوع ارسال">
                                    <div class="col-md-3 col-sm-6">
                                        <input type="radio" class="btn-check" name="submission_type" id="type1" value="article" checked>
                                        <label class="btn btn-outline-primary w-100" for="type1">ثبت مقاله</label>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <input type="radio" class="btn-check" name="submission_type" id="type2" value="thesis">
                                        <label class="btn btn-outline-success w-100" for="type2">ثبت پایان‌نامه/رساله</label>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <input type="radio" class="btn-check" name="submission_type" id="type3" value="proposal_article">
                                        <label class="btn btn-outline-warning w-100" for="type3">پیشنهاد مقاله</label>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <input type="radio" class="btn-check" name="submission_type" id="type4" value="proposal_thesis">
                                        <label class="btn btn-outline-info w-100" for="type4">پیشنهاد پایان‌نامه/رساله</label>
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">یکی از گزینه‌های بالا را انتخاب کنید.</small>
                            </div>

                            <div id="articleForm" class="submission-form">
                                <h5 class="mb-3 text-center">فرم ثبت مقاله</h5>
                                <form method="POST" action="{{ route('submit-proposal.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="submission_type" value="article">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">عنوان مقاله <span class="text-danger">*</span></label>
                                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نویسندگان <span class="text-danger">*</span></label>
                                            <input type="text" name="authors" value="{{ old('authors') }}" class="form-control" placeholder="نام نویسندگان را با کاما جدا کنید" required>
                                            <small class="text-muted">مثال: دکتر احمد رضایی، دکتر مریم کریمی</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">کلمات کلیدی</label>
                                            <input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید">
                                            <small class="text-muted">مثال: امنیت سایبری، رمزنگاری، شبکه</small>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">توضیحات / چکیده مقاله</label>
                                            <textarea name="description" rows="4" class="form-control" placeholder="توضیحات مختصری درباره مقاله وارد کنید...">{{ old('description') }}</textarea>
                                            <small class="text-muted">حداکثر ۵۰۰ کاراکتر</small>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">نوع مقاله <span class="text-danger">*</span></label>
                                            <select name="type" class="form-select" required>
                                                <option value="">انتخاب کنید...</option>
                                                <option value="national" {{ old('type') == 'national' ? 'selected' : '' }}>بومی</option>
                                                <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>بین‌المللی</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">سال انتشار <span class="text-danger">*</span></label>
                                            <input type="text" name="publication_year" value="{{ old('publication_year') }}" class="form-control" placeholder="مثال: ۱۴۰۳ یا 2024" required>
                                            <small class="text-muted" id="yearHelp">بومی: شمسی | بین‌المللی: میلادی</small>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">وضعیت</label>
                                            <input type="text" class="form-control" value="در انتظار تایید" disabled>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل اصلی مقاله <span class="text-danger">*</span></label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                                            <small class="text-muted">فرمت‌های مجاز: PDF, DOC, DOCX | حداکثر ۳۰ مگابایت</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل چکیده مقاله</label>
                                            <input type="file" name="abstract_file" class="form-control" accept=".pdf,.doc,.docx">
                                            <small class="text-muted">فرمت‌های مجاز: PDF, DOC, DOCX | حداکثر ۲۰ مگابایت</small>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">ارسال مقاله</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">انصراف</a>
                                    </div>
                                </form>
                            </div>

                            <div id="thesisForm" class="submission-form hidden-form">
                                <h5 class="mb-3 text-center">فرم ثبت پایان‌نامه یا رساله</h5>
                                <form method="POST" action="{{ route('submit-proposal.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="submission_type" value="thesis">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نوع پایان‌نامه/رساله <span class="text-danger">*</span></label>
                                            <select name="thesis_type" class="form-select" required>
                                                <option value="">انتخاب کنید...</option>
                                                <option value="thesis">پایان‌نامه</option>
                                                <option value="dissertation">رساله</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">عنوان <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نام و نام خانوادگی <span class="text-danger">*</span></label>
                                            <input type="text" name="student_name" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نام استاد راهنما</label>
                                            <input type="text" name="supervisor" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">حوزه پژوهشی <span class="text-danger">*</span></label>
                                            <input type="text" name="research_field" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">کلمات کلیدی</label>
                                            <input type="text" name="keywords" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">سال دفاع <span class="text-danger">*</span></label>
                                            <input type="text" name="defense_year" class="form-control" placeholder="مثال: ۱۴۰۳" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">توضیحات</label>
                                            <textarea name="description" rows="2" class="form-control"></textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل پایان‌نامه/رساله <span class="text-danger">*</span></label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                                            <small class="text-muted">حداکثر ۳۰ مگابایت</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل چکیده <span class="text-danger">*</span></label>
                                            <input type="file" name="abstract_file" class="form-control" accept=".pdf,.doc,.docx" required>
                                            <small class="text-muted">حداکثر ۲۰ مگابایت</small>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">ارسال پایان‌نامه</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">انصراف</a>
                                    </div>
                                </form>
                            </div>

                            <div id="proposalArticleForm" class="submission-form hidden-form">
                                <h5 class="mb-3 text-center">فرم پیشنهاد مقاله</h5>
                                <form method="POST" action="{{ route('submit-proposal.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="submission_type" value="proposal_article">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">عنوان مقاله <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">توضیح عنوان <span class="text-danger">*</span></label>
                                            <textarea name="title_explanation" rows="3" class="form-control" required></textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">کلمات کلیدی</label>
                                            <input type="text" name="keywords" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل مقاله (در صورت موجود بودن)</label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                                            <small class="text-muted">حداکثر ۳۰ مگابایت</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">وضعیت مقاله مشابه <span class="text-danger">*</span></label>
                                            <select name="similar_status" id="similar_status_article" class="form-select" required>
                                                <option value="">انتخاب کنید...</option>
                                                <option value="does_not_exist">وجود ندارد</option>
                                                <option value="no_info">اطلاعی ندارم</option>
                                                <option value="exists">وجود دارد</option>
                                            </select>
                                        </div>

                                        <div class="col-12" id="similarDetailsArticle" style="display:none;">
                                            <div class="row mt-3 border rounded p-3">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">سال انتشار</label>
                                                    <input type="text" name="similar_year" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">محل انتشار</label>
                                                    <input type="text" name="similar_place" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">لینک فایل مقاله</label>
                                                    <input type="url" name="similar_link" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-warning">ارسال پیشنهاد مقاله</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">انصراف</a>
                                    </div>
                                </form>
                            </div>

                            <div id="proposalThesisForm" class="submission-form hidden-form">
                                <h5 class="mb-3 text-center">فرم پیشنهاد پایان‌نامه یا رساله</h5>
                                <form method="POST" action="{{ route('submit-proposal.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="submission_type" value="proposal_thesis">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نوع پایان‌نامه/رساله <span class="text-danger">*</span></label>
                                            <select name="thesis_type" class="form-select" required>
                                                <option value="">انتخاب کنید...</option>
                                                <option value="thesis">پایان‌نامه</option>
                                                <option value="dissertation">رساله</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">عنوان <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">توضیح عنوان <span class="text-danger">*</span></label>
                                            <textarea name="title_explanation" rows="3" class="form-control" required></textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">کلمات کلیدی</label>
                                            <input type="text" name="keywords" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">فایل (در صورت موجود بودن)</label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                                            <small class="text-muted">حداکثر ۳۰ مگابایت</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">وضعیت پایان‌نامه مشابه <span class="text-danger">*</span></label>
                                            <select name="similar_status" id="similar_status_thesis" class="form-select" required>
                                                <option value="">انتخاب کنید...</option>
                                                <option value="does_not_exist">وجود ندارد</option>
                                                <option value="no_info">اطلاعی ندارم</option>
                                                <option value="exists">وجود دارد</option>
                                            </select>
                                        </div>

                                        <div class="col-12" id="similarDetailsThesis" style="display:none;">
                                            <div class="row mt-3 border rounded p-3">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">سال دفاع</label>
                                                    <input type="text" name="similar_year" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">محل دفاع</label>
                                                    <input type="text" name="similar_place" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">لینک فایل</label>
                                                    <input type="url" name="similar_link" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-info">ارسال پیشنهاد پایان‌نامه</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">انصراف</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->check() && $proposals->count() > 0)
                <div class="row mt-5">
                    <div class="col-lg-8 mx-auto">
                        <h4 class="mb-3">پیشنهادات ارسال شده شما</h4>

                        @foreach($proposals as $proposal)
                            <div class="proposal-item">
                                <div class="d-flex justify-content-between align-items-start flex-wrap">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $proposal->title }}</h6>
                                        @php
                                            $submissionType = $proposal->submission_type ?? 'article';
                                            $submissionLabels = [
                                                'article' => 'ثبت مقاله',
                                                'thesis' => 'ثبت پایان‌نامه/رساله',
                                                'proposal_article' => 'پیشنهاد مقاله',
                                                'proposal_thesis' => 'پیشنهاد پایان‌نامه/رساله',
                                            ];
                                            $thesisTypeLabels = [
                                                'thesis' => 'پایان‌نامه',
                                                'dissertation' => 'رساله',
                                            ];
                                        @endphp

                                        <p class="small text-muted mb-1">
                                            <span class="fw-bold">نوع ارسال:</span> {{ $submissionLabels[$submissionType] ?? $submissionType }}
                                        </p>

                                        @if ($submissionType === 'article')
                                            <p class="small text-muted mb-1">
                                                <span class="fw-bold">نویسندگان:</span> {{ $proposal->authors ?? '—' }}
                                            </p>
                                            <p class="small text-muted mb-1">
                                                <span class="fw-bold">نوع مقاله:</span>
                                                {{ ($proposal->type ?? 'national') === 'national' ? 'بومی' : 'بین‌المللی' }} |
                                                <span class="fw-bold">سال:</span> {{ $proposal->publication_year ?: '—' }}
                                            </p>
                                        @elseif ($submissionType === 'thesis')
                                            <p class="small text-muted mb-1">
                                                <span class="fw-bold">نام:</span> {{ $proposal->student_name ?? $proposal->authors ?? '—' }}
                                            </p>
                                            <p class="small text-muted mb-1">
                                                <span class="fw-bold">نوع:</span> {{ $thesisTypeLabels[$proposal->thesis_type] ?? '—' }} |
                                                <span class="fw-bold">سال دفاع:</span> {{ $proposal->defense_year ?? $proposal->publication_year ?: '—' }}
                                            </p>
                                        @else
                                            <p class="small text-muted mb-1">
                                                <span class="fw-bold">توضیح:</span>
                                                {{ \Illuminate\Support\Str::limit($proposal->title_explanation ?? $proposal->description ?? '', 120) }}
                                            </p>
                                        @endif

                                        <p class="small text-muted mb-0">
                                            <span class="fw-bold">تاریخ ارسال:</span> 
                                            {{ $proposal->created_at->format('Y/m/d H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <span class="status-badge status-{{ $proposal->status }}">
                                            {{ $proposal->status_label }}
                                        </span>
                                        @if($proposal->status === 'pending')
                                            <form method="POST" action="{{ route('submit-proposal.destroy', $proposal->id) }}" 
                                                  class="d-inline" onsubmit="return confirm('آیا از حذف این پیشنهاد مطمئن هستید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger mt-2">
                                                    حذف
                                                </button>
                                            </form>
                                        @endif
                                        @if($proposal->admin_note)
                                            <p class="small text-danger mt-2 mb-0">
                                                <span class="fw-bold">توضیح مدیر:</span> {{ $proposal->admin_note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center mt-3">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="submission_type"]');
            const forms = {
                article: document.getElementById('articleForm'),
                thesis: document.getElementById('thesisForm'),
                proposal_article: document.getElementById('proposalArticleForm'),
                proposal_thesis: document.getElementById('proposalThesisForm')
            };

            function showActiveForm() {
                const selected = document.querySelector('input[name="submission_type"]:checked').value;
                Object.values(forms).forEach(form => {
                    if (form) {
                        form.classList.add('hidden-form');
                    }
                });
                if (forms[selected]) {
                    forms[selected].classList.remove('hidden-form');
                }
            }

            typeRadios.forEach(radio => {
                radio.addEventListener('change', showActiveForm);
            });

            const typeSelect = document.querySelector('select[name="type"]');
            const yearHelp = document.getElementById('yearHelp');
            if (typeSelect && yearHelp) {
                typeSelect.addEventListener('change', function() {
                    const type = this.value;
                    if (type === 'national') {
                        yearHelp.textContent = 'بومی: سال شمسی (۴ رقمی - مثال: ۱۴۰۳)';
                    } else if (type === 'international') {
                        yearHelp.textContent = 'بین‌المللی: سال میلادی (۴ رقمی - مثال: 2024)';
                    } else {
                        yearHelp.textContent = 'بومی: شمسی | بین‌المللی: میلادی';
                    }
                });
            }

            const similarSelectArticle = document.getElementById('similar_status_article');
            const similarDetailsArticle = document.getElementById('similarDetailsArticle');
            if (similarSelectArticle && similarDetailsArticle) {
                similarSelectArticle.addEventListener('change', function() {
                    similarDetailsArticle.style.display = this.value === 'exists' ? 'block' : 'none';
                });
            }

            const similarSelectThesis = document.getElementById('similar_status_thesis');
            const similarDetailsThesis = document.getElementById('similarDetailsThesis');
            if (similarSelectThesis && similarDetailsThesis) {
                similarSelectThesis.addEventListener('change', function() {
                    similarDetailsThesis.style.display = this.value === 'exists' ? 'block' : 'none';
                });
            }

            document.addEventListener('submit', function(e) {
                const activeForm = document.querySelector('.submission-form:not(.hidden-form)');
                const activeType = document.querySelector('input[name="submission_type"]:checked').value;

                const allRequired = document.querySelectorAll('[required]');
                allRequired.forEach(el => {
                    if (!activeForm.contains(el)) {
                        el.removeAttribute('required');
                        el.disabled = true;
                    }
                });
            });

            showActiveForm();
        });
    </script>
@endsection
