@extends('layouts.default', [])

@section('content')
    
    
<div class="max-w-xl mx-auto p-6 bg-white">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-xl">{{__('pos.transaction')}} #{{$transaction->code}}</h1>
            <span>{{$transaction->created_at->translatedFormat('d M Y, H:i')}}</span>
        </div>

        <div class="gap-1 flex">
            <button id="printThis" type="button" class="bg-primary rounded py-2 px-3 hover:bg-secondary text-white"><i class="fa-solid fa-print mr-2"></i> {{__('general.print')}}</button>
            <a href="{{ route('pos.transactions') }}" class="bg-red-600 hover:bg-red-700 rounded items-center flex text-white px-4"><i class="fa-solid fa-times"></i></a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 py-4">
        <div>
            <span>{{__('pos.total_transaction')}}</span>
            <p class="text-3xl font-bold">Rp. {{number_format($transaction->grandTotal)}}</p>
        </div>
        <div>
            <span>{{__('pos.payment_method')}}</span>
            <p class="text-2xl font-bold">{{ $transaction->payment_method_id == 0 ? 'Cash' : $transaction->payment_method->name }}</p>
        </div>
        @if ($transaction->payment_method == 0)
        <div>
            <span>{{__('pos.cash_amount')}}</span>
            <p class="text-3xl font-bold">Rp. {{number_format($transaction->cash_amount)}}</p>
        </div>
        <div class="text-red-600">
            <span>{{__('pos.change')}}</span>
            <p class="text-3xl font-bold">Rp. {{number_format($transaction->change_amount)}}</p>
        </div>
        @endif
    </div>

    <div class="py-4 border-t border-gray-200">
        <span class="text-sm">{{__('pos.transaction_detail')}}</span>
        @foreach ($transaction->details as $item)
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="leading-tight" style="width: 70%">
                    <p class="productName">{{ $item->product_id ? $item->product_name : $item->custom_product_name }}</p>
                    <small>@ {{$item->amount}} x Rp. {{number_format($item->price)}}</small>
                </span>
                <span>Rp. {{ number_format($item->total ?? 0) }}</span>
            </div>
        @endforeach
        <div class="flex justify-between py-1 border-b border-gray-100">
            <span>{{__('pos.tax')}}</span>
            <span>Rp. {{ number_format($transaction->tax) }}</span>
        </div>
        <div class="flex justify-between py-1 border-b border-gray-100">
            <span>{{__('pos.discount')}}</span>
            <span>-Rp. {{ number_format($transaction->discount) }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-100 bg-gray-100 font-semibold">
            <span>{{__('pos.grand_total')}}</span>
            <span>Rp. {{ number_format($transaction->grandTotal) }}</span>
        </div>
    </div>
</div>
@endsection