<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Plan') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New User</a> --}}
            <a class="btn-primary" href="{{ route('plans.show', [app()->getLocale(), $plan->id]) }}"> Show Plan</a>
            <a class="btn-sm" href="{{ route('plans.index', app()->getLocale()) }}"> All Plans</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Something went wrong.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Use a permanent address where you can receive mail.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('plans.update', [app()->getLocale(), $plan->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf

                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                                            <input type="text" name="name" id="name" autocomplete="name" class="input" value="{{ old('name', $plan->name) }}">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="3" class="input">{{ old('description', $plan->description) }}</textarea>
                                        </div>
                                        <div class="col-span-6">
                                            <label for="features" class="block text-sm font-medium text-gray-700">Features</label>
                                            <textarea name="features" id="features" cols="30" rows="3" class="input">{{ old('features', $plan->features) }}</textarea>
                                        </div>
                                        <div class="col-span-3">
                                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                            <input type="number" name="price" id="price" autocomplete="price" class="input" value="{{ old('price', $plan->price) }}">
                                        </div>
                                        <div class="col-span-3">
                                            <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                                            <input type="number" name="discount" id="discount" autocomplete="discount" class="input" value="{{ old('discount', $plan->discount) }}">
                                        </div>
                                        <div class="col-span-3">
                                            <label for="price_yearly" class="block text-sm font-medium text-gray-700">Price Yearly Format</label>
                                            <input type="number" name="price_yearly" id="price_yearly" autocomplete="price_yearly" class="input" value="{{ old('price_yearly', $plan->price_yearly) }}">
                                        </div>
                                        <div class="col-span-3">
                                            <label for="discount_yearly" class="block text-sm font-medium text-gray-700">Discount Yearly Format</label>
                                            <input type="number" name="discount_yearly" id="discount_yearly" autocomplete="discount_yearly" class="input" value="{{ old('discount_yearly', $plan->discount_yearly) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>