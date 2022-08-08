@extends('layouts.default', [])

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-2xl">{{__('product.title')}}</h3>
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
    <a href="{{ route('product.create') }}" class="fixed bottom-10 z-50 right-10 bg-primary w-16 h-16 cursor-pointer hover:bg-secondary rounded-full text-white flex justify-center items-center text-4xl">
        <ion-icon  name="add-outline"></ion-icon>
    </a>

    <div class="mt-4 bg-white shadow-lg rounded mb-16">
        <table class="table-fixed w-full">
            <thead class="bg-primary text-white">
                <th class="py-2" style="width: 10%">#</th>
                <th class="py-2 text-left" style="width: 25%">{{__('product.product_name')}}</th>
                <th class="py-2 text-left">{{__('product.sku')}}</th>
                <th class="py-2 text-right">{{__('product.buy_price')}}</th>
                <th class="py-2 text-right">{{__('product.sell_price')}}</th>
                <th class="py-2">{{__('product.current_stock')}}</th>
                {{-- <th class="py-2">Created at</th> --}}
                <th class="py-2">{{__('general.option')}}</th>
            </thead>
            <tbody>
                @forelse ($products as $item)
                <tr class="border-b">
                    <td class="py-2 text-center">{{ ($products->currentpage()-1) * $products->perpage() + $loop->index + 1 }}</td>
                    <td class="py-2 flex gap-3 items-center">
                        @if($item->photo)
                        <img src="{{ asset($item->photo) }}" alt="" class="w-8 h-8 object-cover rounded-full">
                        @else
                        <img src="{{ asset('images/no_product.png') }}" alt="" class="w-8 h-8 object-cover rounded-full">
                        @endif
                        <span>{{ $item->name }}</span>
                    </td>
                    <td class="py-2">{{ $item->sku }}</td>
                    <td class="py-2 text-right">Rp. {{ number_format($item->buy_price()) }}</td>
                    <td class="py-2 text-right">Rp. {{ number_format($item->sell_price()) }}</td>
                    {{-- <td class="py-2 text-right">{{ $item->created_at }}</td> --}}
                    <td class="py-2 text-center">
                        @if ($item->is_tracked)
                            {{ number_format($item->latest_stock()) }}
                        @else
                        <span class="bg-yellow-200 rounded-xl py-1 px-2 text-xs">not tracked</span>    
                        @endif
                    </td>
                    <td class="text-center py-2 align-middle">
                        <div class="flex justify-center items-center gap-2">
                            <a href="" class="text-xs text-blue-600 hover:text-blue-700"><ion-icon size="small" name="eye"></ion-icon></a>
                            <a href="{{ route('product.edit',$item->id) }}" class="text-xs text-orange-500 hover:text-yellow-600"><ion-icon size="small" name="create"></ion-icon></a>
                            <form action="{{ route('product.destroy',$item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('{{__('general.delete_confirm')}}')"><ion-icon size="small" name="trash"></ion-icon></button>
                            </form>
                        </div>
                        
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-3 text-center">Data not found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="py-2 px-4">
            {{ $products->links() }}
        </div>
    </div>

    <form action="{{ route('product.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="product" id="">
        <button>upload</button>
    </form>
@endsection