<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;800;900&family=Roboto:ital,wght@0,300;0,500;0,900;1,300;1,500;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/fonts/boxicons/css/boxicons.min.css">

        <!--favicons-->
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- Scripts -->
        @routes

        {{-- @vite(['resources/ts/app.ts', "resources/ts/Pages/{$page['component']}.svelte"]) --}}
        @vite(['resources/ts/app.ts'])

        @inertiaHead
    </head>
    <body class="font-sans antialiased h-full">
        @inertia
    </body>
</html>
