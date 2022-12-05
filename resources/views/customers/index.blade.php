<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{__('Customers Management')}}
            </h2>
        </div>
        <div class="flex">
            <a class="btn" href="{{ route('admin.customers.create', app()->getLocale())  }}">Create Customer</a>
        </div>
    </x-slot>

    <div class="py-12 ">
    <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-[80%] mx-auto">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">SNO#</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">First Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Last Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">City</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Zip</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Actions</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">

                        

                        @foreach($customers as $userdata)
                            <tr>
                                <td class="p-2 whitespace-nowrap ">
                                    <div class="text-left">{{ $userdata->id }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img class="rounded-full" src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg" width="40" height="40" alt="Alex Shatov"></div>
                                        <div class="font-medium text-gray-800">{{ $userdata->first_name }}</div>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $userdata->last_name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-green-500">{{ $userdata->zip }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-lg text-center">{{ $userdata->password }}</div>
                                </td>
                                <td class="py-2 pl-2 flex justify-center items-center">
                                    <a class="text-black font-semibold rounded-full py-2 px-3" href="{{ URL('admin/customers/'.$userdata->id.'/edit') }}">Update</a>
                                   
                                    
                                    <form action="{{ URL('admin/customers',$userdata->id) }}" method="Post">
                                       @csrf
                                      
                                        <input class="bg-red-600 text-black px-5 py-2 rounded-full font-semibold" type="submit" value="Delete">
                                    </form>
                                </td>
                               
                                {{-- @php
                                    dd($userdata->id);
                                @endphp --}}
                                
                            </tr>
                           @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</x-app-layout>

