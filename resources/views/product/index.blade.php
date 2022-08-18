@extends('layouts.default', [])

@section('content')
    <div class="flex justify-between items-center relative">
        <h3 class="text-xl md:text-2xl">{{__('product.title')}}</h3>
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

    <a href="{{ route('product.create') }}" class="fixed bottom-10 z-50 right-4 md:right-10 bg-primary w-12 h-12 md:w-16 md:h-16 cursor-pointer hover:bg-secondary rounded-full text-white flex justify-center items-center text-4xl">
        <ion-icon  name="add-outline"></ion-icon>
    </a>

    <div class="mt-4 bg-white shadow-lg rounded mb-28 md:mb-16">
        <table class="table-fixed w-full">
            <thead class="bg-primary text-white hidden md:table-header-group">
                <th class="py-2 hidden md:table-cell" style="width: 10%">#</th>
                <th class="py-2 text-left" style="width: 25%">{{__('product.product_name')}}</th>
                <th class="py-2 text-left hidden md:table-cell">{{__('product.sku')}}</th>
                <th class="py-2 text-right hidden md:table-cell">{{__('product.buy_price')}}</th>
                <th class="py-2 text-right hidden md:table-cell">{{__('product.sell_price')}}</th>
                <th class="py-2 hidden md:table-cell">{{__('product.current_stock')}}</th>
                {{-- <th class="py-2">Created at</th> --}}
                <th class="py-2">{{__('general.option')}}</th>
            </thead>
            <tbody>
                @forelse ($products as $item)
                <tr class="border-b">
                    <td class="py-2 text-center hidden md:table-cell">{{ ($products->currentpage()-1) * $products->perpage() + $loop->index + 1 }}</td>
                    <td class="py-2 px-2 md:px-0 md:w-auto flex gap-3 items-center">
                        @if($item->photo)
                        <img src="{{ asset($item->photo) }}" alt="" class="w-8 h-8 object-cover rounded-full">
                        @else
                        <img src="{{ asset('images/no_product.png') }}" alt="" class="w-8 h-8 object-cover rounded-full">
                        @endif
                        <span>{{ $item->name }}</span>
                    </td>
                    <td class="py-2 hidden md:table-cell">{{ $item->sku }}</td>
                    <td class="py-2 text-right hidden md:table-cell">Rp. {{ number_format($item->buy_price()) }}</td>
                    <td class="py-2 text-right hidden md:table-cell">Rp. {{ number_format($item->sell_price()) }}</td>
                    {{-- <td class="py-2 text-right">{{ $item->created_at }}</td> --}}
                    <td class="py-2 text-center hidden md:table-cell">
                        @if ($item->is_tracked)
                            {{ number_format($item->latest_stock()) }}
                        @else
                        <span class="bg-yellow-200 rounded-xl py-1 px-2 text-xs">not tracked</span>    
                        @endif
                    </td>
                    <td class="md:text-center py-2 align-middle" style="width: 25%">
                        <div class="flex justify-center w-full items-center" style="gap: 15px">
                            {{-- <a href="" class="text-xs text-blue-600 hover:text-blue-700"><ion-icon size="small" name="eye"></ion-icon></a> --}}
                            <a href="{{ route('product.edit',$item->id) }}" class="text-lg text-orange-500 hover:text-yellow-600"><i class="fa-solid fa-edit"></i></a>
                            <form action="{{ route('product.destroy',$item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-lg" onclick="return confirm('{{__('general.delete_confirm')}}')"> <i class="fa-solid fa-trash"></i> </button>
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

    {{-- <form action="{{ route('product.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="product" id="">
        <button>upload</button>
    </form> --}}
@endsection