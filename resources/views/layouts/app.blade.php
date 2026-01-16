<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="flex min-h-screen bg-gray-100">

    <!-- LEFT SIDEBAR -->
    @include('layouts.navigation')

    <!-- RIGHT CONTENT -->
    <main class="flex-1 p-6 overflow-y-auto ml-64 transition-all duration-300">
        {{ $slot }}
    </main>

</div>

</body>
</html>
