<!DOCTYPE html>
<html lang="en" class="fi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choosable Chips — Demo</title>
    <link rel="stylesheet" href="{{ asset('css/preview/theme.css') }}">
    @filamentStyles
</head>
<body class="bg-gray-50 text-gray-950 antialiased dark:bg-gray-950 dark:text-white">
    <main class="mx-auto max-w-2xl space-y-8 p-10">
        <h1 class="text-2xl font-bold">Choosable Chips</h1>
        {{ $slot }}
    </main>
    @filamentScripts
</body>
</html>
