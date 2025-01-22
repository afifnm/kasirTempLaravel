<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('midone/dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title','Laravel App')</title>
        <link rel="stylesheet" href="{{ asset('midone/dist/css/app.css') }}" />
    </head>
    <!-- END: Head -->
    <body class="app">
        <!-- BEGIN: Top Bar -->
        <div class="border-b border-theme-24 -mt-10 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
            <div class="top-bar-boxed flex items-center">
                <!-- BEGIN: Logo -->
                <a href="" class="-intro-x hidden md:flex">
                    <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{ asset('midone/dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> Kasir<span class="font-medium">App</span> </span>
                </a>
                <!-- END: Logo -->
                <!-- BEGIN: Breadcrumb -->
                <div class="-intro-x breadcrumb breadcrumb--light mr-auto"> <a href="" class="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{$title}}</a> </div>
                <!-- END: Breadcrumb -->
                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8 relative">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110">
                        <img alt="Midone Tailwind HTML Admin Template" src="{{ asset('midone/dist/images/profile-6.jpg') }}">
                    </div>
                    <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                        <div class="dropdown-box__content box bg-theme-38 text-white">
                            <div class="p-4 border-b border-theme-40">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-theme-41">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="p-2">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                            </div>
                            <div class="p-2 border-t border-theme-40">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
        </div>
        <!-- END: Top Bar -->
        <!-- BEGIN: Top Menu -->
        <nav class="top-nav">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="top-menu top-menu--{{ Request::is('/') ? 'active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Dashboard </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user') }}" class="top-menu top-menu--{{ Request::is('user') ? 'active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="users"></i> </div>
                        <div class="top-menu__title"> User </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product') }}" class="top-menu top-menu--{{ Request::is('product') ? 'active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                        <div class="top-menu__title"> Product </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaction') }}" class="top-menu top-menu--{{ Request::is('transaction*') ? 'active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="book"></i> </div>
                        <div class="top-menu__title"> Transaction </div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END: Top Menu -->
        <div class="content">
            @yield('content')
        </div>
        <script src="{{ asset('midone/dist/js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('alert'))
        <script>
            Swal.fire({
                title: 'Information!',
                text: '{{ session('alert') }}',
                icon: '{{ session('icon') }}',
                confirmButtonText: 'OK'
            });
        </script>
        @endif
    </body>
</html>