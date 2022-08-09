
<div class="relative hidden md:block">
    <div class="w-32 z-50 sticky top-10">
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
</div>

<div class="fixed bottom-0 left-0 w-full grid grid-cols-5 md:hidden bg-white z-50 shadow">
    <a href="{{route('dashboard')}}" class="text-center leading-3 text-primary py-2">
        <ion-icon class="text-2xl" name="home-outline"></ion-icon> <br>
        <small class="text-xs">{{ __('sidebar.home')}}</small>
    </a>

    <div class="text-center leading-3 py-2">
        <ion-icon class="text-2xl" name="cube-outline"></ion-icon><br>
        <small class="text-xs">{{__('sidebar.inventory')}}</small>
    </div>

    <div class="text-center leading-3 py-2 text-white bg-primary rounded-full">
        <ion-icon class="text-2xl" name="grid-outline"></ion-icon><br>
        <small class="text-xs">Menu</small>
    </div>

    <div class="text-center leading-3 py-2">
        <ion-icon class="text-2xl" name="desktop-outline"></ion-icon><br>
        <small class="text-xs">{{__('sidebar.pos')}}</small>
    </div>

    <div class="text-center leading-3 py-2">
        <ion-icon class="text-2xl" name="person-circle-outline"></ion-icon><br>
        <small class="text-xs">{{__('sidebar.personal')}}</small>
    </div>
</div>