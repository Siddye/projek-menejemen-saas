<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Agency PM') }} &bull; Masuk</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            }
            body {
                background: 
                    radial-gradient(at 0% 0%, #d8eaf7 0px, transparent 45%),
                    radial-gradient(at 100% 0%, #ebe0fa 0px, transparent 40%),
                    radial-gradient(at 95% 95%, #d6f5eb 0px, transparent 45%),
                    radial-gradient(at 20% 90%, #d3e7f5 0px, transparent 40%),
                    #ebf3f8;
                background-attachment: fixed;
                min-height: 100vh;
            }
        </style>
    </head>
    <body class="text-slate-800 antialiased flex flex-col justify-center items-center p-4 min-h-screen">
        <div class="w-full max-w-md">
            <!-- Brand Logo Header -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#00d2ff] to-[#3a7bd5] text-white text-2xl shadow-lg shadow-sky-500/20 mb-3">
                    <i class="bi bi-layers-fill"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Digital Agency Studio</h2>
                <p class="text-xs text-slate-500 font-medium">Project Management & Task Validation Platform</p>
            </div>

            <!-- Glass Card Container -->
            <div class="bg-white/80 backdrop-blur-xl border border-white/90 shadow-2xl shadow-slate-900/10 rounded-3xl p-6 sm:p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="text-center mt-6 text-xs text-slate-500">
                Pemrograman Web III &bull; Studi Kasus Tim Agensi Digital
            </div>
        </div>
    </body>
</html>
