@extends('layouts.default', [])

@section('content')
    
    
<div class="max-w-xl mx-auto p-6 bg-white">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-xl">Transaction #{{$transaction->code}}</h1>
            <span>{{$transaction->created_at->format('d M Y, H:i')}}</span>
        </div>

        <div class="gap-1 flex">
            <button id="printThis" type="button" class="bg-primary rounded py-2 px-3 hover:bg-secondary text-white"><i class="fa-solid fa-print mr-2"></i> Print</button>
            <a href="{{ route('pos.transactions') }}" class="bg-red-600 hover:bg-red-700 rounded items-center flex text-white px-4"><i class="fa-solid fa-times"></i></a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 py-4">
        <div>
            <span>Total Transaction</span>
            <p class="text-3xl font-bold">Rp. {{number_format($transaction->grandTotal)}}</p>
        </div>
        <div>
            <span>Change Amount</span>
            <p class="text-3xl font-bold">Rp. {{number_format($transaction->changeAmount)}}</p>
        </div>
        <div>
            <span>Payment Method</span>
            <p class="text-2xl font-bold">{{ $transaction->payment_method_id == 0 ? 'Cash' : $transaction->payment_method->name }}</p>
        </div>
    </div>

    <div class="py-4 border-t border-gray-200">
        <span class="text-sm">Transaction Detail</span>
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
            <span>Tax</span>
            <span>Rp. {{ number_format($transaction->tax) }}</span>
        </div>
        <div class="flex justify-between py-1 border-b border-gray-100">
            <span>Discount</span>
            <span>-Rp. {{ number_format($transaction->discount) }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-100 bg-gray-100 font-semibold">
            <span>Grand Total</span>
            <span>Rp. {{ number_format($transaction->grandTotal) }}</span>
        </div>
    </div>
</div>

    {{-- <form action="{{ route('product.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="product" id="">
        <button>upload</button>
    </form> --}}
@endsection