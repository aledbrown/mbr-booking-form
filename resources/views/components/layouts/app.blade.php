<!DOCTYPE html>
<html data-theme="mbr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-gray-100">

<nav class="flex items-center justify-center border-b shadow-sm bg-gradient-to-l from-primary to-accent border-neutral-100 px-6 py-4" aria-label="menu">
    <a wire:navigate href="{{ route('pages.booking-form') }}" class="text-2xl font-bold text-white">
        <span>Booking Form</span>
    </a>
</nav>

<div class="max-w-5xl p-0 sm:p-5 content-center mx-auto">
    {{ $slot }}
</div>

<x-mary-toast />
</body>
</html>
