<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Plan Management') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New User</a> --}}
            <a class="btn-primary" href="{{ route('plans.create', app()->getLocale()) }}"> Create New Plan</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Features
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($plans as $plan)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $plan->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $plan->updated_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $plan->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $plan->features }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="text-sm text-gray-900">{{ $plan->price }}</div>
                                                    <div class="text-sm text-gray-500">{{ $plan->price_yearly }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                                    {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a> --}}
                                                    <a class="text-purple-600 hover:text-purple-900 border border-purple-600 hover:border-purple-900 rounded-full px-1" href="{{ route('plans.show', [app()->getLocale(), $plan->id]) }}">Show</a>
                                                    <a class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 hover:border-indigo-900 rounded-full px-1" href="{{ route('plans.edit', [app()->getLocale(), $plan->id]) }}">Edit</a>
                                                    <form method="POST" action="{{ route('plans.destroy', [app()->getLocale(), $plan->id]) }}" class="inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        
                                                        <input type="submit" class="text-red-600 hover:text-red-900 border border-red-600 hover:border-red-900 cursor-pointer rounded-full px-1" value="Delete">
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    <div class="paginate-links">{{ $plans->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
