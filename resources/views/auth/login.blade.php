<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="text-align: center;padding-top:150px">
        <h1>Log In</h1>
        <hr>
        @include('auth.embedded-login')
    </div>


</x-guest-layout>
