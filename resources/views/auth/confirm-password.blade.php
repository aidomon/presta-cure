<x-guest-layout>

        <div>
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form id="form" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <h1>Confirm password</h1>
            <hr>
            <!-- Password -->
            <div>
                <input id="password" placeholder="Password"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div>
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>

</x-guest-layout>
