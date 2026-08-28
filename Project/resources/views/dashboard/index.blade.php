@extends('layouts.app')

@section('title')
    <title>داشبورد</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/dashboard/index.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/dashboard/index.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/dashboard/index.css') }}" rel="stylesheet">
    @endif

    @yield('dashboard_style')
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar-wrapper {
            width: 280px;
            flex-shrink: 0;
        }
        .content-wrapper {
            flex: 1;
            width: calc(100% - 280px);
        }
        @media (max-width: 992px) {
            .sidebar-wrapper {
                position: fixed;
                top: 0;
                right: -280px;
                height: 100vh;
                z-index: 1050;
                transition: right 0.3s ease;
            }
            .sidebar-wrapper.show {
                right: 0;
            }
            .content-wrapper {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')

    <div class="dashboard-container">

        <button class="btn btn-primary d-lg-none position-fixed top-50 end-0 translate-middle-y" style="z-index: 1060;"
            id="menuButton" type="button">
            منو
        </button>

        <div class="sidebar-wrapper bg-light border" id="sidebarMenu">
            <div class="d-flex flex-column p-2" style="height: 100vh; overflow-y: auto;">

                <div class="d-lg-none text-end p-2">
                    <button type="button" class="btn-close" id="closeMenuButton"></button>
                </div>

                <ul class="nav nav-pills flex-column w-100 pe-0 pt-lg-3 text-center">

                    <li class="nav-item border-bottom">
                        <a href="{{ route('dashboard.my-profile.index') }}"
                            class="nav-link {{ Route::is('dashboard.my-profile.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                            پروفایل من
                        </a>
                    </li>

                    @php
                        $user = auth()->user();
                    @endphp

                    @if($user->can('manage_users') || $user->can('manage_roles') || $user->can('manage_projects') || $user->can('manage_news') || $user->can('manage_articles') || $user->can('manage_sliders') || $user->can('manage_comments') || $user->can('manage_tickets') || $user->can('manage_logs') || $user->can('manage_consultations'))

                        <li class="nav-item border-bottom">
                            <a class="nav-link" data-bs-toggle="collapse" href="#managementPanel" role="button">
                                <b>پنل مدیریت</b>
                            </a>
                            <div id="managementPanel" class="collapse">
                                <ul class="list-unstyled px-0 pb-3">
                                    @can('manage_settings')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.settings.index') }}"
                                                class="nav-link {{ Route::is('dashboard.settings.*') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                تنظیمات پسورد
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage_users')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-users.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-users.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت کاربران
                                            </a>
                                        </li>
                                        @endcan
                                        
                                        @can('manage_roles')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-roles.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-roles.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت نقش‌ها
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_projects')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-projects.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-projects.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت پروژه‌ها
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage_news')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-news.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-news.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت خبرها
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_articles')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-articles.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-articles.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت مقاله‌ها
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_sliders')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-sliders.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-sliders.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت اسلایدرها
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage_orders')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-orders.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-orders.*') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت سفارشات
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_comments')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-comments.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-comments.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت کامنت‌ها
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_tickets')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-tickets.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-tickets.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                مدیریت تیکت‌ها
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage_consultations')
                                        <li class="nav-item border-bottom">
                                            <a href="{{ route('dashboard.manage-consultations.index') }}"
                                                class="nav-link {{ Route::is('dashboard.manage-consultations.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                                درخواست‌های مشاوره
                                                @php
                                                    $pendingConsultations = \App\Models\ConsultationRequest::where('status','pending')->count();
                                                @endphp
                                                @if($pendingConsultations > 0)
                                                    <span class="badge bg-warning text-dark">{{ $pendingConsultations }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endcan

                                @can('manage_logs')
                                    <li class="nav-item border-bottom">
                                        <a href="{{ route('dashboard.manage-logs.index') }}"
                                            class="nav-link {{ Route::is('dashboard.manage-logs.*') ? 'bg-secondary bg-opacity-25' : '' }}">
                                            مدیریت لاگ‌های سیستم
                                        </a>
                                    </li>
                                @endcan
                                </ul>
                            </div>
                        </li>

                    @endif

                    @can('submit_news')
                        <li class="nav-item border-bottom">
                            <a href="{{ route('dashboard.submit-news.create') }}"
                                class="nav-link {{ Route::is('dashboard.submit-news.create') ? 'bg-secondary bg-opacity-25' : '' }}">
                                ثبت خبر
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item border-bottom">
                        <a href="{{ route('dashboard.requests.index') }}"
                            class="nav-link {{ Route::is('dashboard.requests.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                            درخواست‌ها
                        </a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a href="{{ route('dashboard.my-orders') }}"
                            class="nav-link {{ Route::is('dashboard.my-orders') ? 'bg-secondary bg-opacity-25' : '' }}">
                            سفارشات من
                        </a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a href="{{ route('dashboard.my-projects.index') }}"
                            class="nav-link {{ Route::is('dashboard.my-projects.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                            پروژه‌های من
                        </a>
                    </li>
                        @can('manage_support_tickets')
                            <li class="nav-item border-bottom">
                                <a href="{{ route('dashboard.manage-support-tickets.index') }}"
                                    class="nav-link {{ Route::is('dashboard.manage-support-tickets.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                    تیکت‌های پشتیبانی
                                </a>
                            </li>
                        @endcan

                    <li class="nav-item border-bottom">
                        <a href="{{ route('dashboard.my-tickets.index') }}"
                            class="nav-link {{ Route::is('dashboard.my-tickets.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                            تیکت‌های من
                        </a>
                    </li>

                    @can('submit_article')
                        <li class="nav-item border-bottom">
                            <a href="{{ route('dashboard.my-articles.index') }}"
                                class="nav-link {{ Route::is('dashboard.my-articles.index') ? 'bg-secondary bg-opacity-25' : '' }}">
                                مقاله‌های من
                            </a>
                        </li>
                    @endcan

                </ul>
            </div>
        </div>

        <div class="content-wrapper">
            @yield('dashboard_content')
        </div>

    </div>

    <script>
        document.getElementById('menuButton')?.addEventListener('click', function() {
            document.getElementById('sidebarMenu').classList.add('show');
        });
        document.getElementById('closeMenuButton')?.addEventListener('click', function() {
            document.getElementById('sidebarMenu').classList.remove('show');
        });
    </script>

@endsection

@section('script')
    @yield('dashboard_script')
@endsection