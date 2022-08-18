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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('css')

    <style>
        ion-icon {
            font-size: 40px;
        }

        .alert {
            z-index: 999;
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
    <div class="w-full min-h-screen bg-gray-50">
        @php $withSidebar = $withSidebar ?? true; $withHeader = $withHeader ?? true; @endphp
        @include('layouts.alert')
        @if($withSidebar) 
        <div class="max-w-screen-2xl flex gap-4 mx-auto p-4 md:p-6 mt-12 md:mt-0 relative">
            @include('layouts.sidebar')
            <div class="w-full md:pt-2 md:px-4 ">
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
    <script src="{{ asset('js/jquery.js') }}" ></script>
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
            h = checkTime(h);

            document.getElementById('txt').innerHTML =  h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }
        
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        </script>
</body>
</html>