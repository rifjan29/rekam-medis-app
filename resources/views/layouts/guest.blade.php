<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIMPEPE') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
    <section style="background-image: url('{{ asset('bag.jpeg') }}')" class="relative bg-no-repeat bg-center bg-cover bg-fixed overflow-hidden">
    <div class="h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 z-50">
        
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg z-50">
            <div class="mb-2 flex flex-col">
                <span class="font-bold text-3xl text-center">Dinas Kabupaten Situbondo</span>
                <span class="font-bold text-2xl text-center">Puskesmas Arjasa</span>
                <hr class="border">
                <div class="mt-3">
                    <a href="/" class="mx-auto">
                        <span class="font-bold text-2xl text-center">SIMPEPE</span><br>
                    </a>
                    <p>Selamat Datang, Silahkan Login terlebih dahulu</p><br>
                </div>
                <hr class="border">
            </div>
            {!! $slot !!}
        </div>
    </div>
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-10 -z-1" style="backdrop-filter: blur(6px);"></div>
</section>

       
    </body>
</html>
