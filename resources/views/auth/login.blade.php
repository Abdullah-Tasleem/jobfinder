{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full">


<!-- Mirrored from php.spruko.com/synto/synto/pages/signin-cover2.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Aug 2025 12:55:24 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="A Tailwind CSS PHP admin template is a pre-designed web page for an admin dashboard. Optimizing it for SEO includes using meta descriptions and ensuring it's responsive and fast-loading">
    <meta name="keywords"
        content="admin, php, php admin panel template, admin dashboard template, tailwind, tailwind dashboard template, phpmyadmin, admin template, php admin dashboard, admin dashboard php, php admin template, php admin dashboard template, admin panel design in php, admin panel php template, php admin dashboard">

    <title>Login - Job Finder</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="error-page flex h-full !py-0 bg-white dark:bg-bgdark">

    <!-- MAIN-CONTENT -->

    <div class="grid grid-cols-12 gap-6 w-full">
        <div class="lg:col-span-6 col-span-12 hidden lg:block relative">
            <div class="cover relative w-full h-full z-[1] p-10">
                {{-- <a href="index.html" class="header- logo">
                    <img src="../assets/img/brand-logos/desktop-light.png" alt="logo"
                        class="ltr:ml-auto rtl:mr-auto block">
                </a> --}}
                <div class="authentication-page justify-center w-full max-w-7xl mx-auto p-0">
                    <img src="../assets/img/authentication/2.png" alt="logo" class="mx-auto h-[500px]">
                </div>
            </div>
        </div>
        <div class="lg:col-span-6 col-span-12">
            <div class="authentication-page w-full">
                <!-- ========== MAIN CONTENT ========== -->
                <main id="content" class="w-full max-w-md mx-auto p-6">
                    <a href="index.html" class="header-logo lg:hidden">
                        <img src="../assets/img/brand-logos/desktop-logo.png" alt="logo"
                            class="mx-auto block dark:hidden">
                        <img src="../assets/img/brand-logos/desktop-dark.png" alt="logo"
                            class="mx-auto hidden dark:block">
                    </a>
                    <div class="mt-7">
                        <div class="p-4 sm:p-7">
                            <div class="text-center">
                                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
                                <p class="mt-3 text-sm text-gray-600 dark:text-white/70">
                                    Don't have an account yet?
                                    <a class="text-primary decoration-2 hover:underline font-medium"
                                        href="{{ route('register') }}">
                                        Sign up here
                                    </a>
                                </p>
                            </div>


                            <div class="mt-5">
                                <a href="/auth/google/redirect"
                                    class="w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-sm border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-offset-white focus:ring-primary transition-all text-sm dark:bg-bgdark dark:hover:bg-black/20 dark:border-white/10 dark:text-white/70 dark:hover:text-white dark:focus:ring-offset-white/10">
                                    <img src="{{ asset('assets/img/authentication/social/1.png') }}" class="w-4 h-4"
                                        alt="google-img">
                                    Sign in with Google
                                </a>

                                <a href="/auth/github/redirect"
                                    class="mt-2 w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-sm border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-offset-white focus:ring-primary transition-all text-sm dark:bg-bgdark dark:hover:bg-black/20 dark:border-white/10 dark:text-white/70 dark:hover:text-white dark:focus:ring-offset-white/10">
                                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12 .5C5.37.5 0 5.87 0 12.5a12 12 0 0 0 8.21 11.42c.6.11.82-.26.82-.58v-2.15c-3.34.73-4.04-1.6-4.04-1.6-.54-1.38-1.32-1.74-1.32-1.74-1.08-.74.08-.72.08-.72 1.19.08 1.82 1.23 1.82 1.23 1.06 1.82 2.78 1.29 3.46.99.11-.77.42-1.29.76-1.59-2.66-.3-5.46-1.33-5.46-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.54-1.52.12-3.18 0 0 1-.32 3.29 1.23A11.47 11.47 0 0 1 12 6.84a11.47 11.47 0 0 1 3 .4c2.29-1.55 3.29-1.23 3.29-1.23.66 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.8 5.63-5.48 5.93.43.37.81 1.1.81 2.22v3.29c0 .32.21.69.82.58A12 12 0 0 0 24 12.5C24 5.87 18.63.5 12 .5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Sign in with GitHub
                                </a>


                                <div
                                    class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 ltr:before:mr-6 rtl:before:ml-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 ltr:after:ml-6 rtl:after:mr-6 dark:text-white/70 dark:before:border-white/10 dark:after:border-white/10">
                                    Or</div>

                                <!-- Form -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="grid gap-y-4">
                                        <!-- Form Group -->

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm mb-2 dark:text-white">Email
                                                address</label>
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email') }}"
                                                class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                required>
                                            {{-- @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror --}}
                                        </div>

                                        <!-- Password -->
                                        <div>
                                            <div class="flex justify-between items-center">
                                                <label for="password"
                                                    class="block text-sm mb-2 dark:text-white">Password</label>
                                                @if (Route::has('password.request'))
                                                    <a class="text-sm text-primary hover:underline font-medium"
                                                        href="{{ route('password.request') }}">
                                                        Forgot password?
                                                    </a>
                                                @endif
                                            </div>
                                            <input type="password" id="password" name="password"
                                                class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                required>
                                            @error('password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <button type="submit"
                                                class="w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-sm border border-transparent font-semibold bg-primary text-white hover:bg-primary focus:outline-none focus:ring-0 focus:ring-primary transition-all text-sm">
                                                Sign in
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div>
                </main>
                <!-- ========== END MAIN CONTENT ========== -->
            </div>
        </div>
    </div>

    <!-- END MAIN-CONTENT -->

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33',
            });
        </script>
    @endif
    <!-- SCRIPTS -->
    <script src="{{ asset('assets/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/js/custom-switcher.js') }}"></script>

    <!-- END SCRIPTS -->

</body>

<!-- Mirrored from php.spruko.com/synto/synto/pages/signin-cover2.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Aug 2025 12:55:24 GMT -->

</html>
<!-- This code use for render base file -->
