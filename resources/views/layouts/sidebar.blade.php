
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
    
        <div class="mb-3 dropdown dropdown-right ">
            <a href="#" class="@if(Route::is('setting.*')) active bg-primary @endif block p-4 w-32 rounded-xl text-center shadow-lg bg-white cursor-pointer hover:bg-primary sidemenu">
                <ion-icon class="text-gray-600" name="cog-outline"></ion-icon>
                <span class="text-md block">{{__('sidebar.setting')}}</span>
            </a>
            <ul tabindex="0" class="dropdown-content menu p-1 shadow bg-base-100 ml-2 rounded-lg w-44">
                <li>
                    <a href="{{ route('setting.general') }}" class="p-2">{{__('sidebar.setting.general')}}</a>
                </li>
                <li>
                    <a href="{{ route('setting.user.index') }}" class="p-2">{{__('sidebar.setting.users')}}</a>
                </li>
            </ul>
        </div>
    
    </div>
</div>

<div class="block md:hidden w-full fixed top-0 left-0 bg-white shadow-xl py-2 px-4 z-50">
    <div class="w-full flex justify-between items-center">
        <a href="{{ route('dashboard') }}" id="icon" class="block md:hidden hover:brightness-110">
            <img src="{{ asset('icon-jualinhub.png') }}" class="w-10 " alt="">
        </a>
        <div class="leading-5 text-center">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }} <br> <small id="txt"></small></div>
        <label for="open-menu">
            <ion-icon class="text-2xl" name="grid-outline"></ion-icon>
        </label>
    </div>
</div>

<input type="checkbox" id="open-menu" class="modal-toggle" />
<div class="modal">
    <div class="modal-box fixed top-0 w-full min-h-screen rounded-none">
        <div class="w-full flex justify-between items-center">
            <h3 class="font-bold text-3xl text-secondary">Menu</h3>
            <label for="open-menu">
                <ion-icon name="close-circle-outline" class="text-red-600"></ion-icon>
            </label>
        </div>

        <div class="mt-4">
            <div class="py-2">
                <div class="flex items-center gap-4">
                    <ion-icon class="text-gray-600 text-2xl" name="desktop-outline"></ion-icon>
                    <span class="text-lg">{{__('sidebar.pos')}}</span>
                </div>
                <div class="ml-10 mt-1 gap-1 grid grid-cols-1">
                    <a href="{{ route('pos.index') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.pos.cashier') }}</a>
                    <a href="{{ route('pos.transactions') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.pos.transaction') }}</a>
                </div>
            </div>

            <div class="py-2">
                <div class="flex items-center gap-4">
                    <ion-icon class="text-gray-600 text-2xl" name="cube-outline"></ion-icon>
                    <span class="text-lg">{{__('sidebar.pos')}}</span>
                </div>
                <div class="ml-10 mt-1 gap-1 grid grid-cols-1">
                    <a href="{{ route('product.index') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.inventory.product') }}</a>
                    <a href="{{ route('product.create') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.inventory.add_product') }}</a>
                </div>
            </div>

            <div class="py-2">
                <div class="flex items-center gap-4">
                    <ion-icon class="text-gray-600 text-2xl" name="cog-outline"></ion-icon>
                    <span class="text-lg">{{__('sidebar.setting')}}</span>
                </div>
                <div class="ml-10 mt-1 gap-1 grid grid-cols-1">
                    <a href="{{ route('setting.general') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.setting.general') }}</a>
                    <a href="{{ route('setting.user.index') }}" class="block py-1 bg-blue-50 text-secondary rounded px-2">{{ __('sidebar.setting.users') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>