<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bry</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body>
        <app-root></app-root>
        <script type="text/javascript" src="{{asset('js/runtime.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/polyfills.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/styles.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/vendor.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/main.js')}}"></script>
    </body>
</html>
