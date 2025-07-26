@extends('layouts.app')

@section('content')
    <div id="Success" class="relative flex flex-col ">
        <div class="w-full flex flex-col rounded-[8px] border border-[#F1F2F6] p-5 gap-6 bg-white mt-6">
            <div class="flex flex-col items-center gap-2">
                <img src="{{ asset('assets/images/icons/Success.svg') }}" alt="success" class="w-24 h-24">
                <p class="text-[26px] font-[500] text-center">Successful Transaction
                    Show this to the cashier</p>
            </div>

            <div class="flex flex-col gap-2">
                <p class="font-semibold">Order Details</p>
             
                @foreach($transaction->transactionDetails as $detail)
                    <div class="flex flex-col gap-4 mt-[10px]">
                        <div
                            class="flex items-center rounded-[8px] border border-[#F1F2F6] p-[12px] gap-4 bg-white hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300">
                            <div class="w-[128px] h-[88px]">
                                <img src="{{ asset('Storage/' . $detail->product->image) }}" class="w-full object-cover rounded-[8px]"
                                    alt="icon">
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-[#F3AF00] font-[400] text-[12px]">
                                    {{ $detail->product->productCategory->name }}
                                </p>
                                <h3 class="text-[#353535] font-[500] text-[14px]">
                                    {{ $detail->product->name }}
                                </h3>

                                <div class="flex items-center justify-between ">
                                    <p class="text-[#FF001A] font-[600] text-[14px]">
                                        Rp {{ number_format($detail->product->price) }}
                                    </p>
                                </div>
                            </div>
                            <span id="qty">x{{ $detail->quantity }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col gap-2">
                <p class="font-semibold">Your Code Order</p>
                <label
                    class="flex items-center w-full rounded-[8px] p-[14px_20px] gap-3 bg-white ring-1 ring-[#F3AF003D] ring-opacity-5 focus-within:ring-[#F3AF00] focus-within:ring-opacity-100 transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/Document.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="text" name="code" id=""
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-light"
                        value="{{ $transaction->code }}" readonly>
                </label>
            </div>
        </div>
    </div>

    <a href="{{ route('index', $store->username) }}"
        class="flex justify-center rounded-full p-[14px_28px] bg-[#FF801A] font-normal text-white mt-6">
        See More Menu
    </a>
@endsection