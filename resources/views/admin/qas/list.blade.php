@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Product Questions Answers</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Product Questions Answers</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="mb-3 float-start">QA List</h5>
                    <a href="{{-- {{ route('brands.create', app()->getLocale()) }} --}}" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal1">Add New</a>
                </div>
                {{-- <span>Category list will sho</span> --}}

                <div class="alert-box">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
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
            <div class="card-body">
            	<div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Questions Answers</th>
                                <th scope="col">Questioner</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($qas as $qa)

				            @php
				            	// $product_count = $brand->products()->count();
				            	// dd($categories->toSql());
				            @endphp
                            <tr data-cat="{{ $brand->id }}">
                                <th scope="row">{{ $brand->id }}</th>
                                <td>
                                	{{ $brand->name }} <span class="font-success f-12">({{$product_count}})</span>
                                </td>
                                <td>
                                    {{ $brand->website }}
                                </td>
                                <td>
                                    {{ $brand->contact_person }}
                                </td>
                                <td>
                                    {{ $brand->contact_number }}
                                </td>
                                <td>
                                    {{ $brand->contact_email }}
                                </td>
                                <td>
                                    <form method="post" action="{{ route('brands.destroy', [app()->getLocale(), $brand->id]) }}" class="d-inline"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
									<a href="{{ route('brands.edit', [app()->getLocale(), $brand->id]) }}" class="btn btn-success btn-xs edit" title="">Edit</a>
								</td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                    <div class="paginage mt-4">
                    	{{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add New Brand</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <form class="form-bookmark" method="post" action="{{ route('brands.store', app()->getLocale()) }}">
                        @csrf
                        
                        <div class="row g-2">
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" required placeholder="Enter brand name" name="name">
                            </div>
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" placeholder="Enter brand website" name="website">
                            </div>
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" placeholder="Enter contact person" name="contact_person">
                            </div>
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" placeholder="Enter contact number" name="contact_number">
                            </div>
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" placeholder="Enter contact email" name="contact_email">
                            </div>
                        </div>
                        <button class="btn btn-secondary" type="submit" data-bs-original-title="" title="">Save</button>
                        <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
