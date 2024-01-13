<x-guest-layout>
    <!-- Register card  -->
    <section class="mx-auto mt-10 w-full flex-grow mb-10 max-w-[1200px] px-5">
        <div class="container px-5 py-5 mx-auto border shadow-sm md:w-1/2">
            
            <div class="">
                <p class="text-4xl font-bold">CREATE AN ACCOUNT</p>
                <p>Register for new customer</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col mt-6">
                @csrf

                <label for="name">Full Name</label>
                <input class="px-4 py-2 mt-3 mb-3 border" type="text" name="name" :value="old('name')" placeholder="Bogdan Bulakh" required />

                <label class="mt-3" for="email">Email Address</label>
                <input class="px-4 py-2 mt-3 border" type="email" name="email" :value="old('email')" placeholder="user@mail.com" required />

                <label class="mt-5" for="email">Password</label>
                <input class="px-4 py-2 mt-3 border" type="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required />

                <label class="mt-5" for="email">Confirm password</label>
                <input class="px-4 py-2 mt-3 border" type="password" name="password_confirmation" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required />

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="flex mt-4 space-x-2">
                        <input type="checkbox" name="terms" id="terms" required />
                        <label for="checkbox" class="-mt-1">
                            I have read and agree to
                            <a href="{{ route('terms.show') }}" target="_blank" class="text-violet-900">{{ __('Terms of Service') }}</a> &amp;
                            <a href="{{ route('policy.show') }}" target="_blank" class="text-violet-900">{{ __('Privacy Policy') }}</a>
                        </label>
                    </div>
                @endif

                <button type="submit" class="w-full py-2 my-5 text-white bg-violet-900">
                    CREATE ACCOUNT
                </button>
            </form>
            <p class="text-center text-gray-500">OR SIGN UP WITH</p>

            <div class="flex gap-2 my-5">
                <button class="w-1/2 py-2 text-white bg-blue-800">FACEBOOK</button>
                <button class="w-1/2 py-2 text-white bg-orange-500">GOOGLE</button>
            </div>

            <p class="text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="text-violet-900">Login now</a>
            </p>
        </div>
    </section>
    <!-- /Register Card  -->
</x-guest-layout>

{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
