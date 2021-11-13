<nav>
    <div>
        <h1>Dashboard</h1>
        <p style="font-size:11px">Manage your projects</p>
        <!-- Settings Dropdown -->
        <div id="user-options">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button>
                            <div><img src="/images/profile.svg" alt="PrestaCure profile"><span>{{ Auth::user()->name }}</span></div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                            <a href="">Account</a>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        <div class="menu">
            <h2><a href="{{ route('dashboard') }}">Projects</a></h2>
            <h2><a href="{{ route('home') }}">Home</a></h2>
            <h2><a href="{{ route('home') }}#how-it-works">Help</a></h2>
        </div>
        <div class="credentials">
            <a href="{{ route('home') }}"><img src="/images/PrestaCure.svg" alt="PrestaCure"></a>
            <p>&copy; Dominik Richter</p>
        </div>
    </div>
</nav>
