<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Country') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New User</a> --}}
            {{-- <a class="btn-sm" href="{{ route('plans.index', app()->getLocale()) }}"> All Plsans</a> --}}
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="/" method="post">
                        @csrf
                        <div class="mb-6" style="width: 50%">
                            <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                            <input type="text" id="country" name="country_fil" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <input class="bg-red-500 w-24 h-10 text-white rounded-lg" type="submit" />
                    </form>

                    <!-- This example requires Tailwind CSS v2.0+ -->
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>