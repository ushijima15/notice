<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
    {{-- <script src="//{{ Request::getHost() }}:6008/socket.io/socket.io.js"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <style>
        html {
            min-height: 100%;
            position: relative;
        }
        body {
            margin-bottom: 3rem;
        }
        .footer {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
            height: 3rem;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="py-2">
            <performance-index :balance_id="{{ $id }}" />
        </main>
    </div>

    <div class="footer">
        <small>&copy @php echo date_format(date_create(), 'Y'); @endphp Mountain Gorilla.</small>
    </div>
</body>
</html>
