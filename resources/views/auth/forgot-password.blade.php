<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors :errors="$errors" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <h1>Forgot password?</h1>
        <hr>
        <p>
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" :value="old('email')" placeholder="Enter your email" required autofocus />
        </div>

        <div>
            <x-button>
                {{ __('Send reset link in email') }}
            </x-button>
        </div>
    </form>

</x-guest-layout>
