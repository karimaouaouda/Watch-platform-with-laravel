<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="w-screen min-h-screen bg-slate-100" oncontextmenu="return false;">
    <nav class="w-full h-14 font-semibold uppercase text-xl bg-slate-200 shadow flex justify-center items-center">
        here navbar content
    </nav>

    <livewire:movies.watch :film="$film" />
    @livewireScripts
</body>
</html>