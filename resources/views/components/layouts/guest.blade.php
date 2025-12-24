<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Gajiplus' }}</title>

    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <link href="{{ asset('e-presensi/assets/img/logo/favicon.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    {{ $head ?? '' }}
  </head>

  <body id="body" class="mt-16 min-h-100 font-sans antialiased bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100">

      <main id="main" class="mt-16 p-6">
          {{ $slot }}
      </main>

    @livewireScripts
    {{ $scripts ?? '' }}
  </body>
</html>