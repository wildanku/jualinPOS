<div class="py-3 w-full hidden md:flex justify-between items-center">
    <div class="flex gap-3">
        <a href="{{ route('dashboard') }}" id="icon" class="block md:hidden hover:brightness-110">
            <img src="{{ asset('icon-jualinhub.png') }}" class="w-12 " alt="">
        </a>
        <h3 class="text-lg md:text-xl leading-5">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }} <br> <small id="txt"></small></h3>
    </div>

    <div class="hidden md:flex gap-2 items-center">
        <div class="bg-primary pr-8 rounded-full text-white cursor-pointer flex gap-2 items-center"><ion-icon size="" name="person-circle-outline"></ion-icon> {{ auth()->user()->name }}</div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button onclick="return confirm('{{__('general.logout_confirm')}}');" class="bg-red-600 hover:bg-red-700 rounded-full w-10 h-10 text-center flex justify-center items-center">
                <ion-icon name="exit-outline" class="text-white " style="font-size: 24px"></ion-icon>
            </button>
        </form>
    </div>
</div>