<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Show Plan') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New User</a> --}}
            <a class="btn-primary" href="{{ route('plans.edit', [app()->getLocale(), $plan->id]) }}"> Edit Plan</a>
            <a class="btn-secondary" href="{{ route('plans.index', app()->getLocale()) }}"> All Plans</a>
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

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Plan Name:</strong>
                                {{ $plan->name }}
                            </div>
                            <div class="form-group">
                                <strong>Description:</strong><br>
                                {{ $plan->description }}
                            </div>
                            <div class="form-group">
                                <strong>Features:</strong>
                                {{ $plan->features }}
                            </div>
                            <div class="form-group">
                                <strong>Price:</strong>
                                {{ $plan->price }} - {{ $plan->discount }}% discount = {{ $plan->price - ($plan->price/100*$plan->discount) }}
                            </div>
                            <div class="form-group">
                                <strong>Price Yearly:</strong>
                                {{ $plan->price_yearly }} - {{ $plan->discount_yearly }}% discount = {{ $plan->price_yearly - ($plan->price_yearly/100*$plan->discount_yearly) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>