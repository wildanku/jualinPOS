function productDOM(data) {
    return `
        <div class="product bg-white p-2 shadow-md rounded-lg flex gap-2">
            <img src="`+data.data.image+`" class="w-12 h-20 object-cover" alt="">
            <div class="caption relative w-full">
                <div>
                    <div class="tooltip tooltip-bottom text-left" data-tip="Product Name with medium long name">
                        <span class="name leading-tight">Product Name with medium long name</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <small class="price text-sm">Rp. 92,320,900</small>
                        <small class="text-xs bg-yellow-100  px-2 rounded">not tracked</small>
                    </div>
                </div>
                <div class="absolute bottom-0 w-full">
                    <div class="flex justify-between items-center">
                        <small class="text-xs">SKU: 3124719</small>
                        <div class="number flex gap-1">
                            <span class="minus block w-6 h-6 text-center rounded bg-gray-200">-</span>
                            <input type="text" class="w-12 h-6 text-center rounded border border-gray-400 px-1 text-md " value="0"/>
                            <span class="plus block w-6 h-6 text-center rounded bg-gray-200">+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}