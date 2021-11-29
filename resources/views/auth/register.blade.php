<x-guest-layout>
   
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form id="registration-form" method="POST" action="{{ route('register') }}">
        @csrf

        <h1>Register</h1>
        <hr>
        <!-- Name -->
        <div>
            <input id="name" placeholder="Name" type="text" name="name" :value="old('name')" required />
        </div>

        <!-- Email Address -->
        <div>
            <input id="email" placeholder="Email" type="email" name="email" :value="old('email')" required />
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
    </form>
   
</x-guest-layout>
