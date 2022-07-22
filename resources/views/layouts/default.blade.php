<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    {{-- icon  --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('css')

    <style>
        ion-icon {
            font-size: 40px;
        }

        .sidemenu:hover ion-icon,
        .sidemenu:hover span,
        .sidemenu.active ion-icon,
        .sidemenu.active span {
            color: #fff;
        }
    </style>

</head>
<body>
    <div class="w-full min-h-screen bg-gray-100">
        @php $withSidebar = $withSidebar ?? true; $withHeader = $withHeader ?? true; @endphp
        @include('layouts.alert')
        @if($withSidebar) 
        <div class="max-w-screen-xl mx-auto p-6 relative">
            <div class="absolute">
                @include('layouts.sidebar')
            </div>
            
            <div class="lg:ml-36 pt-2 px-4 ">
                @if($withHeader) 
                @include('layouts.header')
                @endif
                <div class="mt-4 py-2">
                    @yield('content')
                </div>
            </div>
        </div>
        @else 
        @yield('content')
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    @stack('js')
    <script>
        window.onload = startTime();

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =  h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }
        
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
        </script>
</body>
</html>