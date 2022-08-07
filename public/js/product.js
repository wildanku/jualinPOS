function productDOM(data) {
    return `
        <div class="product bg-white p-2 shadow-md rounded-lg flex gap-2">
            <img src="`+data.image+`" class="w-16 h-20 rounded object-cover" alt="">
            <div class="caption relative w-full">
                <div>
                    <div class="tooltip tooltip-bottom text-left z-10" data-tip="`+data.name+`">
                        <span class="name leading-tight">`+data.name+`</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <small class="price text-sm">`+data.sell_price.text+`</small>
                        <small class="text-xs bg-yellow-100  px-2 rounded">`+data.stock.text+`</small>
                    </div>
                </div>
                <div class="absolute bottom-0 w-full">
                    <div class="flex justify-between items-center">
                        <small class="text-xs">SKU: `+data.sku+`</small>
                        <div class="number flex z-0">
                            <span onclick="minusProduct(this,`+data.id+`)" class="minus block w-6 h-6 text-center cursor-pointer bg-primary text-white">-</span>
                            <input onchange="changeAmount(this,`+data.id+`)" type="text" id="value`+data.id+`" class="w-10 h-6 text-center border border-primary px-1 text-sm product-amount" value="`+data.in_cart+`"/>
                            <span onclick="addProduct(this,`+data.id+`)" class="plus block w-6 h-6 text-center cursor-pointer bg-primary text-white">+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
