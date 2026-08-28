@extends('dashboard.index')

@section('title')
    <title>مدیریت اسلایدرها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت اسلایدرها</a>
        </div>

        <h2 class="mb-4">مدیریت اسلایدرها</h2>

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

        <button class="btn btn-outline-success mb-3" data-bs-toggle="collapse" data-bs-target="#createSlideForm">
            ایجاد اسلاید جدید
        </button>
        <div class="collapse" id="createSlideForm">
            <form method="POST" action="{{ route('dashboard.manage-sliders.store') }}" enctype="multipart/form-data" class="row gx-5 gy-2 mb-5">
                @csrf
                <label for="slide_number" class="col-form-label col-md-2">شماره اسلاید: </label>
                <div class="col-md-4">
                    <input type="number" id="slide_number" name="slide_number" value="{{ old('slide_number') }}" class="form-control">
                </div>

                <label for="image" class="col-form-label col-md-2">تصویر: </label>
                <div class="col-md-4">
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <label for="title" class="col-form-label col-md-2">عنوان اسلاید:</label>
                <div class="col-md-10">
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control">
                </div>

                <label for="description" class="col-form-label col-md-2">توضیحات: </label>
                <div class="col-md-10">
                    <input type="text" id="description" name="description" value="{{ old('description') }}" class="form-control">
                </div>

                <label for="button_text" class="col-form-label col-md-2">متن دکمه: </label>
                <div class="col-md-4">
                    <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}" class="form-control">
                </div>

                <label for="button_link" class="col-form-label col-md-2">لینک دکمه: </label>
                <div class="col-md-4">
                    <input type="text"  dir="ltr" id="button_link" name="button_link" value="{{ old('button_link') }}" class="form-control">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">ثبت</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse"
                        data-bs-target="#createSlideForm">
                        انصراف
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>شماره اسلاید</th>
                        <th>تصویر</th>
                        <th>عنوان اسلاید</th>
                        <th style="min-width: 150px">توضیحات</th>
                        <th>متن دکمه</th>
                        <th>لینک دکمه</th>
                        <th>امکانات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($slides as $slide)
                        <tr class="text-end">
                            <td>{{ $slide->slide_number }}</td>
                            <td dir="ltr" class="text-break">
                                <a target="_blank" href="{{ asset('storage/sliders/' . $slide->image) }}">{{ $slide->image }}</a>
                            </td>
                            <td>{{ $slide->title ?? '-' }}</td>
                            <td>{{ $slide->description ?? '-'}}</td>
                            <td>{{ $slide->button_text ?? '-'}}</td>
                            <td dir="ltr" class="text-break">
                                @if ($slide->button_link)
                                    <a target="_blank" href="{{ $slide->button_link }}">{{ $slide->button_link }}</a>
                                @else
                                    {{ '-' }}
                                @endif
                            </td>

                            <td>
                                <button class="btn btn-sm btn-outline-primary d-block mb-1" data-bs-toggle="collapse"
                                    data-bs-target="#editSlide{{ $slide->id }}">
                                    ویرایش
                                </button>

                                <form method="POST" action="{{ route('dashboard.manage-sliders.destroy', $slide->id) }}"
                                    class="d-inline" onsubmit="return confirm('آیا از حذف این اسلاید مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-block">حذف</button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="collapse container px-4" id="editSlide{{ $slide->id }}">
                                    <form method="POST" action="{{ route('dashboard.manage-sliders.update', $slide->id) }}" enctype="multipart/form-data" class="row gx-5 gy-2 p-2 mb-3">
                                        @csrf
                                        @method('PATCH')
                                        <label for="slide_number{{ $slide->id }}" class="col-form-label col-md-2">شماره اسلاید: </label>
                                        <div class="col-md-4">
                                            <input type="number" id="slide_number{{ $slide->id }}" name="slide_number" value="{{ old('slide_number', $slide->slide_number) }}" class="form-control">
                                        </div>

                                        <label for="image{{ $slide->id }}" class="col-form-label col-md-2">تصویر: </label>
                                        <div class="col-md-4">
                                            <input type="file" id="image{{ $slide->id }}" name="image" class="form-control">
                                        </div>

                                        <label for="title{{ $slide->id }}" class="col-form-label col-md-2">عنوان اسلاید:</label>
                                        <div class="col-md-10">
                                            <input type="text" id="title{{ $slide->id }}" name="title" value="{{ old('title', $slide->title) }}" class="form-control">
                                        </div>

                                        <label for="description{{ $slide->id }}" class="col-form-label col-md-2">توضیحات: </label>
                                        <div class="col-md-10">
                                            <input type="text" id="description{{ $slide->id }}" name="description" value="{{ old('description', $slide->description) }}" class="form-control">
                                        </div>

                                        <label for="button_text{{ $slide->id }}" class="col-form-label col-md-2">متن دکمه: </label>
                                        <div class="col-md-4">
                                            <input type="text" id="button_text{{ $slide->id }}" name="button_text" value="{{ old('button_text', $slide->button_text) }}" class="form-control">
                                        </div>

                                        <label for="button_link{{ $slide->id }}" class="col-form-label col-md-2">لینک دکمه: </label>
                                        <div class="col-md-4">
                                            <input type="text"  dir="ltr" id="button_link{{ $slide->id }}" name="button_link" value="{{ old('button_link', $slide->button_link) }}" class="form-control">
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-sm btn-success">ثبت</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse"
                                                data-bs-target="#editSlide{{ $slide->id }}">
                                                انصراف
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">هیچ اسلایدی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
