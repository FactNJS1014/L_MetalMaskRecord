<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('public/favicon/Metal_Mask.svg')}}" type="image/x-icon">
    <title>Metal Mask</title>
    <link rel="stylesheet" href="{{ asset('primeicons/primeicons.css')}}">
    
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
      body{
        background-color: #00d3f2;
        height: 1000vh;
      }
    </style>

  </head>
  <body>
    <div id="app">

    </div>
  </body>
</html>
