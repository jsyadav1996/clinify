<x-guest-layout>
    <div class="login-container">
        <!-- Header Section -->
        <div class="login-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h1 class="app-name">Clinify</h1>
                <p class="app-tagline">Create your account to get started</p>
            </div>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="login-form" id="register-form">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <x-input-label for="name" :value="__('Full Name')" class="form-label" />
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <x-text-input id="name" class="form-input" type="text" name="name" :value="old('name')" autofocus autocomplete="name" placeholder="Enter your full name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                <span id="name_error" class="error-message"></span>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email Address')" class="form-label" />
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" autocomplete="username" placeholder="Enter your email" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <span id="email_error" class="error-message"></span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-input-label for="password" :value="__('Password')" class="form-label" />
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <x-text-input id="password" class="form-input" type="password" name="password" autocomplete="new-password" placeholder="Create a password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <span id="password_error" class="error-message"></span>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <x-text-input id="password_confirmation" class="form-input" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Confirm your password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                <span id="password_confirmation_error" class="error-message"></span>
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <x-primary-button class="login-button">
                    <span>{{ __('Create Account') }}</span>
                    <svg class="button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </x-primary-button>
            </div>

            <!-- Login Link -->
            <div class="register-section">
                <p class="register-text">
                    {{ __('Already have an account?') }}
                    <a class="register-link" href="{{ route('login') }}">
                        {{ __('Log in') }}
                    </a>
                </p>
            </div>
        </form>
    </div>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @endpush

    @push('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
    @endpush
</x-guest-layout>
