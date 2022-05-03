@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Product Brands</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Product Brands</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="mb-3 float-start">Brand Update</h5>
                    <a href="{{ route('brands.index', app()->getLocale()) }}" class="btn btn-warning float-end">Go Back</a>
                </div>
                {{-- <span>Category list will sho</span> --}}

                <div class="alert-box">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <form class="theme-form" method="post" action="{{ route('brands.update', [app()->getLocale(), $brand->id]) }}">
                @csrf
                @method('PUT')
                    
                <div class="card-body">
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_name_input">Brand Name</label>
                        <input name="name" class="form-control" id="cat_name_input" type="text" placeholder="Enter name" value="{{ $brand->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_slug_input">Brand Website</label>
                        <input name="slug" class="form-control" id="cat_slug_input" type="text" placeholder="Enter slug" value="{{ $brand->website }}">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_order_input">Contact Person</label>
                        <input name="order" class="form-control" id="cat_order_input" type="number" placeholder="Enter order" value="{{ $brand->contact_person }}">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_order_input">Contact Person</label>
                        <input name="order" class="form-control" id="cat_order_input" type="number" placeholder="Enter order" value="{{ $brand->contact_number }}">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_order_input">Contact Person</label>
                        <input name="order" class="form-control" id="cat_order_input" type="number" placeholder="Enter order" value="{{ $brand->contact_email }}">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop
