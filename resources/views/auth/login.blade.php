<x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <h1>Log In</h1>
            <hr>
            <!-- Email Address -->
            <div>
                <input id="email" placeholder="Email" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div>
                <input id="password" placeholder="Password"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div id="remember-me">
                <label for="remember_me" class="inline-flex">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="login-btn-div">
                <x-button>
                    {{ __('Log in') }}
                </x-button>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    
</x-guest-layout>
