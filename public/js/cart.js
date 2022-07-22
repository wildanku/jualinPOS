function cartDOM(data) {
    return `
        <div class="item flex justify-between items-start border-b border-gray-50 py-2">
            <div class="flex gap-2">
                <input onchange="changeAmount(this,`+data.product.id+`)" type="text" id="value" class="w-10 h-8 text-center rounded border border-blue-300 px-1 text-md product-amount" value="`+data.amount+`"/>
                <div class="desc leading-none">
                    `+data.product.name+`<br>
                    <small class="text-xs">x `+data.product.price.text+`</small>
                </div>
            </div>
            <div class="">
                <div class="flex gap-3">
                    <span class="price">`+data.total.text+`</span>
                    <button onclick="deleteItemCart(`+data.product.id+`)" class="text-red-600"><i class="fa-solid fa-times"></i></button>
                </div>
            </div>
        </div>
    `;
}