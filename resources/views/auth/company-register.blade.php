{{-- <x-guest-layout>
    <form method="POST" action="{{ route('company.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="company_name" :value="__('Comapny Name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')"
                required autofocus autocomplete="company_name" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="city" :value="__('Company Address (city)')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"
                required autofocus autocomplete="city" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Company Contact Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <x-text-input type="hidden" id="type" name="type" value="company" />

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="A Tailwind CSS PHP admin template is a pre-designed web page for an admin dashboard. Optimizing it for SEO includes using meta descriptions and ensuring it's responsive and fast-loading">
    <meta name="keywords"
        content="admin, php, php admin panel template, admin dashboard template, tailwind, tailwind dashboard template, phpmyadmin, admin template, php admin dashboard, admin dashboard php, php admin template, php admin dashboard template, admin panel design in php, admin panel php template, php admin dashboard">

    <!-- TITLE -->
    <title>Registration - Job Finder</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex h-full !py-0 bg-white dark:bg-bgdark">

    <!-- MAIN-CONTENT -->

    <div class="grid grid-cols-12 gap-6 w-full">
        <div class="lg:col-span-6 col-span-12 hidden lg:block relative">
            <div class="cover relative w-full h-full z-[1] p-10">
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
                                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Comapny Sign up</h1>
                                <p class="mt-3 text-sm text-gray-600 dark:text-white/70">
                                    Sign up as a user?
                                    <a class="text-primary decoration-2 hover:underline font-medium"
                                        href="{{ route('register') }}">
                                        Sign up here
                                    </a>
                                </p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-white/70">
                                    Already have an account?
                                    <a class="text-primary decoration-2 hover:underline font-medium"
                                        href="{{ route('login') }}">
                                        Sign in here
                                    </a>
                                </p>
                            </div>

                            <div class="mt-5">
                                <button type="button"
                                    class="w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-sm border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-offset-white focus:ring-primary transition-all text-sm dark:bg-bgdark dark:hover:bg-black/20 dark:border-white/10 dark:text-white/70 dark:hover:text-white dark:focus:ring-offset-white/10">
                                    <img src="../assets/img/authentication/social/1.png" class="w-4 h-4"
                                        alt="google-img">Sign in with Google
                                </button>

                                <div
                                    class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 ltr:before:mr-6 rtl:before:ml-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 ltr:after:ml-6 rtl:after:mr-6 dark:text-white/70 dark:before:border-white/10 dark:after:border-white/10">
                                    Or</div>

                                <!-- Form -->
                                <form method="POST" action="{{ route('company.register') }}">
                                    @csrf

                                    <div class="grid gap-y-4">

                                        <!-- First Name -->
                                        <div>
                                            <label class="block text-sm mb-2 dark:text-white">Company Name</label>
                                            <div class="relative">
                                                <input type="text" name="company_name" placeholder="Enter your company name"
                                                    value="{{ old('company_name') }}"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required autofocus>
                                            </div>
                                        </div>


                                        <!-- Email -->
                                        <div>
                                            <label class="block text-sm mb-2 dark:text-white">Email address</label>
                                            <div class="relative">
                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required>
                                            </div>
                                        </div>


                                        <!-- First Name -->
                                       <div>
                                            <label class="block text-sm mb-2 dark:text-white">City</label>
                                            <div class="relative">
                                                <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter company City"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- First Name -->
                                        <div>
                                            <label class="block text-sm mb-2 dark:text-white">Company Contact
                                                Number</label>
                                            <div class="relative">
                                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter your company contact number"
                                                    pattern="[0-9]{11}" title="Enter 11 digit number like 03001234567"
                                                    maxlength="11"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div>
                                            <label for="password"
                                                class="block text-sm mb-2 dark:text-white">Password</label>
                                            <div class="relative">
                                                <input type="password" id="password" name="password"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div>
                                            <label for="confirm-password"
                                                class="block text-sm mb-2 dark:text-white">Confirm Password</label>
                                            <div class="relative">
                                                <input type="password" id="confirm-password"
                                                    name="password_confirmation"
                                                    class="py-2 px-3 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Submit -->
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

    <!-- END MAIN-CONTENT -->

    <!-- SCRIPTS -->
    <!-- SCRIPTS -->
    <script src="{{ asset('assets/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/js/custom-switcher.js') }}"></script>
    <!-- END SCRIPTS -->
</body>

</html>
