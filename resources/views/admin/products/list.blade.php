@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Products</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="mb-3 float-start">Product List</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Add New</a>
                </div>

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
                                <th scope="col">Name</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Price</th>
                                <th scope="col">Categories</th>
                                <th scope="col">Reviews</th>
                                {{-- <th scope="col">Shop</th> --}}
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($products as $product)

				            @php
				            	$shop = $product->shop()->get();
				            	// dd($shop->toSql());
				            	$categories = $product->categories()->get();
				            	// dd($shop);
				            	// dd($categories->toSql());
				            @endphp
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>
                                	<a href="{{ route('product.single', $product->slug) }}" class="d-flex">
                                		<div class="rounded">
                                			<img src="{{ $product->featured_img }}" width="50px" height="50px">
                                		</div>
                                		<div class="ms-2">
                                			{{ $product->name }} {{ $product->slug }}
                                		</div>
                                	</a>
                                </td>
                                {{-- <td>{{ $product->description }}</td> --}}
                                <td>
                                	@if (!empty($product->sale_price))
                                		<span class="price">@money($product->sale_price)</span>
                                		<del>@money($product->regular_price)</del>
									@else
                                		@money($product->regular_price)
                                	@endif
                                </td>
                                <td>
                                	@foreach ($categories as $cat)
                                		<a href="{{ $cat->slug }}" class="badge rounded-pill bg-light">{{ $cat->name }}</a>
                                	@endforeach
                                </td>
                                <td></td>
                                {{-- <td><a href="{{ $shop->slug }}">{{ $shop->name }}</a></td> --}}
                                <td>
                                    <form method="post" action="{{ route('products.destroy', $product->id) }}" class="d-inline"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-xs edit" title="">Edit</a>
								</td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                    <div class="paginage mt-4">
                    	{{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
                                        