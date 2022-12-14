<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Tenant') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New User</a> --}}
            <a class="btn-primary" href="{{ route('tenants.show', [app()->getLocale(), $tenant->id]) }}"> Show Tenant</a>
            <a class="btn-sm" href="{{ route('tenants.index', app()->getLocale()) }}"> All Tenants</a>
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
                        <form action="{{ route('tenants.update', [app()->getLocale(), $tenant->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf

                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Tenant Name</label>
                                            <input type="text" name="name" id="name" autocomplete="name" class="input" value="{{ old('name', $tenant->name) }}">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="domain" class="block text-sm font-medium text-gray-700">Domain Name</label>
                                            <input type="text" name="domain" id="domain" autocomplete="domain" class="input" value="{{ old('domain', $tenant->domain) }}">
                                        </div>
                                        <div class="col-span-3">
                                            <label for="plan" class="block text-sm font-medium text-gray-700">Plan</label>
                                            <select name="plan_id" id="plan_id" class="input">
                                                @foreach ($plans as $plan)
                                                    <option value="{{ $plan->id }}" {{ old('plan_id', $tenant->plan_id)==$plan->id?"selected":"" }}>{{ $plan->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-3">
                                            <label for="user_id" class="block text-sm font-medium text-gray-700">Choose User</label>
                                            <select name="user_id" id="user_id" class="input">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ old('user_id', $tenant->user_id)==$user->id?"selected":"" }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-6">
                                            <fieldset>
                                                <div>
                                                    <legend class="text-base font-medium text-gray-900">Tenant Status</legend>
                                                    <p class="text-sm text-gray-500">Inactive tenant's data will not be removed</p>
                                                </div>
                                                <div class="mt-4 space-y-4">
                                                    <div class="flex items-center">
                                                        <input id="status-active" name="status" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" value="active" {{ null!==old('status', $tenant->status)?(old('status', $tenant->status)=='active'?'checked':''):'checked' }}>
                                                        <label for="status-active" class="ml-3 block text-sm font-medium text-gray-700">
                                                            Active
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input id="status-inactive" name="status" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" value="inactive" {{ old('status', $tenant->status)=='inactive'?'checked':'' }}>
                                                        <label for="status-inactive" class="ml-3 block text-sm font-medium text-gray-700">
                                                            Inactive
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
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