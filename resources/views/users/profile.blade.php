<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Account') }}
            </h2>
        </div>
        <div class="flex-item">
            <a class="btn-primary edit-btn" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Profile
            </a>
            <a class="btn-secondary cancel-btn !hidden" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel Edit
            </a>
            {{-- <a class="btn-primary" href="{{ route('users.edit', [app()->getLocale(), $user->id]) }}"> Edit Profile</a> --}}
            {{-- <a class="btn-secondary" href="{{ route('users.index', app()->getLocale()) }}"> All Users</a> --}}
        </div>
    </x-slot>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-1">
                <ul class="flex flex-col py-4">
                    <li>
                        <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </span>
                            <span class="text-sm font-medium">My Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Change Password</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-medium">Notifications</span>
                            <span class="px-2 py-1 text-xs font-medium leading-tight text-white bg-green-400 rounded-full ml-6">5</span>
                        </a>
                    </li>--}}
                </ul>
            </div>
            <div class="col-span-5">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form class="profile-edit-form" action="{{ route('profile_update', [app()->getLocale(), $user->id]) }}" method="post">
                        @csrf
                        @method('PATCH')
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">My Profile</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and billing information.</p>
                        </div>
                        <div class="border-t border-gray-200 profile-data">
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
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 submit-btn-row hidden">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="head">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" /> --}}
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" defer></script>
        <script>
            window.addEventListener('DOMContentLoaded', (event) => {
                $(".select2").select2({
                    // theme: "bootstrap-5",
                    placeholder: 'Type to find quickly',
                    allowClear: true,
                });

                $('.select2').on('select2:select', function (e) {
                    var data = e.params.data;
                    console.log(data);
                });

                // $('.profile-edit-form').find('input, textarea, select, button').addClass('hidden');
                $('.edit-btn').on('click', function () {
                    $(this).addClass('!hidden');
                    $('.only-value-row').addClass('!hidden');
                    $('.only-edit-row').removeClass('!hidden');
                    $('.cancel-btn').removeClass('!hidden');
                    $('.submit-btn-row').removeClass('hidden');
                    $('.profile-edit-form').find('.value').addClass('hidden');
                    $('.profile-edit-form').find('input, textarea, select, button').removeClass('!hidden');
                    // $('.profile-edit-form').find('input, textarea, select, button').first().focus();
                    $('input:visible:first').focus()
                    return false;
                });
                $('.cancel-btn').on('click', function () {
                    $(this).addClass('!hidden');
                    $('.only-value-row').removeClass('!hidden');
                    $('.only-edit-row').addClass('!hidden');
                    $('.edit-btn').removeClass('!hidden');
                    $('.submit-btn-row').addClass('hidden');
                    $('.profile-edit-form').find('input, textarea, select, button').addClass('!hidden');
                    $('.profile-edit-form').find('.value').removeClass('hidden');
                    return false;
                });

                $('.profile-edit-form').submit(function (e) { 
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: 'html',
                        success: function (response) {
                            $('.profile-data').html(response);
                            $('.cancel-btn').addClass('!hidden');
                            $('.edit-btn').removeClass('!hidden');
                            $('.submit-btn-row').addClass('hidden');
                            console.log(response)
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>