<div class="py-3 w-full flex justify-between">
    <h3 class="text-xl">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }} <br> <small id="txt"></small></h3>

    <div class="flex gap-2 items-center">
        <div class="bg-primary pl-2 py-1 pr-8 rounded-full text-white cursor-pointer flex gap-2 items-center"><ion-icon name="person-circle-outline"></ion-icon> {{ auth()->user()->name }}</div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button onclick="return confirm('{{__('general.logout_confirm')}}');" class="bg-red-600 hover:bg-red-700 rounded-full w-12 h-12 text-center flex justify-center items-center">
                <ion-icon name="exit-outline" class="text-white " style="font-size: 24px"></ion-icon>
            </button>
        </form>
    </div>
</div>