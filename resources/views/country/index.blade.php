<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Country') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a> --}}
            {{-- <a class="btn" href="{{ route('country.create') }}"> Create New User</a> --}}
            {{-- <a class="btn-sm" href="{{ route('plans.index', app()->getLocale()) }}"> All Plsans</a> --}}
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    

                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="flex flex-col">
                        <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="" style="width: 22%; padding: 0 14px">
                          
                        <label for="underline_select" class="sr-only">Underline select</label>
                        <select id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option selected>Choose a country</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>

                        </div>
                           

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>