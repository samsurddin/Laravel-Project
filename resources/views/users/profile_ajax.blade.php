
<dl>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Full name</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->name }}</span>
            <input type="text" class="input edit !hidden" name="name" value="{{ $user->name }}">
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Email address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->email }}</span>
            <input type="text" class="input edit !hidden" name="email" value="{{ $user->email }}">
        </dd>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Billing Address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->billing_address }}</span>
            <textarea class="input edit !hidden" name="billing_address" cols="30" rows="3">{{ $user->billing_address }}</textarea>
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-value-row">
        <dt class="text-sm font-medium text-gray-500">Billing Post Office</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user_postcode->postOffice }}</span>
        </dd>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-value-row">
        <dt class="text-sm font-medium text-gray-500">Billing Upazila</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user_postcode->upazila }}</span>
            {{-- <input type="text" class="input edit !hidden" name="billing_state" value="{{ $user->billing_state }}"> --}}
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-value-row">
        <dt class="text-sm font-medium text-gray-500">Billing District</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user_postcode->district->name }}</span>
        </dd>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-value-row">
        <dt class="text-sm font-medium text-gray-500">Billing Division</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user_postcode->division->name }}</span>
            {{-- <input type="text" class="input edit !hidden" name="billing_state" value="{{ $user->billing_state }}"> --}}
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-value-row">
        <dt class="text-sm font-medium text-gray-500">Billing Zipcode</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->billing_zipcode }}</span>
            {{-- <input type="text" class="input edit !hidden" name="billing_zipcode" value="{{ $user->billing_zipcode }}"> --}}
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 only-edit-row !hidden">
        <dt class="text-sm font-medium text-gray-500">Billing City/State/Zipcode</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{-- <span class="value">{{ $user_postcode->postOffice }}, {{ $user_postcode->upazila }}, {{ $user_postcode->district->name }}, {{ $user_postcode->division->name }} ({{ $user->billing_zipcode }})</span> --}}
            <select name="billing_zipcode" class="select2" data-placeholder="Type a postcode or area name">
                <option></option>
                @foreach ($postcodes as $postcode)
                    <option @if (old('billing_zipcode', $user->billing_zipcode) == $postcode->postCode) selected @endif title="{{ $postcode->postOffice }}" value="{{ $postcode->postCode }}">
                        {{ $postcode->postCode }}, 
                        {{ $postcode->postOffice }}, {{ $postcode->upazila }}, {{ $postcode->district->name }}, {{ $postcode->division->name }}
                    </option>
                @endforeach
            </select>
        </dd>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Billing Mobile</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->billing_mobile }}</span>
            <input type="text" class="input edit !hidden" name="billing_mobile" value="{{ $user->billing_mobile }}">
        </dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Billing Alt. Mobile</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <span class="value">{{ $user->billing_alt_mobile }}</span>
            <input type="text" class="input edit !hidden" name="billing_alt_mobile" value="{{ $user->billing_alt_mobile }}">
        </dd>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">About</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>
    </div>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">Attachments</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                    <div class="w-0 flex-1 flex items-center">
                        <!-- Heroicon name: solid/paper-clip -->
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 flex-1 w-0 truncate"> resume_back_end_developer.pdf </span>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> Download </a>
                    </div>
                </li>
                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                    <div class="w-0 flex-1 flex items-center">
                        <!-- Heroicon name: solid/paper-clip -->
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 flex-1 w-0 truncate"> coverletter_back_end_developer.pdf </span>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> Download </a>
                    </div>
                </li>
            </ul>
        </dd>
    </div>
</dl>