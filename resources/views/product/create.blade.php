@extends('layouts.default', [])

@section('content')
    <div class="flex gap-2 items-center">
        <x-arrow-component :url="route('product.index')" />
        <h3 class="text-2xl m-0">Create Product</h3>
    </div>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6 items-start">
        <div class="md:col-span-3 bg-white shadow rounded-lg p-5">
            <div class="form-control mb-3">
                <label for="">Product Name <span class="text-red-600">*</span></label>
                <input type="text" value="{{ old('name') }}" name="name" class="w-full rounded @error('name') border-red-600 @enderror border-gray-400">
                @error('name') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3">
                <label for="">Product SKU </label>
                <input type="text" value="{{ old('sku') }}" name="sku" class="w-full rounded @error('sku') border-red-600 @enderror border-gray-400">
                @error('sku') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control mb-3">
                    <label for="">Buy Price</label>
                    <input type="number" value="{{ old('buy_price',0) }}" min="0" name="buy_price" class="w-full rounded @error('buy_price') border-red-600 @enderror border-gray-400">
                    @error('buy_price') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
                </div>

                <div class="form-control mb-3">
                    <label for="">Sell Price</label>
                    <input type="number" value="{{ old('sell_price',0) }}" min="0" name="sell_price" class="w-full rounded @error('buy_price') border-red-600 @enderror border-gray-400">
                    @error('sell_price') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-control mb-3">
                <label for="">Description</label>
                <textarea name="description" class="rounded @error('description') border-red-600 @enderror border-gray-400 " id="" cols="30" rows="10">{{ old('description') }}</textarea>
                @error('description') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="md:col-span-2 rounded-lg shadow bg-white p-5">
            
            <div class="form-control mb-3  @error('photo') border border-red-600 @enderror">
                <label for="" >Product Image</label>
                <input type="file" name="photo" id="" value="{{ old('photo') }}">
                @error('photo') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3">
                <label for="">Tax</label>
                <select name="tax_id" id="selectTax" class="w-full rounded  @error('tax_id') border-red-600 @enderror border-gray-400">
                    <option value="" >No Tax</option>
                    @foreach (App\Models\Tax::select('id','name')->get() as $item)
                    <option @if(old('tax_id') == $item->id) selected @endif value="{{ $item->id }}"> {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('tax_id') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3" id="isTaxSelected" style="@if(!old('tax_id')) display: none @endif">
                <label for="">Tax Type</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="taxInclude" @if(!old('tax_id')) disabled @endif value="include" name="tax_type" class="radio " @if(old('tax_type') == 'include') checked @endif />
                        <span class="label-text">Include</span> 
                    </label>

                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="taxExclude" @if(!old('tax_id')) disabled @endif value="exclude" name="tax_type" class="radio " @if(old('tax_type') == 'exclude' || !old('tax_type')) checked @endif />
                        <span class="label-text">Exclude</span> 
                    </label> 
                </div>
                @error('tax_type') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3 mt-4" >
                <label for="">Product Tracked?</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="trackedYes" value="yes" name="is_tracked" class="radio " @if(old('is_tracked') == 'yes') checked @endif  />
                        <span class="label-text">Yes</span> 
                    </label>

                    <label class="flex gap-2 items-center cursor-pointer">
                        <input type="radio" id="trackedNo" value="no" name="is_tracked" class="radio " @if(old('is_tracked') == 'no' || !old('is_tracked') ) checked @endif/>
                        <span class="label-text">No</span> 
                    </label> 
                </div>
                @error('is_tracked') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="form-control mb-3 mt-3" id="isTracked" style="@if(!old('is_tracked')) display: none @endif">
                <label for="">Current Stock</label>
                <input type="number" value="{{ old('stock',0) }}" name="stock" id="inputStock" @if(!old('is_tracked')) disabled @endif class="w-full rounded @error('stock') border-red-600 @enderror border-gray-400">
                @error('stock') <small class="text-xs text-red-600">{{ $message }}</small>@enderror
            </div>

            <div class="mt-6">
                <button class="bg-primary py-2 w-full text-white uppercase rounded">Save</button>
            </div>
        </div>
    </div>
    </form>
    
@endsection

@push('js')
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


        });
    </script>
@endpush