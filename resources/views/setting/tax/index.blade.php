@extends('layouts.default', [])

@section('content')
    <div class="flex justify-between items-center relative">
        <h3 class="text-xl md:text-2xl">{{__('setting.manage_tax')}}</h3>
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

    <label for="addTax" class="fixed bottom-10 z-50 right-4 md:right-10 bg-primary w-12 h-12 md:w-16 md:h-16 cursor-pointer hover:bg-secondary rounded-full text-white flex justify-center items-center text-4xl">
        <ion-icon  name="add-outline"></ion-icon>
    </label>

    <div class="mt-4 bg-white shadow-lg rounded mb-28 md:mb-16 max-w-2xl">
        <table class="table-fixed w-full">
            <thead class="bg-primary text-white hidden md:table-header-group">
                <th class="py-2 hidden md:table-cell" style="width: 10%">#</th>
                <th class="py-2 text-left" style="width: 25%">{{__('setting.tax_name')}}</th>
                <th class="py-2 text-left" style="width: 25%">{{__('setting.percentage')}}</th>
                <th class="py-2">{{__('general.option')}}</th>
            </thead>
            <tbody>
                @foreach ($taxes as $tax)
                <tr class="border-b border-gray-200">
                    <td class="py-2 px-2 text-center hidden md:table-cell">{{$loop->iteration}}</td>
                    <td class="py-2 px-2 hidden md:table-cell">{{$tax->name}}</td>
                    <td class="py-2 px-2 hidden md:table-cell">{{$tax->percent}}%</td>
                    <td class="md:text-center py-2 px-2 align-middle" style="width: 25%">
                        <div class="flex justify-center w-full items-center" style="gap: 15px">
                            {{-- <a href="" class="text-xs text-blue-600 hover:text-blue-700"><ion-icon size="small" name="eye"></ion-icon></a> --}}
                            <label 
                                for="editTax" 
                                class="text-lg cursor-pointer text-orange-500 hover:text-yellow-600"
                                onclick="editTax(this)"
                                data-id="{{ $tax->id }}"
                                data-name="{{$tax->name}}"
                                data-percent="{{$tax->percent}}"
                                data-route="{{route('taxes.update',$tax->id)}}"
                            >
                                <i class="fa-solid fa-edit"></i>
                            </label>
                            <form action="{{ route('taxes.destroy',$tax->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-lg" onclick="return confirm('{{__('general.delete_confirm')}}')"> <i class="fa-solid fa-trash"></i> </button>
                            </form>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="py-2 px-4">
            {{ $taxes->links() }}
        </div>
    </div>

    <input type="checkbox" id="addTax" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">{{__('setting.add_tax')}}</h3>
            <form action="" method="POST" id="createTax">
            @csrf
            <div class="mt-3 mb-4">
                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.tax_name')}}</label>
                    <input name="name" type="text" value="{{old('name')}}" class="w-full rounded py-2 border border-gray-400 @error('name') border-red-600 @enderror" required>
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.percentage')}}</label>
                    <input max="100" name="percent" type="number" step="0.01" value="{{old('percent')}}"  class="w-full rounded py-2 border border-gray-400 @error('percent') border-red-600 @enderror" required>
                    @error('percent')<small class="text-xs text-red-600">{{$message}}</small>@enderror
                </div>
            </div>

            <div class="modal-action mt-8 text-right">
                <label for="addTax" class="bg-red-600 hover:bg-red-700 cursor-pointer py-2 px-4 rounded-lg text-white">{{__('general.cancel')}}</label>
                <button type="submit" class="bg-primary hover:bg-secondary py-2 px-8 rounded-lg text-white">{{__('general.save')}}</button>
            </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="editTax" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">{{__('setting.add_tax')}}</h3>
            <form action="" method="POST" id="updateTax">
            @csrf @method('PUT')
            <div class="mt-3 mb-4">
                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.tax_name')}}</label>
                    <input id="taxName" name="name" type="text" value="{{old('name')}}" class="w-full rounded py-2 border border-gray-400 @error('name') border-red-600 @enderror" required>
                </div>

                <div class="form-control mb-2">
                    <label for="" class="text-sm">{{__('setting.percentage')}}</label>
                    <input max="100" id="taxPercent" name="percent" type="number" step="0.01" value="{{old('percent')}}"  class="w-full rounded py-2 border border-gray-400 @error('percent') border-red-600 @enderror" required>
                    @error('percent')<small class="text-xs text-red-600">{{$message}}</small>@enderror
                </div>
            </div>

            <div class="modal-action mt-8 text-right">
                <label for="editTax" class="bg-red-600 hover:bg-red-700 cursor-pointer py-2 px-4 rounded-lg text-white">{{__('general.cancel')}}</label>
                <button type="submit" class="bg-primary hover:bg-secondary py-2 px-8 rounded-lg text-white">{{__('general.save')}}</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        function editTax(el) {
            $("#taxName").val($(el).data('name'));
            $("#taxPercent").val($(el).data('percent'));
            $("#updateTax").prop('action',$(el).data('route'));
        }
    </script>
@endsection