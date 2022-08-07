

<div class="w-32">
    <div id="icon" class="flex justify-center mb-4">
        <img src="{{ asset('icon-jualinhub.png') }}" class="w-24" alt="">
    </div>

    <div class="py-2">
        <a href="{{ route('pos.index') }}" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="desktop-outline"></ion-icon>
            <span class="text-md block">Cashier</span>
        </a>
    </div>

    <div class="py-2">
        <a href="#" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="pie-chart-outline"></ion-icon>
            <span class="text-md block">Insight</span>
        </a>
    </div>

    <div class="py-2">
        <a href="{{ route('product.index') }}" class="@if(Route::is('product.*')) active bg-primary @endif w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="cube-outline"></ion-icon>
            <span class="text-md block">Product</span>
        </a>
    </div>

    <div class="py-2">
        <a href="#" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="wallet-outline"></ion-icon>
            <span class="text-md block">Transaction</span>
        </a>
    </div>

    <div class="py-2">
        <a href="#" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="cog-outline"></ion-icon>
            <span class="text-md block">Setting</span>
        </a>
    </div>

</div>