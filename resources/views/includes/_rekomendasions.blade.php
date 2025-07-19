<div id="Recomendations" class="relative flex flex-col px-5 mt-[20px]">
    <div class="flex items-end justify-between ">
        <h1 class="text-[#353535] font-[500] text-lg">Chef's Recommendations</h1>
        <a href="#" class="text-[#FF801A] text-sm ">See All</a>
    </div>
    <div class="flex flex-col gap-4 mt-[10px]">
        @foreach ($products as $product)
            <a href="{{ route('product.show',['username' => $store->username, 'id' => $product->id]) }}" class="card">
                <div
                    class="flex rounded-[8px] border border-[#F1F2F6] p-[12px] gap-4 bg-white hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300">
                    <img src="{{ asset('Storage/' . $product->image) }}" class="w-[128px] object-cover rounded-[8px]"
                        alt="icon">
                    <div class="flex flex-col gap-1 w-full">
                        <p class="text-[#F3AF00] font-[400] text-[12px]">
                            {{ $product->productCategory->name }}
                        </p>
                        <h3 class="text-[#353535] font-[500] text-[14px]">
                            {{ $product->name }}
                        </h3>
                        <p class="text-[#606060] font-[400] text-[10px]">
                            {{ $product->descripion}}
                        </p>

                        <div class="flex items-center justify-between ">
                            <p class="text-[#FF001A] font-[600] text-[14px]">
                                Rp {{ number_format($product->price)}}
                            </p>
                            <button type="button"
                                class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                data-id="{{ $product->id }}" onclick="addToCart(this.dataset.id)">
                                <img src="assets/images/icons/ic_plus.svg" class="w-full h-full" alt="icon">
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>