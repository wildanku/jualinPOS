@extends('layouts.default', ['withHeader' => false, 'withSidebar' => false])

@section('content')
    <div class="w-full min-h-screen flex items-center justify-center bg-primary p-6">
        <div class="w-full max-w-md bg-white pt-14 px-8 pb-8 rounded-xl shadow relative">
            <div class="absolute " style="top: -50px; left: -50px">
                <img src="{{ asset('icon-jualinhub.png') }}" style="width: 100px" class="sm:w-8" alt="">
            </div>

            <span class="text-2xl">{{__('general.welcome')}},</span>

            @error('email')
            <div class="p-2 mt-2 pb-2 w-full rounded bg-red-100 text-red-600 text-xs">
            {{ $message }}
            </div>
            @enderror

            <form action="{{ route('login') }}" class="mt-3" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="" class="text-sm block mb-1 text-gray-500">Email</label>
                    <input type="email" name="email" class="w-full rounded border border-gray-400" placeholder="Your Email...">
                </div>
                <div class="mb-2 mt-4">
                    <label for="" class="text-sm block mb-1 text-gray-500">Password</label>
                    <input type="password" name="password" class="w-full rounded border border-gray-400" placeholder="Your Password...">
                </div>

                <div class="form-control py-3">
                    <label class="cursor-pointer">
                        <input type="checkbox" name="remember" class="checkbox checkbox-xs" />
                        <span class="label-text ml-2">Remember me</span> 
                    </label>
                </div>

                <div class="mt-4">
                    <button class="bg-primary text-center text-white w-full rounded py-2 text-lg hover:bg-blue-600">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection