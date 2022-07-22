<div class="py-3 w-full flex justify-between items-center mt-3">
    <div class="flex gap-5 items-center">
        <img src="{{ asset('icon-jualinhub.png') }}" class="w-20 block" alt="">
        <h3 class="text-xl">{{ Carbon\Carbon::now()->format('l, d M Y') }} <br> <small id="txt"></small></h3>
    </div>

    <div class="flex gap-2 items-center">
        <div class="bg-primary pl-2 py-2 pr-8 rounded-full text-white cursor-pointer flex gap-2 items-center"><ion-icon name="person-circle-outline" style="font-size:24px"></ion-icon> {{ auth()->user()->name }}</div>

        <a href="{{ route('dashboard') }}" onclick="return confirm('Are you sure want to quite POS Apps?');" class="bg-red-600 block hover:bg-red-700 rounded-full w-10 h-10 text-center flex justify-center items-center">
            <ion-icon name="close" class="text-white " style="font-size: 24px"></ion-icon>
        </a>
    </div>
</div>