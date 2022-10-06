@extends('layouts.default', [])

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-xl md:text-2xl">{{__('pos.transaction_pos')}}</h3>
        <div class="form-control">
            <form action="?" class="">
                <div class="flex">
                    <input type="text" name="q" value="{{request('q') }}" class="w-16 md:w-32 hover:w-full py-1 rounded-l border border-gray-300" placeholder="{{__('general.search')}}...">
                    <button class="py-1 bg-primary px-2 rounded-r flex items-center text-white font-bold">
                        <ion-icon size="small" name="search-outline"></ion-icon>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (request('q'))
    <div class="pt-2 flex items-center gap-2">
        <small class="text-sm">{{__('general.search_for')}} : {{request('q')}}</small>
        <a href="?" class="text-red-600"><i class="fa-solid fa-times"></i></a>
    </div>
    @endif

    <div class="py-3 flex overflow-auto w-full gap-1">
        <a href="?type=all" class="@if(request('type') == 'all' || !request('type')) bg-primary text-white @else text-secondary @endif border hover:border-secondary block px-6 py-1 rounded">{{__('general.all')}}</a>
        <a href="?type=daily" class="@if(request('type') == 'daily') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 block rounded">{{__('general.daily')}}</a>
        <a href="?type=weekly" class="@if(request('type') == 'weekly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 block rounded">{{__('general.weekly')}}</a>
        <a href="?type=monthly" class="@if(request('type') == 'monthly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 block rounded">{{__('general.monthly')}}</a>
        <a href="?type=yearly" class="@if(request('type') == 'yearly') bg-primary text-white @else text-secondary @endif border hover:border-secondary px-6 py-1 block rounded">{{__('general.yearly')}}</a>
    </div>

    <div class="mt-4 mb-16">
        
        @if (request('type') == 'all' || !request('type')) 
            
            <table class="table w-full max-w-5xl">
                <thead class="hidden md:table-header-group">
                    <th class="hidden text-sm md:text-md md:table-cell">#</th>
                    <th class="text-xs md:text-md">{{__('general.date')}}</th>
                    <th class="text-xs md:text-md text-right hidden md:table-cell">Diskon</th>
                    <th class="text-xs md:text-md text-right hidden md:table-cell">Pajak</th>
                    <th class="text-xs md:text-md text-right">Grand Total</th>
                    <th class="text-xs md:text-md hidden md:table-cell">Payment</th>
                    <th class="text-xs md:text-md">{{__('general.option')}}</th>
                </thead>
                <tbody> 
                    @forelse ($transactions as $item)
                    <tr>
                        <td class="text-sm md:text-md hidden md:table-cell">{{$loop->iteration}}</td>
                        <td class="text-sm md:text-md">{{$item->created_at->format('d M Y, H:i')}}</td>
                        <td class="text-sm md:text-md text-right hidden md:table-cell">Rp. {{number_format($item->discount)}}</td>
                        <td class="text-sm md:text-md text-right hidden md:table-cell">Rp. {{number_format($item->tax)}}</td>
                        <td class="text-sm md:text-md text-right">Rp. {{number_format($item->grandTotal)}}</td>
                        <td class="text-sm md:text-md hidden md:table-cell">
                            {{ $item->payment_method_id == 0 ? 'Cash' : $item->payment_method->name }}
                        </td>
                        <td class="text-sm md:text-md w-3 md:w-auto">
                            <a class="text-primary" href="{{ route('pos.transaction.show',$item->id) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
            
            @else
            <table class="table w-full max-w-2xl">
                <thead class="hidden md:table-header-group">
                    <th>#</th>
                    <th>{{__('general.date')}}</th>
                    <th class="text-right">Grand Total</th>
                    <th class="text-center">Jml Transaksi</th>
                    {{-- <th>{{__('general.option')}}</th> --}}
                </thead>
                <tbody> 
                    @forelse ($transactions as $item)
                    <tr>
                        <td class="hidden md:table-cell text-sm md:text-md">{{$loop->iteration}}</td>
                        <td class="text-sm md:text-md">
                            @if (request('type') == 'weekly')
                            {{__('general.week_to')}}
                            @endif
                            
                            @if(request('type') == 'daily')
                            {{\Carbon\Carbon::parse($item->date)->format('d M Y')}}
                            @elseif(request('type') == 'monthly')
                            {{\Carbon\Carbon::create()->month($item->date)->isoFormat('MMMM')}}
                            @else 
                            {{$item->date}}
                            @endif
                        </td>
                        <td class="text-sm md:text-md text-right">Rp. {{number_format($item->grand_total)}}</td>
                        <td class="hidden md:table-cell text-sm md:text-md text-center">{{$item->transaction_num}}</td>
                        {{-- <td class="text-sm md:text-md">
                            <a class="text-primary" href="{{ route('pos.transaction.show',$item->id) }}">detail</a>
                        </td> --}}
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
            @endif
            {{ $transactions->links() }}
    </div>

    {{-- <form action="{{ route('product.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="product" id="">
        <button>upload</button>
    </form> --}}
@endsection