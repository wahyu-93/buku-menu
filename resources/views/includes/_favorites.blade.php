<div id="Favorites" class="relative flex flex-col px-5 mt-[20px]">
    <div class="flex items-end justify-between">
        <h1 class="text-[#353535] font-[500] text-lg">Menu Favorite</h1>
        <a href="#" class="text-[#FF801A] text-sm ">See All</a>
    </div>

    <div class="swiper w-full">
        <div class="swiper-wrapper mt-[10px]">
            @foreach ($populers as $populer)
                <div class="swiper-slide !w-fit">
                    <a href="{{ route('product.show',['username' => $store->username, 'id' => $populer->id]) }}" class="card">
                        <div
                            class="flex flex-col w-[210px] shrink-0 rounded-[8px] bg-white p-[12px] pb-5 gap-[10px] hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300 cursor-pointer">
                            <div
                                class="position-relative flex w-full h-[150px] shrink-0 rounded-[8px] bg-[#D9D9D9] overflow-hidden">
                                <img src="{{ asset('Storage/' . $populer->image) }}" class="w-full h-full object-cover"
                                    alt="thumbnail">

                                <!-- rating -->
                                <div
                                    class="absolute top-5 right-5 flex items-center gap-1 bg-white px-[8px] py-[4px] rounded-full">
                                    <img src="{{ asset('assets/images/icons/ic_star.svg') }}" alt="rating" class="w-4 h-4">
                                    <p class="text-sm">{{ $populer->rating }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-[#F3AF00] font-[400] text-[12px]">
                                   {{ $populer->productCategory->name }}
                                </p>
                                <h3 class="text-[#353535] font-[500] text-[14px]">
                                    {{ $populer->name }}
                                </h3>
                                <p class="text-[#606060] font-[400] text-[10px]">
                                     {{ $populer->description }}
                                </p>

                            </div>

                            <div class="flex items-center justify-between ">
                                <p class="text-[#FF001A] font-[600] text-[14px]">
                                    Rp {{ number_format($populer->price)}}
                                </p>
                                <button type="button"
                                    class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                    data-id="1" onclick="addToCart(this.dataset.id)">
                                    <img src="{{ asset('assets/images/icons/ic_plus.svg') }}" class="w-full h-full" alt="icon">
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>