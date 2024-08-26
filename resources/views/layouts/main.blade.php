<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'SkyTel') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/bootstrap.js', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <x-navbar />
    <div class="min-vh-100">
        {{ $slot }}
    </div>

    <x-footer />
</body>

</html>
