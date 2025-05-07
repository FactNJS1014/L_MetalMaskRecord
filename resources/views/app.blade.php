<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('public/favicon/Metal_Mask.svg') }}" type="image/x-icon">
    <title>Metal Mask</title>
    <link rel="stylesheet" href="{{ asset('primeicons/primeicons.css') }}">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body {
            background-color: #00d3f2;
            height: 1000vh;
        }
    </style>

</head>

<body>
    <base href="/45_engmask/">
    <div id="app"></div>
        <script>
            window.sessionData = {
                empno: '{{ session("empno") }}',
                username: '{{ session("username") }}',
                department: '{{ session("department") }}',
                sec: '{{ session("sec") }}',
                permission: '{{ session("USE_PERMISSION") }}',
                MSECT_ID: '{{ session("MSECT_ID") }}',
                server: '{{ $_SERVER["HTTP_HOST"] }}'
            };
            console.log(sessionData);
            window.imagePath1 = '{{ asset("public/pictures/Setting Model-new.svg") }}';
            window.imagePath2 = '{{ asset("public/pictures/SettingMask.svg") }}';
            window.imagePath3 = '{{ asset("public/pictures/RP Model.svg") }}';
            window.imagePath4 = '{{ asset("public/pictures/RP Mask.svg") }}';
            window.documentPath = '{{ asset("public/document/Manual-Program.pdf") }}';
            window.videoPath = '{{ asset("public/video/manual-mask.mp4") }}';
            
            

            
           
        </script>
      
</body>

</html>
