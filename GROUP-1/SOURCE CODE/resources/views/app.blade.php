<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Material Icons for FAB -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        
        <!-- Jquery Animate -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        
        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- Lottie Player -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
