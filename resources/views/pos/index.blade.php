@extends('layouts.pos')
@push('css')
    <style>
        .product .caption .name,
        .product .caption .price {
            text-overflow: ellipsis;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
        }
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
                    <button onclick="clearCart()" class="bg-red-600 hover:bg-red-700 rounded-full py-1 px-4 uppercase text-sm text-white"><i class="fa-solid fa-times mr-2"></i> clear</button> 
                </div>
    
                <div class="">
                    <div class="border-t border-gray-100 mt-5 pt-2" id="listCart"></div>
                    
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
                    
                    <div class="flex justify-center items-center w-full" style="height: 50vh" id="noCart">
                        <div class="">
                            <img style="width: 150px" src="{{ asset('images/no_cart.png') }}" alt="">
                            <div class="uppercase text-center mt-4 text-gray-600">No Cart</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 w-full flex items-center gap-2">
                <label for="my-modal-3" class="modal-button cursor-pointer border border-primary py-3 px-4 text-primary text-xl hover:bg-primary hover:text-white rounded-xl bg-white">
                    <i class="fa-solid fa-keyboard"></i> 
                </label>
                <button class="py-3 px-4 text-xl text-white w-full bg-primary rounded-xl flex justify-between">
                    <span>Pay</span>
                    <span id="grandTotal">Rp. 0</span>
                </button>
            </div>

            {{-- <label  class="btn ">open modal</label> --}}

            <!-- Put this part before </body> tag -->
            <input type="checkbox" id="my-modal-3" class="modal-toggle" />
                <div class="modal">
                <div class="modal-box relative">
                    <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                    <h3 class="text-lg font-bold">Congratulations random Internet user!</h3>
                    <p class="py-4">You've been selected for a chance to get one year of subscription to use Wikipedia for free!</p>
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
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 0 ? 0 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});

            $("#searchProduct").on('input', function() {
                getProduct()
            });
		});

        function getOnLoad() {
            getProduct()
            getCart()
        }

        function number_format(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getCart() {
            $.ajax({
                url: `{{ route('ajax.cart.get') }}`,
                type: "GET",
                success: function(res) {
                    let cartsDOM = $("#listCart")
                    cartsDOM.empty()
                    if(res.data.carts.length > 0) {
                        $("#noCart").hide()
                        for(let i = 0; i < res.data.carts.length; i++) {
                            cartsDOM.append(cartDOM(res.data.carts[i]))
                        }
                    } else {
                        $("#noCart").show()
                    }


                    $("#grandTotal").html(res.data.grandTotal.text);
                    $("#totalTax").html(res.data.totalTax.text);
                    $("#subTotal").html(res.data.subTotal.text);
                    
                }
            });
        }

        function getProduct() {
            
            let data = {q: $("#searchProduct").val()}

            $.ajax({
                url: `{{ route('ajax.products') }}`,
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

        function addProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            let amount = parseInt(inputVal)+1;

            createCart(amount, productId);
            $(el).parent().find('.product-amount').val(amount);
        }

        function minusProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            let amount = parseInt(inputVal)-1;

            if(amount < 0) {
                return false;
            }
            createCart(amount, productId);
            $(el).parent().find('.product-amount').val(amount);
        }

        function changeAmount(el, productId) {
            let amount = $(el).parent().find('.product-amount').val();
            createCart(amount, productId);
            $(el).parent().find('.product-amount').val(amount);
        }

        function deleteItemCart(productId) {
            createCart(0, productId);
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
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Product failed to add');
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