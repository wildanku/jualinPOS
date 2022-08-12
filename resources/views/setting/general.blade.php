@extends('layouts.default', [])
@push('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endpush
@section('content')
    <div class="flex justify-between items-center relative">
        <h3 class="text-xl md:text-2xl">{{__('setting.general')}}</h3>
    </div>

    <div class="max-w-2xl bg-white rounded p-4 mt-3 shadow-lg">
        <form action="" method="POST">
        @csrf
        <div class="form-control mb-3">
            <label for="" class="text-sm">{{__('setting.company_name')}}</label>
            <input type="text" name="company_name" value="{{old('company_name', company_name())}}" class="w-full rounded py-2 border border-gray-300">
        </div>

        <div class="form-control mb-3">
            <label for="" class="text-sm">{{__('setting.company_address')}}</label>
            <textarea name="company_address" class="w-full rounded border border-gray-300">{{old('company_address', company_address())}}</textarea>
        </div>

        <div class="form-control mb-3">
            <label for="" class="text-sm">{{__('setting.company_phone')}}</label>
            <input type="text" name="company_phone" value="{{old('company_phone', company_phone())}}" class="w-full rounded py-2 border border-gray-300">
        </div>

        <div class="form-control mb-3">
            <label for="" class="text-sm">{{__('setting.currency')}}</label>
            <select name="currency" class="w-full rounded py-2 border border-gray-300" id="currency">
                @foreach (\App\Models\Currency::all() as $item)
                <option value="{{$item->id}}" @if(currency()->id == $item->id) selected @endif>{{$item->name}} ({{$item->symbol}})</option>
                @endforeach
            </select>
        </div>

        <div class="mt-3 text-right">
            <button type="submit" class="bg-primary hover:bg-secondary rounded text-white py-2 px-10">{{__('general.save')}}</button>
        </div>
        </form>
    </div>
@endsection

@push('js')
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#currency").select2();
    });
    
</script>
@endpush