@extends('layouts.pos')
@push('css')
    <style>
        
    </style>
@endpush
@section('content')
<div class="w-full items-start grid grid-cols-1 md:grid-cols-6 h-5/6 gap-4">
    <div class="md:col-span-4">
        <div class="w-full">
            <input id="searchProduct" type="text" placeholder="Search Product or SKU..." class="text-xl w-full py-2 rounded-lg bg-gray-50 shadow-lg border-gray-300">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4 gap-3" id="products">
            
        </div>
    </div>

    <div class="hidden md:col-span-2 md:block " >
        <div class="p-4 rounded-lg bg-white shadow-lg relative" style="height: 70vh">
            <div class="flex justify-between">
                <h3 class="text-xl">Transactions</h3>
                <button type="button" onClick="clearCart()" class="bg-red-600 hover:bg-red-700 rounded-full py-1 px-4 text-sm text-white"><i class="fa-solid fa-times mr-2"></i> Clear</button> 
            </div>

            <div class="">
                <div class="border-t border-gray-100 mt-5 pt-2 overflow-auto" style="height: 55vh" id="listCart"></div>
                
                <div class="absolute bottom-1 py-2 left-0 w-full border-t mt-3 border-gray-300">
                    <div class="flex justify-between items-center px-4 py-1">
                        <span>Sub Total</span>
                        <span id="subTotal">Rp. 0</span>
                    </div>
                    <div class="flex justify-between items-center px-4 py-1">
                        <span>Tax</span>
                        <span id="totalTax">Rp. 0</span>
                    </div>
                </div>
                
                <div class="absolute top-0 left-0 flex justify-center items-center w-full" style="height: 50vh" id="noCart">
                    <div class="">
                        <img style="width: 150px" src="{{ asset('images/no_cart.png') }}" alt="">
                        <div class="uppercase text-center mt-4 text-gray-600">No Cart</div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-3 w-full flex items-center gap-1">
            <label for="modalCustomProduct" class="modal-button cursor-pointer border border-primary py-3 px-3 text-primary text-xl hover:bg-primary hover:text-white rounded-xl bg-white">
                <i class="fa-solid fa-keyboard"></i> 
            </label>
            <label for="modalDiscount" class="modal-button cursor-pointer border border-yellow-400 py-3 px-4 text-xl hover:bg-yellow-500 hover:text-white rounded-xl bg-yellow-50 text-primary">
                <i class="fa-solid fa-percent"></i> 
            </label>
            <label for="" id="buttonPay" class="py-3 px-4 text-xl text-white w-full bg-gray-500 cursor-not-allowed rounded-xl flex justify-between">
                <span>Pay</span>
                <span id="grandTotal">Rp. 0</span>
            </label>
        </div>

        {{-- <label  class="btn ">open modal</label> --}}

        {{-- modal custom product  --}}
        <input type="checkbox" id="modalCustomProduct" class="modal-toggle" />
            <div class="modal">
            <div class="modal-box relative">
                <label for="modalCustomProduct" class="btn btn-sm bg-red-600 btn-circle absolute border-none text-white right-5 top-5">✕</label>
                <h3 class="text-lg font-bold">Custom Product</h3>
                <div class="py-3">
                    <div class="mb-3 relative">
                        <label for="" class="text-xs block mb-1">Product Name</label>
                        <input id="customProductName" type="text" class="w-full z-10 rounded border border-gray-400 py-2 px-3">
                        <small class="text-xs text-red-600" style="display: none">Product name cannot be blank</small>

                        <input type="hidden" id="customProductId" value="">
                        <div id="customProductSuggest" class="w-full -mt-1 border border-gray-100 bg-gray-50 absolute" style="display: none">
                            
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="" class="text-xs block mb-1">Product Price</label>
                        <input id="customProductPrice" type="text" class="w-full rounded border border-gray-400 py-2 px-3">
                        <small class="text-xs text-red-600" style="display:none">Product price cannot be blank</small>
                    </div>
                    <div class="mt-2">
                        <button id="addCartCustom" type="button" class="w-full bg-primary rounded py-2 text-center text-white">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal payment  --}}
        <input type="checkbox" id="modalPay" class="modal-toggle" />
            <div class="modal">
            <div class="modal-box relative">
                <label for="modalPay" class="btn btn-sm bg-red-600 btn-circle absolute border-none text-white right-5 top-5">✕</label>
                {{-- <span class="leading-none">Pay</span> --}}
                <h3 class="text-xl font-medium" class="leading-none" >Select Payment Method</h3>
                <form action="" method="POST" id="submitPayment">
                    @csrf
                    <div class="wrapper mt-4 custom-radio">
                        <label class="labl">
                            <input class="selectPayment" id="option-0" type="radio" name="paymentmethod" value="0" checked />
                            <div>
                                <div class="flex justify-start items-center label px-4 py-3">
                                    <span class="w-4 h-4 inline-block mr-2 rounded-full border border-grey flex-no-shrink "></span>
                                    <p class="font-semibold text-xs md:text-base">Cash</p>
                                </div>
                            </div>
                        </label>

                        <div class="mb-4" style="margin-top: -5px" id="cashAmount">
                            <label for="" class="text-xs text-gray-600">Cash Amount</label>
                            <input type="text" name="cashAmount" class="w-full rounded border border-gray-400" id="cashTotal">
                        </div>
                        @foreach (App\Models\PaymentMethod::get()->take(6) as $item)
                        <label class="labl">
                            <input class="selectPayment" id="option-{{ $item->id }}" type="radio" name="paymentmethod" value="{{$item->id}}" />
                            <div>
                                <div class="flex justify-start items-center label px-4 py-3">
                                    <span class="w-4 h-4 inline-block mr-2 rounded-full border border-grey flex-no-shrink "></span>
                                    <p class="font-semibold text-xs md:text-base">{{ $item->name }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach

                        
                    </div>
    
                    <button type="submit" class="mt-5 w-full bg-primary hover:bg-secondary py-3 px-5 text-white flex font-semibold justify-between items-center rounded-xl">
                        <span class="text-xl">Pay</span>
                        <span class="text-xl" id="totalPayment"></span>
                    </button>
                </form>
            </div>
        </div>

        

    </div>
    
</div>
@endsection

@push('js')
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        window.onload = getOnLoad()

        $(document).ready(function() {

            $("#customProductName").on('input', function() {
                let vals = $(this).val()
                if(vals.length < 1) {
                    $("#customProductSuggest").hide()
                }
                getCustomProduct(vals)
            });

            $("#searchProduct").on('input', function() {
                getProduct()
            });

            $("#addCartCustom").on('click', function () {
                createCartCustom()
            });

            $(".selectPayment").on('click', function () {
                if($(this).val() != 0) {
                    $("#cashAmount").hide()
                } else {
                    $("#cashAmount").show()
                }
            });

            $("#cashTotal").on('input', function () {
                numberMask()
            })

            $("#submitPayment").on('submit', function () {
                let maskedValue = numberMask()
                let cashAmount = maskedValue.unmaskedValue;
                $("#cashTotal").val(cashAmount)
            });
		});

        function numberMask() {
            var cashTotalMask = IMask(
                document.getElementById('cashTotal'),{
                    mask: Number,
                    thousandsSeparator: ','
                }
            );

            return cashTotalMask
        }

        function getOnLoad() {
            getProduct()
            getCart()
        }

        function number_format(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getCart() {
            $("#noCart").hide()
            $.ajax({
                url: `{{ route('ajax.cart.get') }}`,
                type: "GET",
                success: function(res) {
                    let cartsDOM = $("#listCart")
                    cartsDOM.empty()
                    if(res.data.carts.length > 0) {
                        
                        for(let i = 0; i < res.data.carts.length; i++) {
                            cartsDOM.append(cartDOM(res.data.carts[i]))
                        }
                    } else {
                        $("#noCart").show()
                    }


                    $("#grandTotal").html(res.data.grandTotal.text);
                    $("#totalPayment").html(res.data.grandTotal.text);
                    $("#totalTax").html(res.data.totalTax.text);
                    $("#subTotal").html(res.data.subTotal.text);
                    $("#cashTotal").val(res.data.grandTotal.num)
                    numberMask()

                    if(res.data.grandTotal.num > 0) {
                        $("#buttonPay").attr('for','modalPay');
                        $("#buttonPay").removeClass('bg-gray-500 cursor-not-allowed')
                        $("#buttonPay").addClass('bg-primary hover:bg-secondary cursor-pointer')
                    } else {
                        $("#buttonPay").attr('for','');
                        $("#buttonPay").removeClass('bg-primary hover:bg-secondary cursor-pointer')
                        $("#buttonPay").addClass('bg-gray-500 cursor-not-allowed')
                    }
                }
            });
        }

        function getProduct() {
            
            let data = {q: $("#searchProduct").val()}

            $.ajax({
                url: `{{ route('ajax.product.get') }}`,
                type: "GET",
                data: data,
                success: function (res) {
                    let productsDOM = $("#products")
                    productsDOM.empty()
                    for(let i = 0; i < res.data.length; i++) {
                        productsDOM.append(productDOM(res.data[i]))
                    }
                }
            })
        }

        function getCustomProduct(q) {
            let data = {q: q}
            
            $.ajax({
                url: `{{ route('ajax.product.custom') }}`,
                type: "GET",
                data: data,
                success: function (res) {
                    let vals = $("#customProductName").val()
                    if(vals.length < 1) {
                        $("#customProductSuggest").hide()
                    } else {
                        $("#customProductSuggest").show()
                    }
                    $("#customProductSuggest").empty()
                    if(res.data.length > 0) {
                        for(let i = 0; i < res.data.length; i++) {
                            $("#customProductSuggest").append(customProductDOM(res.data[i].name, res.data[i].id, res.data[i].price))
                        }
                    } else {
                        $("#customProductSuggest").append(addCustomProductDOM(vals))
                    }
                }
            });
        }

        function addCustomProductDOM(name) {
            return `
            <div onClick="addNewCustomProduct('`+name+`')" class="w-full flex justify-between items-center p-2 hover:text-blue-600 hover:cursor-pointer">
                <span>`+name+`</span>
                <span class="text-sm bg-green-100 py-1 px-3 rounded-full">add new</span>
            </div>
            `;
        }

        function customProductDOM(name, id, price) {
            return `
                <ul class="p-2 border-b border-gray-100">
                    <li onClick="setCustomProduct('`+name+`','`+id+`','`+price+`')" class="text-md hover:text-blue-600 hover:cursor-pointer">`+name+`</li>
                </ul>
            `;
        }

        function setCustomProduct(name, id, price) {
            $("#customProductSuggest").empty()
            $("#customProductSuggest").hide()
            $("#customProductId").val(id)
            $("#customProductName").val(name)
            $("#customProductPrice").val(price)
        }

        function addNewCustomProduct(name) {

            let data = {
                _token: "{{ csrf_token() }}",
                name: name
            }
            $.ajax({
                url: `{{ route('ajax.product.custom.create') }}`,
                data: data,
                type: "POST",
                success: function(res) {
                    setCustomProduct(res.data.name, res.data.id)
                }
            })
        }

        async function addProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            let amount = parseInt(inputVal)+1;

            await createCart(amount, productId);
            $(el).parent().find('.product-amount').val(amount);
        }

        async function minusProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            let amount = parseInt(inputVal)-1;

            if(amount < 0) {
                return false;
            }
            await createCart(amount, productId);
            $(el).parent().find('.product-amount').val(amount);
        }

        async function changeAmount(el, productId, type) {
            let amount = $(el).parent().find('.product-amount').val();

            if(type === 'custom') {
                await changeAmountCustom(amount, productId);
            } else {
                await createCart(amount, productId);
            }
            
            $(el).parent().find('.product-amount').val(amount);
        }

        async function deleteItemCart(productId, type) {
            if(type === 'custom') {
                await changeAmountCustom(0, productId);
            } else {
                await createCart(0, productId);
            }
        }

        function createCart(amount, productId) {
            let data = {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                amount: amount
            }

            $.ajax({
                url: `{{ route('ajax.cart.create') }}`,
                type: "POST",
                data: data,
                error: function(res) {
                    alert(res.responseJSON.message);
                }
            })

            getProduct()
            getCart()
        }

        function createCartCustom() {
            
            let data = {
                _token: "{{ csrf_token() }}",
                product_id: $("#customProductId").val(),
                price: $("#customProductPrice").val()
            }

            $.ajax({
                url: `{{ route('ajax.cart.create.custom') }}`,
                type: "POST",
                data: data,
                error: function(res) {
                    alert(res.responseJSON.message);
                }
            })
            $("#modalCustomProduct").prop('checked',false)
            $("#customProductId").val('');
            $("#customProductName").val('');
            $("#customProductPrice").val('');
            getProduct()
            getCart()
        }

        function changeAmountCustom(amount, productId)
        {
            let data = {
                _token: "{{ csrf_token() }}",
                amount: amount,
                product_id: productId
            }

            $.ajax({
                url: `{{ route('ajax.cart.create.custom') }}`,
                type: "POST",
                data: data,
                error: function(res) {
                    alert(res.responseJSON.message);
                }
            })

            getProduct()
            getCart()
        }

        function clearCart() {
            $.ajax({
                url: `{{ route('ajax.cart.delete') }}`,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    getProduct()
                    getCart()
                }
            });
        }
    </script>
@endpush