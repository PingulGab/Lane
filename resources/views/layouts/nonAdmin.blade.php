<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    @yield('head')
    @vite(['resources/css/app.css'])
</head>

<style>
    .nonAdmin-container {
        margin: 50px;
    }
</style>

<body>
    <div class="nonAdmin-container">
        @yield('content')
    </div>
</body>
</html>
