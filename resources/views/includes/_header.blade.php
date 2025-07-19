<div id="Background"
    class="absolute top-0 w-full h-[170px] rounded-b-[10px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]">
</div>

<div id="TopNav" class="relative flex flex-col px-5 mt-[20px] h-[170px]">
    <div class="relative flex items-center justify-between">
        <div class="flex flex-col gap-1">
            <p class="text-white text-sm">Welcome To,</p>
            <h1 class="text-white font-semibold">{{ $store->name }}</h1>
        </div>
        <a href="#"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white bg-opacity-20">
            <img src="{{ asset('assets/images/icons/ic_bell.svg') }}" class="w-[28px] h-[28px]" alt="icon">
        </a>
    </div>

    <h1 class="text-white font-[600] text-2xl leading-[30px] mt-[20px]">Order Delicious Meal!</h1>

    <div class="absolute bottom-0 left-0 right-0 w-full gap-2 px-5">
        <label
            class="flex items-center w-full rounded-full p-[8px_8px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#F3AF00] transition-all duration-300">
            <img src="{{ asset('assets/images/icons/ic_search.svg') }}" class="w-8 h-8 flex shrink-0" alt="icon">
            <input type="text" name="search" id=""
                class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-light"
                placeholder="Search menu, or etc...">
        </label>
    </div>
</div>