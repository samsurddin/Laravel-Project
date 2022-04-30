<x-guest-layout>

    {{-- @php
        dd($plans)
    @endphp --}}

    <section class="pt-20 pb-24 2xl:py-40 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="mb-16 md:mb-24 text-center">
                <h2 class="mb-8 md:mb-14 text-5xl lg:text-6xl 2xl:text-7xl text-white font-bold font-heading">Choose a plan</h2>
                <p class="text-lg text-gray-200">The quick brown fox jumps over the lazy dog.</p>
            </div>
            <div class="max-w-6xl mx-auto" x-data={bill_type:'monthly'}>
                <div class="mb-4 space-y-4">
                    <div class="flex items-center justify-center">
                        <input x-model="bill_type" id="bill_monthly" value="monthly" name="bill_type" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" checked>
                        <label for="bill_monthly" class="ml-3 block text-sm font-medium text-white mr-5"> Billed Monthly <span class="font-bold">(Upto {{ $max_discount }}% OFF)</span></label>
                        <input id="bill_annually" value="annually" name="bill_type" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" x-model="bill_type">
                        <label for="bill_annually" class="ml-3 block text-sm font-medium text-white mr-5"> Bill Annually <span class="font-bold">(Upto {{ $max_discount_yearly }}% OFF)</span></label>
                    </div>
                </div>
                <div class="flex flex-wrap items-center -mx-3">
                    @php
                    $mb = 0;
                    @endphp
                    @foreach ($plans as $plan)
                    @php
                        $mb++;
                        $bg_class = "bg-gray-500";
                        $hover_btn_text = "hover:text-gray-500";
                        if ($mb % 2 == 0) {
                            $bg_class = "bg-blue-500";
                            $hover_btn_text = "hover:text-blue-500";
                        }
                        $mb_class = "mb-8 lg:mb-0";
                        if ($mb % 3 == 0) {
                            $mb_class = "";
                            $mb = 0;
                        }
                    @endphp
                    <div class="w-full lg:w-1/3 px-3 {{ $mb_class }}">
                        <div class="px-12 py-16 {{ $bg_class }} rounded-3xl">
                            <div class="pb-8 mb-14 border-b border-gray-400">
                                <div class="text-center px-3">
                                    <h3 class="text-4xl text-white font-bold font-heading">{{ $plan->name }}</h3>
                                    <p class="text-lg text-white font-bold">
                                        @if (!empty($plan->price_yearly))
                                        {{-- <del> --}}
                                            <span class="currency opacity-50">tk</span>
                                            <template x-if="bill_type=='monthly'">
                                                <span class="money">{{$plan->price}}
                                                    @if ($plan->discount > 0)
                                                        - {{ $plan->discount }}% OFF
                                                    @endif
                                                </span> 
                                            </template>
                                            <template x-if="bill_type=='annually'">
                                                <span class="money">{{$plan->price_yearly}}  
                                                    @if ($plan->discount_yearly > 0)
                                                        - {{ $plan->discount_yearly }}% OFF
                                                    @endif
                                                </span>
                                            </template>
                                        {{-- </del><br> --}}
                                        <div class="price mt-4 text-lg text-white font-bold">
                                            <span class="currency opacity-50">tk</span>
                                            <template x-if="bill_type=='monthly'">
                                                <span class="money text-5xl lg:text-6xl 2xl:text-7xl">{{ round($plan->price-($plan->price/100*$plan->discount)) }}</span>
                                            </template>
                                            <template x-if="bill_type=='annually'">
                                                <span class="money text-5xl lg:text-6xl 2xl:text-7xl">{{ round($plan->price_yearly-($plan->price_yearly/100*$plan->discount_yearly)) }}</span>
                                            </template>
                                            <br>
                                            <span>per month</span>
                                        </div>
                                        @else
                                        <div class="price mt-4 text-lg text-white font-bold">
                                            <span class="currency opacity-50">tk</span>
                                            <span class="money">{{$plan->price}}</span>
                                            <br>
                                            <span>per month</span>
                                        </div>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <ul class="text-lg text-white mb-16">
                                <li class="flex items-center mb-8">
                                    <span class="mr-6">
                                        <svg width="20" height="16" viewbox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.81671 15.0418L0 8.2251L0.90027 7.32483L6.81671 13.2413L19.0997 0.958252L20 1.85852L6.81671 15.0418Z" fill="white"></path>
                                        </svg>
                                    </span>
                                    <span>Complete files</span>
                                </li>
                                <li class="flex items-center mb-8">
                                    <span class="mr-6">
                                        <svg width="20" height="16" viewbox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.81671 15.0418L0 8.2251L0.90027 7.32483L6.81671 13.2413L19.0997 0.958252L20 1.85852L6.81671 15.0418Z" fill="white"></path>
                                        </svg>
                                    </span>
                                    <span>10GB cloud storage</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="mr-6">
                                        <svg width="20" height="16" viewbox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.81671 15.0418L0 8.2251L0.90027 7.32483L6.81671 13.2413L19.0997 0.958252L20 1.85852L6.81671 15.0418Z" fill="white"></path>
                                        </svg>
                                    </span>
                                    <span>5 team members</span>
                                </li>
                            </ul>
                            <div class="text-center"">
                                <a class="cursor-pointer shadow-sm uppercase inline-block px-10 py-4 border border-gray-200 hover:border-gray-100 rounded-full font-bold text-white hover:bg-white {{ $hover_btn_text }}" x-bind:href="'{{ route('signup', [app()->getLocale(), $plan->id]) }}/?bill_type='+bill_type">Try now</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
