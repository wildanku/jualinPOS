@extends('layouts.default', [])

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-2xl">{{__('pos.transaction_pos')}}</h3>
        <div class="form-control">
            <form action="?">
                <div class="input-group">
                    <input type="text" placeholder="Search…" class="input input-bordered" />
                    <button class="btn btn-square">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-3">
        <a href="?type=all" class="@if(request('type') == 'all' || !request('type')) bg-primary text-white @else text-secondary @endif border hover:border-secondary  px-6 py-1 rounded">{{__('general.all')}}</a>
        <a href="?type=daily" class="@if(request('type') == 'daily') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 rounded">{{__('general.daily')}}</a>
        <a href="?type=weekly" class="@if(request('type') == 'weekly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 rounded">{{__('general.weekly')}}</a>
        <a href="?type=monthly" class="@if(request('type') == 'monthly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 rounded">{{__('general.monthly')}}</a>
        <a href="?type=yearly" class="@if(request('type') == 'yearly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 rounded">{{__('general.yearly')}}</a>
    </div>

    <div class="mt-4 mb-16">
        
        @if (request('type') == 'all' || !request('type')) 
            
            <table class="table w-full max-w-5xl">
                <thead>
                    <th>#</th>
                    <th>{{__('general.date')}}</th>
                    <th class="text-right">Diskon</th>
                    <th class="text-right">Pajak</th>
                    <th class="text-right">Grand Total</th>
                    <th class="">Payment</th>
                    <th>{{__('general.option')}}</th>
                </thead>
                <tbody> 
                    @forelse ($transactions as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->created_at->format('d M Y, H:i')}}</td>
                        <td class="text-right">Rp. {{number_format($item->discount)}}</td>
                        <td class="text-right">Rp. {{number_format($item->tax)}}</td>
                        <td class="text-right">Rp. {{number_format($item->grandTotal)}}</td>
                        <td class="">
                            {{ $item->payment_method_id == 0 ? 'Cash' : $item->payment_method->name }}
                        </td>
                        <td class="">
                            <a class="text-primary" href="{{ route('pos.transaction.show',$item->id) }}">detail</a>
                        </td>
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
            
            @else
            <table class="table w-full max-w-2xl">
                <thead>
                    <th>#</th>
                    <th>{{__('general.date')}}</th>
                    <th class="text-right">Grand Total</th>
                    <th class="text-center">Jml Transaksi</th>
                    <th>{{__('general.option')}}</th>
                </thead>
                <tbody> 
                    @forelse ($transactions as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->date}}</td>
                        <td class="text-right">Rp. {{number_format($item->grand_total)}}</td>
                        <td class="text-center">{{$item->transaction_num}}</td>
                        <td class="">
                            {{-- <a class="text-primary" href="{{ route('pos.transaction.show',$item->id) }}">detail</a> --}}
                        </td>
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
            @endif
            {{-- {{ $transactions->links() }} --}}
    </div>

    {{-- <form action="{{ route('product.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="product" id="">
        <button>upload</button>
    </form> --}}
@endsection