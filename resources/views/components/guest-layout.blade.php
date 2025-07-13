<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Metadata --}}
    <meta name="description"
        content="Website Inspeksi Alat Berat adalah aplikasi untuk melakukan inspeksi kelayakan alat berat secara digital.">
    <meta name="keywords" content="inspeksi alat berat, tambang">
    <meta name="author" content="Inspeksi Alat Berat">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/application-logo.webp') }}" type="image/x-icon">

    {{-- Judul Halaman --}}
    <title>Inspeksi Alat Berat</title>

    {{-- Framework Frontend --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Tambahan --}}
    @isset($script)
        {{ $script }}
    @endisset

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    {{-- Default CSS --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

    {{-- Layout Utama --}}
    <main>
        {{ $slot }}
    </main>

</body>

</html>
