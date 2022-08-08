@extends('layouts.default', [])

@section('content')
    <div class="flex gap-2 items-center">
        <x-arrow-component :url="route('product.index')" />
        <h3 class="text-2xl m-0">Edit {{ $product->name }}</h3>
    </div>

    <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6 items-start">
        <div class="md:col-span-3 bg-white shadow rounded-lg p-5">
            <div class="form-control mb-3">
                <label for="">{{__('product.product_name')}} <span class="text-red-600">*</span></label>
                <input type="text" value="{{ old('name', $product->name) }}" name="name" class="w-full rounded @error('name') border-red-600 @enderror border-gray-400">
                @error('name') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3">
                <label for="">{{__('product.product_sku')}}</label>
                <input type="text" value="{{ old('sku', $product->sku) }}" name="sku" class="w-full rounded @error('sku') border-red-600 @enderror border-gray-400">
                @error('sku') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control mb-3">
                    <label for="">{{__('product.buy_price')}}</label>
                    <input type="text" value="{{ old('buy_price',$product->buy_price() ?? 0) }}" min="0" name="buy_price" class="w-full mask rounded @error('buy_price') border-red-600 @enderror border-gray-400">
                    @error('buy_price') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
                </div>

                <div class="form-control mb-3">
                    <label for="">{{__('product.sell_price')}}</label>
                    <input type="text" value="{{ old('sell_price',$product->sell_price() ?? 0) }}" min="0" name="sell_price" class="w-full mask rounded @error('buy_price') border-red-600 @enderror border-gray-400">
                    @error('sell_price') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-control mb-3">
                <label for="">{{__('general.description')}}</label>
                <textarea name="description" class="rounded @error('description') border-red-600 @enderror border-gray-400 " id="" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                @error('description') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="md:col-span-2 rounded-lg shadow bg-white p-5">
            
            <div class="form-control mb-3  @error('photo') border border-red-600 @enderror">
                @if($product->photo) 
                <img src="{{ asset($product->photo) }}" style="width: 100%" class="h-52 object-cover mb-4 shadow-lg" alt="">
                @endif
                <label for="" >{{__('product.product_image')}}</label>
                <input type="file" name="photo" id="" value="{{ old('photo') }}">
                @error('photo') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3">
                <label for="">{{__('product.tax')}}</label>
                <select name="tax_id" id="selectTax" class="w-full rounded  @error('tax_id') border-red-600 @enderror border-gray-400">
                    <option value="" >{{__('product.no_tax')}}</option>
                    @foreach (App\Models\Tax::select('id','name')->get() as $item)
                    <option @if(old('tax_id', $product->tax_id) == $item->id) selected @endif value="{{ $item->id }}"> {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('tax_id') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3" id="isTaxSelected" style="@if(!old('tax_id') && !$product->tax_id) display: none @endif">
                <label for="">{{__('product.tax_type')}}</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="taxInclude" @if(!old('tax_id') && !$product->tax_id) disabled @endif value="include" name="tax_type" class="radio " @if(old('tax_type', $product->tax_type) == 'include') checked @endif />
                        <span class="label-text">{{__('product.tax_include')}}</span> 
                    </label>

                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="taxExclude" @if(!old('tax_id') && !$product->tax_id) disabled @endif value="exclude" name="tax_type" class="radio " @if(old('tax_type', $product->tax_type) == 'exclude') checked @endif />
                        <span class="label-text">{{__('product.tax_exclude')}}</span> 
                    </label> 
                </div>
                @error('tax_type') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3 mt-4" >
                <label for="">{{__('product.product_tracked')}}</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="trackedYes" value="yes" name="is_tracked" class="radio " @if(old('is_tracked') == 'yes' || $product->is_tracked == 1) checked @endif  />
                        <span class="label-text">{{__('general.yes')}}</span> 
                    </label>

                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="trackedNo" value="no" name="is_tracked" class="radio " @if(old('is_tracked') == 'no' || $product->is_tracked == 0) checked @endif/>
                        <span class="label-text">{{__('general.no')}}</span> 
                    </label> 
                </div>
                @error('is_tracked') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3 mt-3" id="isTracked" style="@if(!old('is_tracked') && $product->is_tracked == 0) display: none @endif">
                <label for="">{{__('product.current_stock')}}</label>
                <input type="text" value="{{ old('stock', $product->latest_stock() ?? 0) }}" name="stock" id="inputStock" @if(!old('is_tracked') && $product->is_tracked == 0) disabled @endif class="w-full mask rounded @error('stock') border-red-600 @enderror border-gray-400">
                @error('stock') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="mt-6">
                <button class="bg-primary py-2 w-full text-white uppercase rounded">{{__('general.save')}}</button>
            </div>
        </div>
    </div>
    </form>
    
@endsection

@push('js')
    <script src="{{ asset('js/jquery.mask.js') }}" ></script>
    <script>
        $(document).ready(function() {
            $("#selectTax").on('change', function() {
                let vals = $(this).val()
                if(vals !== '') {
                    $("#isTaxSelected").show()
                    $("#taxInclude").prop('disabled',false)
                    $("#taxExclude").prop('disabled',false)
                } else {
                    $("#isTaxSelected").hide()
                    $("#taxInclude").prop('disabled',true)
                    $("#taxExclude").prop('disabled',true)
                }
            });

            $("#trackedYes").on('click', function() {
                $("#isTracked").show();
                $("#inputStock").prop('disabled',false)
            });

            $("#trackedNo").on('click', function() {
                $("#isTracked").hide();
                $("#inputStock").prop('disabled',true)
            });

            $(".mask").on('focus', function() {
                if($(this).val() == 0) {
                    $(this).val('');
                }
            });

            $(".mask").on('change', function() {
                if($(this).val() == '') {
                    $(this).val(0);
                }
            });

            $(".mask").mask('#,##0', {reverse: true});

            $("#formProduct").on('submit', function() {
                $(this).find('.mask').each(function () {
                    $(this).unmask();
                });
            });

        });
    </script>
@endpush