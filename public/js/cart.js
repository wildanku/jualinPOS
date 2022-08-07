function cartDOM(data) {
    let inputChange = '';
    let deleteCart = '';
    if(data.product.type === 'custom') {
        inputChange = `
            <input onchange="changeAmount(this,`+data.product.id+`,'custom')" type="text" id="value" class="w-10 h-8 text-center rounded border border-blue-300 px-1 text-md product-amount" value="`+data.amount+`"/>
        `;
        deleteCart = `
            <button onclick="deleteItemCart(`+data.product.id+`,'custom')" class="text-red-600"><i class="fa-solid fa-times"></i></button>
        `;
    } else {
        inputChange = `
            <input onchange="changeAmount(this,`+data.product.id+`,'product')" type="text" id="value" class="w-10 h-8 text-center rounded border border-blue-300 px-1 text-md product-amount" value="`+data.amount+`"/>
        `;

        deleteCart = `
            <button onclick="deleteItemCart(`+data.product.id+`,'product')" class="text-red-600"><i class="fa-solid fa-times"></i></button>
        `;
    }

    return `
        <div class="item flex justify-between itefms-start border-b border-gray-50 py-2">
            <div class="flex gap-2" style="width: 60%">
                `+inputChange+`
                <div class="desc leading-none" style="line-height:1.2" >
                    <span class="cartProductName">`+data.product.name+`</span>
                    <small class="text-xs">x `+data.product.price.text+`</small>
                </div>
            </div>
            <div class="">
                <div class="flex gap-3">
                    <span class="price">`+data.total.text+`</span>
                    `+deleteCart+`
                </div>
            </div>
        </div>
    `;
}