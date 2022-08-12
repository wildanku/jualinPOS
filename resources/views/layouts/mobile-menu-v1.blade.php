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