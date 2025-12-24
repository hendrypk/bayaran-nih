<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Gajiplus')</title>

    <!-- Favicons -->
    <link href="{{ asset('e-presensi/assets/img/logo/favicon.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>

  <body id="body" class="mt-16 min-h-100 font-sans antialiased bg-blue-50 dark:bg-slate-800 text-slate-800 dark:text-gray-100 ">
      @if(!request()->is('login') && !request()->is('register'))
        <x-navbar />
        <x-sidebar />
      @endif
      <main id="main" class="mt-16 p-6">
          @yield('content')
      </main>

    {{-- <x-modal /> --}}

    <!-- Back to top button -->
    <a href="#"
      class="fixed bottom-4 right-4 flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white shadow hover:bg-blue-700 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
      </svg>
    </a>

    {{-- @livewireScripts --}}
    @yield('script')
    @stack('scripts')
  </body>
</html>
