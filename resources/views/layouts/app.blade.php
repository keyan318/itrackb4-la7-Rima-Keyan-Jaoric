<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Movie App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="bg-dark text-white py-4 mb-4">
        <div class="container">
            <h1 class="mb-1">🎬 My Movie App</h1>
            <p class="mb-0">Made by Keyan Jaoric Rima</p>
        </div>
    </div>

    <div class="container">
        @include('partials._nav')

        @if (session('success'))
            <div class="alert alert-success mt-4">{{ session('success') }}</div>
        @endif

        <div class="mt-4">
            @yield('content')
        </div>
    </div>

</body>
</html>
