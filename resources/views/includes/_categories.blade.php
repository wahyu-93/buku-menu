<div id="Categories" class="relative flex flex-col px-5 mt-[20px]">
    <div class="flex items-end justify-between ">
        <h1 class="text-[#353535] font-[500] text-lg">Explore Categories</h1>
        <a href="#" class="text-[#FF801A] text-sm ">See All</a>
    </div>

    <div class="swiper w-full">
        <div class="swiper-wrapper mt-[20px]">
            <a href="{{ route('product.find-result', $store->username) }}" class="swiper-slide !w-fit">
                <div class="flex flex-col items-center shrink-0 gap-2 text-center">
                    <div
                        class="w-[64px] h-[64px] rounded-full flex shrink-0 overflow-hidden p-4 bg-[#9393931A] bg-opacity-10">
                        <img src="{{ asset('assets/images/icons/all-menu.png') }}" class="w-full h-full object-contain"
                            alt="thumbnail">
                    </div>
                    <div class="flex flex-col gap-[2px]">
                        <h3 class="font-light text-[#504D53] text-[14px]">All Menu</h3>
                    </div>
                </div>
            </a>

            @foreach ($store->productCategories as $category)
                <a href="{{ route('product.find-result', $store->username) . '?category=' . $category->id}}" class="swiper-slide !w-fit">
                    <div class="flex flex-col items-center shrink-0 gap-2 text-center">
                        <div
                            class="w-[64px] h-[64px] rounded-full flex shrink-0 overflow-hidden p-4 bg-[#9393931A] bg-opacity-10">
                            <img src="{{ asset('Storage/' . $category->icon) }}" class="w-full h-full object-contain"
                                alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[2px]">
                            <h3 class="font-light text-[#504D53] text-[14px]">{{ $category->name }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>