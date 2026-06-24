<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Manajemen Kos') }} - Dashboard Penyewa</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body class="bg-slate-100 text-slate-900">
        <div class="">
            <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
                @include('partials.sidebar')

                <div class="flex-1 flex flex-col overflow-hidden">
                    @include('partials.header')

                    <main class="flex-1 overflow-y-auto p-6">
                        <h1>HALAMAN USER</h1>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
