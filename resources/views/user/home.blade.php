<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Manajemen Kos') }} - Dashboard Penyewa</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900">
        @php($tenantName = 'Andi')

        <div class="min-h-screen lg:pl-80">
            @include('user.partials.sidebar', ['tenantName' => $tenantName])

            <div class="flex min-h-screen flex-col">
                @include('user.partials.header', ['tenantName' => $tenantName])

                
            </div>
        </div>
    </body>
</html>
