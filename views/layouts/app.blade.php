<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'app')</title>
    @yield('stylesheets')
    @encore_entry_link_tags('app')
</head>
<body>
    @yield('content')
    @yield('javascripts')
    @encore_entry_script_tags('app')
</body>
</html>