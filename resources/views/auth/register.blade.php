<x-guest-layout>
        <div class="flex justify-center mb-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Barangay <span class="text-blue-600">SPOT</span></h1>
            </div>
        </div>

        <h2 class="text-center text-2xl font-semibold mb-6 text-gray-800">Join Your Community</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-gray-700" />
                <x-text-input id="name" class="block mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

                <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Terms of Service -->
            <div class="mt-4">
                <label for="terms" class="inline-flex items-center">
                    <input id="terms" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="terms" required>
                    <span class="ms-2 text-sm text-gray-600">
                        {{ __('I agree to the') }} 
                        <a href="#" class="text-blue-600 hover:text-blue-800">{{ __('Terms of Service') }}</a> 
                        {{ __('and') }} 
                        <a href="#" class="text-blue-600 hover:text-blue-800">{{ __('Privacy Policy') }}</a>
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors shadow-sm">
                    {{ __('Create Account') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Already have an account?') }} 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        {{ __('Log in') }}
                    </a>
                </p>
            </div>
        </form>
</x-guest-layout>