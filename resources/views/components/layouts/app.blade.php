<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'App' }}</title>

    @livewireStyles

    <style>
        body {
            margin:0;
            font-family:Arial, sans-serif;
            background:#f3f4f6;
        }

        .app-wrapper {
            display:flex;
            min-height:100vh;
        }

        .app-content {
            flex:1;
            padding:20px;
            background:#f3f4f6;
            position:relative;
            z-index:10;
        }
    </style>
</head>
<body>

<div class="app-wrapper">
    <x-layouts.app.sidebar :title="$title ?? null" />

    <div class="app-content">
        {{ $slot }}
    </div>
</div>

@livewireScripts
</body>
</html>
