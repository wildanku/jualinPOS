<div class="w-full bg-white rounded-lg p-5">
    <h3 class="text-lg md:text-xl">{{__('widget.best_selling_product')}}</h3>

    <div class="mt-3" id="productsDom">
      <table class="w-full">
        
        <tbody>
          @foreach ($products as $item)
          <tr class="border-t border-gray-200">
            <td class="py-2">{{ $loop->iteration }}</td>
            <td class="py-2">{{ $item->name }}</td>
            <td class="py-2 text-right">{{$item->amount}}</td>
            <td class="py-2 text-right">{{ currency()->symbol.'. '.number_format($item->total) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

</div>

@push('js')
    
@endpush