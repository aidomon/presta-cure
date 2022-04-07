<x-guest-layout>

    <form id="registration-form" method="POST" action="{{ route('register') }}">
        @csrf

        <h1>Register</h1>
        <hr>
        <!-- Username -->
        <div>
            <input id="name" placeholder="Username" type="text" name="username" value="{{ old('username') }}" required />
        </div>

        <!-- Email Address -->
        <div>
            <input id="email" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required />
        </div>

        <!-- Password -->
        <div>
            <input id="password" placeholder="Password"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div>
            <input id="password_confirmation" placeholder="Repeat password"
                            type="password"
                            name="password_confirmation"
                            required />
        </div>

        <div class="registration-btn-div">
            <x-button class="registration-btn">
                {{ __('Register') }}
            </x-button>
            <a class="" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />
    </form>

</x-guest-layout>
