<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'App' }}</title>

    {{-- BOOTSTRAP --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- LIVEWIRE --}}
    @livewireStyles

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .app-content {
            flex: 1;
            padding: 20px;
            background: #f3f4f6;
            position: relative;
            z-index: 10;
        }

        /* ==== FIX SIDEBAR LINK / BUTTON ==== */
        .sidebar a,
        .sidebar button,
        .sidebar .nav-link {
            text-decoration: none !important; /* hilangkan underline */
            border: none !important;          /* hilangkan border */
            outline: none !important;         /* hilangkan outline focus */
            box-shadow: none !important;      /* hilangkan shadow focus */
            background: none !important;      /* hilangkan background default */
            color: inherit !important;        /* jaga warna teks */
        }

        .sidebar a:hover,
        .sidebar button:hover,
        .sidebar a:focus,
        .sidebar button:focus,
        .sidebar a:active,
        .sidebar button:active,
        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus,
        .sidebar .nav-link:active {
            text-decoration: none !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: none !important;
            color: inherit !important;
        }

        /* Optional: jika sidebar pakai list-group */
        .sidebar .list-group-item {
            border: none !important;
            background: none !important;
        }
    </style>
</head>
<body>

<div class="app-wrapper">
    {{-- SIDEBAR --}}
    <x-layouts.app.sidebar :title="$title ?? null" />

    {{-- CONTENT --}}
    <div class="app-content">
        {{ $slot }}
    </div>
</div>

{{-- BOOTSTRAP JS --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

{{-- LIVEWIRE --}}
@livewireScripts

</body>
</html>
