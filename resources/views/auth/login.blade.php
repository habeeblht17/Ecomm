<x-guest-layout>
    <!-- Login card  -->
    <section class="mx-auto flex-grow w-full mt-10 mb-10 max-w-[1200px] px-5">
        <div class="container mx-auto border px-5 py-5 shadow-sm md:w-1/2">
            <div class="">
                <p class="text-4xl font-bold">LOGIN</p>
                <p>Welcome back, customer!</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
        
            <form method="POST" action="{{ route('login') }}" class="mt-6 flex flex-col">
                @csrf

                <label for="email">Email Address</label>
                <input class="mb-3 mt-3 border px-4 py-2" type="email" name="email" :value="old('email')" required placeholder="youremail@domain.com"/>

                <label for="email">Password</label>
                <input class="mt-3 border px-4 py-2" type="password" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;"/>

                <div class="mt-4 flex justify-between">
                    <div class="flex gap-2">
                        <input type="checkbox"  name="remember" />
                        <label for="checkbox" class="-mt-1">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <div>
                            <a href="{{ route('password.request') }}" class="text-violet-900">Forgot password</a>
                        </div>
                    @endif

                </div>

                <button class="my-5 w-full bg-violet-900 py-2 text-white">
                    LOGIN
                </button>
            </form>

            <p class="text-center text-gray-500">OR LOGIN WITH</p>

            <div class="my-5 flex gap-2">
                <button class="w-1/2 bg-blue-800 py-2 text-white">FACEBOOK</button>
                <button class="w-1/2 bg-orange-500 py-2 text-white">GOOGLE</button>
            </div>

            <p class="text-center">
                Don`t have account?
                <a href="{{ route('register') }}" class="text-violet-900">Register now</a>
            </p>
        </div>
    </section>
    <!-- /Login Card  -->
</x-guest-layout>

{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
