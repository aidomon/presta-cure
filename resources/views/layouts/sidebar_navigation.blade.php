<nav>
    <div>
        <a href="{{ route('dashboard') }}">
            <h1>Dashboard</h1>
            <p style="font-size:11px">Manage your projects</p>
        </a>
        <!-- Settings Dropdown -->
        <div id="user-options">
            <x-dropdown>
                <x-slot name="trigger">
                    <button>
                        <div><img src="/images/profile.svg"
                                alt="PrestaCure profile"><span>{{ Auth::user()->username }}</span></div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('account') }}">Account</a>
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
        <div class="menu">
            @if (\App\Models\User::first()->username == Auth::user()->username)
                <h2><a href="{{ route('admin-panel') }}">Admin Panel</a></h2>
            @endif
            <h2><a href="{{ route('dashboard') }}">Projects</a></h2>
            <h2><a href="{{ route('tests') }}">Tests</a></h2>
            <h2><a href="{{ route('home') }}">Home</a></h2>
            <h2><a href="{{ route('home') }}#how-it-works">Help</a></h2>
        </div>
        <div class="credentials">
            <a href="{{ route('home') }}"><img src="/images/PrestaCure.svg" alt="PrestaCure"></a>
            <p>&copy; Dominik Richter</p>
        </div>
    </div>
</nav>
