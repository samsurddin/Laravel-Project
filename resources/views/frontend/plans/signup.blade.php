<x-guest-layout>
    <x-front-form-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('signup_post', app()->getLocale()) }}" class="grid gap-6 grid-cols-6">
            @csrf

            <!-- Name -->
            <div class="mt-3 col-span-3">
                <x-label for="plan" :value="__('Plan')" />

                {{-- <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus /> --}}
                <select class="input" name="plan" id="plan">
                    @foreach ($plans as $pitem)
                        <option 
                            value="{{$pitem['id']}}" 
                            data-price="{{$pitem['price']}}" 
                            data-discount="{{$pitem['discount']}}" 
                            data-price_yearly="{{$pitem['price_yearly']}}" 
                            data-discount_yearly="{{$pitem['discount_yearly']}}" 
                            @if ((null !== old('plan') && $pitem['id'] == old('plan')) || $pitem['id'] == $plan->id) selected @endif>
                                {{$pitem['name']}} - {{$pitem['price']}}tk/m
                                @if ($pitem['discount']>0)
                                    ({{$pitem['discount']}}% OFF)
                                @endif
                                , {{$pitem['price_yearly']}}tk/y
                                @if ($pitem['discount_yearly']>0)
                                    ({{$pitem['discount_yearly']}}% OFF)
                                @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Email Address -->
            <div class="mt-3 col-span-3">
                <x-label for="bill_type" :value="__('Billing Type')" />

                <select class="input" name="bill_type" id="bill_type">
                    <option value="monthly" @if ((null !== old('bill_type') && old('bill_type') == 'monthly') || $bill_type == 'monthly') selected @endif>Monthly</option>
                    <option value="annually" @if ((null !== old('bill_type') && old('bill_type') == 'annually') || $bill_type == 'annually') selected @endif>Annually</option>
                </select>
            </div>

            <div class="col-span-6">
                <div class="alert alert-info pay-amount text-center font-bold">
                    You need to pay: 588tk (monthly)
                </div>
            </div>

            <!-- Name -->
            <div class="mt-3 col-span-3">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-3 col-span-3">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-3 col-span-3">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-3 col-span-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            

            <!-- Name -->
            <div class="mt-3 col-span-3">
                <x-label for="tenant_name" :value="__('Website Name')" />

                <x-input id="tenant_name" class="block mt-1 w-full" type="text" name="tenant_name" :value="old('tenant_name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-3 col-span-3">
                <x-label for="domain" :value="__('Domain')" />

                {{-- <x-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" required /> --}}

                {{-- <label for="company-website" class="block text-sm font-medium text-gray-700"> Website </label> --}}
                <div class="mt-1 flex rounded-md shadow-sm">
                  {{-- <input type="text" name="domain" id="domain" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 rounded-none rounded-l-md border border-r-0 sm:text-sm border-gray-300" placeholder="www.example.com"> --}}
                  <x-input id="domain" class="flex-1 rounded-none rounded-l-md border border-r-0" type="text" name="domain" :value="old('domain')" required />
                  <span class="inline-flex items-center w-full px-3 rounded-r-md border border-gray-300 bg-gray-50 text-gray-500 text-sm"> .{{ request()->getHost() }} </span>
                </div>
            </div>

            <div class="flex items-center justify-end mt-3 col-span-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login', app()->getLocale()) }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-front-form-card>
    <script>
        let price = {{$plan->price}},
            discount = {{$plan->discount}},
            price_yearly = {{$plan->price_yearly}},
            discount_yearly = {{$plan->discount_yearly}},
            bill_type = '{{$bill_type}}'

        function calculate(currency = 'tk') {
            let text = "You need to pay: ";
            let result = 0;
            if (bill_type == 'monthly') {
                console.log(price - (price/100*discount))
                result = (price - (price/100*discount));
            }
            
            if (bill_type == 'annually') {
                console.log(price_yearly - (price_yearly/100*discount_yearly))
                result = (price_yearly - (price_yearly/100*discount_yearly));
            }
            result = result.toFixed() + currency + ' (' + bill_type + ')';
            
            document.querySelector('.pay-amount').textContent = text + result
        }
        calculate();

        document.querySelector('select#plan').onchange = function(event){
            price = event.target.options[event.target.selectedIndex].dataset.price
            discount = event.target.options[event.target.selectedIndex].dataset.discount
            price_yearly = event.target.options[event.target.selectedIndex].dataset.price_yearly
            discount_yearly = event.target.options[event.target.selectedIndex].dataset.discount_yearly

            calculate();
        };

        document.querySelector('select#bill_type').onchange = function(event){
            bill_type = event.target.value

            calculate();
        };
    </script>
</x-guest-layout>