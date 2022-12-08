<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Country') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a> --}}
            <a class="btn" href="{{ route('admin.country.create', app()->getLocale()) }}"> Create Country Name</a>
            {{-- <a class="btn" href="{{ route('country.edit', app()->getLocale()) }}"> edit Country Name</a> --}}
            {{-- <a href="{{ route('admin.country.edit') }}" class="bg-blue-600 text-white px-5 py-2 mr-1">edit</a> --}}
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
                        <div class="w-64 px-8" >
                          
                        <label for="underline_select" class="sr-only">Underline select</label>
                        <select id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option value="">Country</option>
                            @foreach ($coun as $item)
                               <option value="US">{{ $item->nicename }}</option>
                            @endforeach
                            
                            {{-- <option selected>Choose a country</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option> --}}
                        </select>

                        </div>
                           

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div>

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        IOS
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        NAME
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                       NICENAME
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        IOS3
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        NUMBER CODE
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        PHONE CODE
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($coun as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6">
                                        {{ $item->iso }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->nicename }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->iso3 }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->numcode }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->phonecode }}
                                    </td>
                                    <td class="py-4 px-6 flex">
                                        {{-- <a class="bg-red-600 text-white px-5 py-2 rounded-full font-semibold" href="{{ route('admin.country.show', [app()->getLocale(), $item->id]) }}">Show</a> --}}
                                        <a class="bg-purple-700 text-white mx-1 px-5 py-2 rounded-full font-semibold" href="{{ route('admin.country.edit', [app()->getLocale(), $item->id]) }}">Edit</a>
                                        <form  method="POST" action="{{ route('admin.country.destroy',[app()->getLocale(),$item->id]) }}">
                                            @csrf 
                                            @method('DELETE')
                                            <input class="bg-red-600 text-white px-5 py-2 rounded-full font-semibold" type="submit" value="Delete">
                                        </form>
                                        
                                    </td>
                                </tr>
                                @endforeach
                                
                                    
                                    
                                
                               
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>