<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>KBDB Login</title>

        <link rel="stylesheet" href="{{asset('css/global.css')}}">
    </head>
    <body style="max-width: 30%;">
        <div id="app"></div>
        <script src="{{asset('js/login-app.js')}}" defer></script>
    </body>
</html>
