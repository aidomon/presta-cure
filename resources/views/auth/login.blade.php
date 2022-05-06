<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div id="form">
        <h1>Log In</h1>
        <hr>
        @include('auth.embedded-login')
    </div>


</x-guest-layout>
