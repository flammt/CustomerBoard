<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Customer Board</title>

        <link rel="stylesheet" href="{{asset('css/global.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body style="max-width: 100%;">
        <div id="app"></div>
        <script src="{{asset('js/app.js')}}" defer></script>
    </body>
</html>
