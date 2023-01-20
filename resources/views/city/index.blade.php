<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create City') }}
            </h2>
        </div>
        <div class="flex-item">
            <a class="btn-sm" href="{{ route('admin.city.create', app()->getLocale()) }}">City</a>
        </div>
    </x-slot>
    <div class="py-12">

        @php
            // $json_url = "https://raw.githubusercontent.com/hiiamrohit/Countries-States-Cities-database/master/countries.json";

            
            
        @endphp 


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                
                <div class="flex w-96">
                    {{-- City area --}}

                    <label for="states" class="sr-only">Choose a City</label>
                    <select id="states" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a state</option>

                        <option value="CA">California</option>
                        
                        <option value="WH">Washinghton</option>
                        <option value="FL">Florida</option>
                        <option value="VG">Virginia</option>
                        <option value="GE">Georgia</option>
                        <option value="MI">Michigan</option>
                    </select>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>