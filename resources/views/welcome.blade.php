<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PrestaCure</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Nunito:wght@600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
        <script src="{{ asset('js/jquery.js') }}"></script>

        <meta name="generator" content="PrestaShop" />

    </head>

    <body>
        @include('layouts.navigation')

        <section id="banner">
            <div>
                <h1>Secure your PrestaShop against real world threats</h1>
                <p>Run security tests and find out what to improve.</p>
            </div>
            <div>
                @if (Route::has('login'))
                    @guest
                        <h2><span id="login-form-link">Log In</span> / <span id="registration-form-link"><a href="{{ route('register') }}" style="color:#959595">Register</a></span></h2>

                        @include('auth.embedded-login')
                    @endguest
                    @auth
                        <div style="margin-right: 20%">
                            <p><span style="color: #e2336f;">Welcome,</span><br>{{ auth()->user()->name }}</p>
                            <img src="/images/security.svg" alt="PrestaCure" style="margin: 20px auto">
                            <p style="font-size:20px;">Ready to secure your PrestaShop?</p>
                            <p style="font-size:20px;margin-top: 15px"><a href="{{ url('/dashboard') }}" class="">Go to your <span style="color:#e2336f">Dashboard</span></a></p>
                        </div>
                    @endauth
                @endif
            </div>
        </section>

        <section id="how-it-works">
            <h2>How it works?</h2>
            <hr>
            <div>
                <div>
                    <img class="process-image" src="/images/create_project.png" alt="PrestaCure">
                    <p>Create and verify your new project by entering URL</p>
                </div>
                <img class="arrow" src="images/arrow.svg" alt="">
                <div>
                    <img class="process-image" src="/images/run_test.png" alt="PrestaCure">
                    <p>Run security tests and wait for results</p>
                </div>
                <img class="arrow" src="images/arrow.svg" alt="">
                <div>
                    <img class="process-image" src="/images/bug_fixing.png" alt="PrestaCure">
                    <p>Examine results and secure your PrestaShop</p>
                </div>

            </div>
        </section>

        <footer>
            <p>&copy; Dominik Richter</p>
        </footer>

        <script>
            // menu
            var navbar =  document.querySelector("nav");

            function scrollFunction() {
                if (window.scrollY  > 10) {
                    navbar.classList.add('nav-scrolling');
                } else {
                    navbar.classList.remove('nav-scrolling');
                }
            }

            window.onscroll = scrollFunction;
        </script>

        @include('components.show-status-bar')

    </body>

</html>
