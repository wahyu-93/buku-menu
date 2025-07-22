<div class="fixed inset-x-0 bottom-0 max-w-[640px] z-50 bg-white shadow-sm mx-auto">
    <div class="flex items-center justify-between px-8 py-4">
        <a href="{{ route('index', $store->username) }}" class="flex flex-col items-center gap-2">
            @if(Route::current()->getName() == 'index')
                <img src="{{ asset('assets/images/icons/Home.svg') }}" class="w-[24px] h-[24px]" alt="icon">
            @else
                <img src="{{ asset('assets/images/icons/Home_Default.svg') }}" class="w-[24px] h-[24px]" alt="icon">
            @endif

            <p class="{{ Route::current()->getName() == 'index' ? 'text-[#FF801A]' : 'text-[#606060]'}}   font-[400] text-[12px]">Home</p>
        </a>

        <a href="{{ route('cart', $store->username) }}" class="flex flex-col items-center gap-2">
            <div class="relative">
                <img src="{{ asset('assets/images/icons/Buy.svg') }}" class="w-[24px] h-[24px]" alt="icon">
                <div
                    class="absolute top-[-4px] right-[-8px] flex items-center justify-center w-[16px] h-[16px] rounded-full bg-[#FF801A]">
                    <p class="text-white font-[400] text-[10px]" id="cart-count"></p>
                </div>
            </div>
            <p class="text-[#606060] font-[400] text-[12px]">Cart</p>
        </a>
        
        <a href="{{ route('product.find', $store->username) }}" class="flex flex-col items-center gap-2 ">
            @if(Route::current()->getName() == 'product.find')
                <img src="{{ asset('assets/images/icons/Search.svg') }}" class="w-[24px] h-[24px]" alt="icon">
            @else
                <img src="{{ asset('assets/images/icons/Search_default.svg') }}" class="w-[24px] h-[24px]" alt="icon">
            @endif

            <p class="{{ Route::current()->getName == 'product.find' ? 'text-[#FF801A]' : 'text-[#606060]' }} font-[400] text-[12px]">Find</p>
        </a>
        
        <a href="{{ route('index', $store->username) }}" class="flex flex-col items-center gap-2">
            <img src="{{ asset('assets/images/icons/Profile.svg') }}" class="w-[24px] h-[24px]" alt="icon">
            <p class="text-[#606060] font-[400] text-[12px]">Profile</p>
        </a>
    </div>
</div>