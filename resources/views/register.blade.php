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
<!-- resources/views/register.blade.php -->

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name Field -->
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Username Field -->
    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Email Field -->
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Password Field -->
    <input type="password" name="password" placeholder="Password" required>
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <!-- Confirm Password Field -->
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

    <!-- Contact Number Field -->
    <input type="text" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}" required>
    @error('contact_number')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Register</button>
</form>

    </body>
</html>
