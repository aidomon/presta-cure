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
                    <h2><span id="login-form-link">Log In</span> / <span id="registration-form-link">Register</span></h2>
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <input id="email" placeholder="Email" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!-- Password -->
                        <div>
                            <input id="password" placeholder="Password"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                        </div>

                        <div class="login-btn-div">
                            <x-button>
                                {{ __('Log in') }}
                            </x-button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </form>

                    <form id="registration-form" style="display:none" method="POST" action="{{ route('register') }}">
                        @csrf

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
        </section>

        <script>

            if (document.querySelector("#login-form-link") || document.querySelector("#registration-form-link")) {
                var login_form = document.querySelector("#login-form");
                var registration_form = document.querySelector("#registration-form");
                var login_form_link = document.querySelector("#login-form-link");
                var registration_form_link = document.querySelector("#registration-form-link");

                login_form_link.addEventListener("click", () => {
                    login_form.style.display = 'block';
                    registration_form.style.display = 'none';
                    login_form_link.style.color = 'white';
                    registration_form_link.style.color = '#959595';
                });
                registration_form_link.addEventListener("click", () => {
                    registration_form.style.display = 'block';
                    login_form.style.display = 'none';
                    registration_form_link.style.color = 'white';
                    login_form_link.style.color = '#959595';
                });
            }

            // menu
            var navbar =  document.querySelector("nav");

            function scrollFunction() {
                //alert("oj");
                if (window.scrollY  > 10) {
                    navbar.classList.add('nav-scrolling');
                } else {
                    navbar.classList.remove('nav-scrolling');
                }
            }

            window.onscroll = scrollFunction;
        </script>

    </body>

</html>
