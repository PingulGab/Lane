<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LANE - Login</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background-image: url('{{ Vite::asset('resources/images/landing_page/landing_background.png') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 100vh;
                margin: 0;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div>
            <div class='loginContainer'>
                <img src='{{ Vite::asset('resources/images/lane_logo_base.png')}}'
                class='laneLogo'/>
                    <form action='{{route('authenticateUser')}}' class='centerColumn' method="POST">
                        @csrf
                        <input id='username' name='username' class='loginInput' type='text' placeholder="Username">
                        <input id='password' name='password' class='loginInput' type='password' placeholder="Password">
                        <input type='submit' value='Login' class='loginSubmit'>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
