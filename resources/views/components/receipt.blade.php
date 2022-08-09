<div id="canvasPrint" class="struk bg-white p-2 font-mono" style="display: none; width: 400px">
    <div id="insideCanvas">
        <div style="display: flex; justify-content:center; padding: 10px 0;">
            {{-- <img src="{{ asset('images/logo_delapan_square.png') }}" style="width: 100px" alt=""> --}}
            <h1 class="text-xl">{{ (new \App\Helper\SettingHelper)->company_name() }}</h1>
            
        </div>
        <div style="text-align: center; border-bottom: dashed 1.5px; padding-bottom: 5px; margin-top: -10px">
            {{-- <small style="font-size: 10px; text-align:center">{{ $transaction->shift_session->outlet->address ?? '' }}</small> <br>
            <small style="font-size: 10px; text-align:center">Telpon/HP: {{ $transaction->shift_session->outlet->phone ?? '-' }}</small> --}}
        </div>
        <div style=" border-bottom: dashed 1.5px; margin-top: 5px; padding-bottom: 5px">
            <table style="font-size: 9px; width: 100%;">
                <tr>
                    <td style="width: 30%">Operator</td>
                    <td style="width: 70%">{{ auth()->user()->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 30%">Tanggal</td>
                    <td style="width: 70%">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <td style="width: 30%">ID</td>
                    <td style="width: 70%">{{ $transaction->code }}</td>
                </tr>
                <tr>
                    <td style="width: 30%">Payment</td>
                    <td style="width: 70%">{{ $transaction->payment_method_id == 0 ? 'Cash' : $transaction->payment_method->name }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 10px; border-bottom: dashed 1.5px; padding-bottom: 5px">
            <table style="font-size: 9px; width: 100%;">
                @foreach ($transaction->details as $item)
                <tr style="padding: 10px 0">
                    <td style="width: 60%; padding: 5px 0">
                        <span>{{ $item->product_id ? $item->product_name : $item->custom_product_name }}<br>{{$item->amount}}x Rp. {{ number_format($item->price) }} </span>
                    </td>
                    <td style="width: 40%; text-align:right;  padding: 5px 0">Rp. {{ number_format($item->total) }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div style="margin-top: 10px; border-bottom: dashed 1.5px; padding-bottom: 5px">
            <table style="font-size: 9px; width: 100%;">
                <tr style="padding: 0">
                    <td style="width: 60%;">
                        <span>Total </span>
                    </td>
                    <td style="width: 40%; text-align:right;">Rp.{{ number_format($transaction->total) }}</td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <span>Pajak
                    </td>
                    <td style="width: 40%; text-align:right; ">Rp. {{ number_format($transaction->tax) }}</td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <span>Potongan
                    </td>
                    <td style="width: 40%; text-align:right; ">-Rp. {{ number_format($transaction->discount) }}</td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <span>Grand Total
                    </td>
                    <td style="width: 40%; text-align:right;">Rp. {{ number_format($transaction->grandTotal) }}</td>
                </tr>
            </table>
        </div>
        @if ($transaction->change_amount)
        <div style="margin-top: 10px; border-bottom: dashed 1.5px; padding-bottom: 5px">
            <table style="font-size: 9px; width: 100%;">
                <tr style="padding: 10px 0">
                    <td style="width: 60%;">
                        <span>Jumlah Uang </span>
                    </td>
                    <td style="width: 40%; text-align:right;">Rp.{{ number_format($transaction->cash_amount) }}</td>
                </tr>
                <tr>
                    <td style="width: 60%; padding: 5px 0">
                        <span>Kembalian
                    </td>
                    <td style="width: 40%; text-align:right; ">Rp. {{ number_format($transaction->change_amount) }}</td>
                </tr>
            </table>
        </div>
        @endif
        

        <div style="font-size: 10px; text-align:center; margin-top: 20px">
            - Terima Kasih -
        </div>
        {{-- <div style="font-size: 9px; text-align:center; margin-top: 10px">
            <div><img src="{{ asset('images/web.png') }}" style="width: 12px" alt=""> delapanbarbershop.com </div>
            <div style="margin-top: 6px"> <img src="{{ asset('images/ig.png') }}" style="width: 12px" alt=""> delapanbarbershop.co</div>
        </div> --}}
    </div>
</div>

