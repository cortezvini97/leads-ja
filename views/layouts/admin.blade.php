<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Admin')</title>
        @encore_entry_link_tags('admin')
        @yield('stylesheets')
    </head>
    <body>
        @yield('content')
        @encore_entry_script_tags('admin')
        @yield('javascripts')
    </body>
</html>