

<div class="w-32 fixed z-50">
    <a href="{{ route('dashboard') }}" id="icon" class="flex justify-center mb-4 hover:brightness-110">
        <img src="{{ asset('icon-jualinhub.png') }}" class="w-24 " alt="">
    </a>

    <div class="mb-3 dropdown dropdown-right">
        <a href="#" class="w-32  block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="desktop-outline"></ion-icon>
            <span class="text-md block">{{__('sidebar.pos')}}</span>
        </a>
        <ul tabindex="0" class="dropdown-content menu p-1 shadow bg-base-100 ml-2 rounded-lg w-44 " >
            <li>
                <a href="{{ route('pos.index') }}" class="p-2">{{__('sidebar.pos.cashier')}}</a>
            </li>
            <li>
                <a href="{{ route('pos.transactions') }}" class="p-2">{{__('sidebar.pos.transaction')}}</a>
            </li>
        </ul>
    </div>

    {{-- <div class="mb-3 relative">
        <a href="#" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="pie-chart-outline"></ion-icon>
            <span class="text-md block">{{__('sidebar.insight')}}</span>
        </a>
    </div> --}}

    <div class="mb-3 dropdown dropdown-right ">
        <a href="#" class="@if(Route::is('product.*')) active bg-primary @endif block p-4 w-32 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="cube-outline"></ion-icon>
            <span class="text-md block">{{__('sidebar.inventory')}}</span>
        </a>
        <ul tabindex="0" class="dropdown-content menu p-1 shadow bg-base-100 ml-2 rounded-lg w-44">
            <li>
                <a href="{{ route('product.index') }}" class="p-2">{{__('sidebar.inventory.product')}}</a>
            </li>
            <li>
                <a href="{{ route('product.create') }}" class="p-2">{{__('sidebar.inventory.add_product')}}</a>
            </li>
        </ul>
    </div>

    {{-- <div class="mb-3 ">
        <a href="#" class="w-full block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="wallet-outline"></ion-icon>
            <span class="text-md block">{{__('general.transaction')}}</span>
        </a>
    </div> --}}

    <div class="mb-3 ">
        <a href="#" class="w-32 block p-4 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
            <ion-icon class="text-gray-600" name="cog-outline"></ion-icon>
            <span class="text-md block">{{__('sidebar.setting')}}</span>
        </a>
    </div>

</div>