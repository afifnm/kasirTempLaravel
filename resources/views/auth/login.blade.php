<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link href="{{ asset('midone/dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login Page')</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('midone/dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
</head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img class="w-6" src="{{ asset('midone') }}/dist/images/logo.svg">
                        <span class="text-white text-lg ml-3"> Kasir<span class="font-medium">App</span> </span>
                    </a>
                    <div class="my-auto">
                        <img class="-intro-x w-1/2 -mt-16" src="{{ asset('midone') }}/dist/images/illustration.svg">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            Welcome to App Kasir
                        </div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Sign In
                        </h2>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="intro-x mt-8">
                                <input type="email" name="email" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Email">
                                <input type="password" name="password" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password">
                            </div>
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
        <!-- BEGIN: JS Assets-->
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
        <!-- END: JS Assets-->
    </body>
</html>