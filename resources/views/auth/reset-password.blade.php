<x-guest-layout>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <h1>Reset password</h1>
            <hr>

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <input id="email" type="email" name="email" :value="old('email', $request->email)" placeholder="Email" required autofocus />
            </div>

            <!-- Password -->
            <div>
                <input id="password" placeholder="Password" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div>
                <input id="password_confirmation" placeholder="Confirm password"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div>
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>

</x-guest-layout>
