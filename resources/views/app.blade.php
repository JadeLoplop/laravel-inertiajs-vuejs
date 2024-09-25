<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel with Inertia</title>
    @vite('resources/js/app.js') <!-- Ensures your JavaScript is loaded -->
    @routes
</head>
<body>
@inertia <!-- Renders the Inertia pages -->
</body>
</html>
