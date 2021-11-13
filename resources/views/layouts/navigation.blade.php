@if (Route::has('login'))
    <nav>
        <a href="{{ route('home') }}">
            <img src="/images/PrestaCure.svg" alt="PrestaCure" class="logo-bright">
            <img src="/images/PrestaCure_dark.svg" alt="PrestaCure" class="logo-dark">
        </a>
        <div style="display: flex">
            <a href="#how-it-works" class="">How it works?</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @endauth
        </div>
    </nav>
@endif
