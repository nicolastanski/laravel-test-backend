<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Properties List</title>
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>
    </body>
    <script src="js/app.js"></script>
</html>
