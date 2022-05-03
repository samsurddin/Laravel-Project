@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Product Categories</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Product Categories</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="mb-3 float-start">Category List</h5>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary float-end">Add New</a>
                </div>
                {{-- <span>Category list will sho</span> --}}
            </div>
            <div class="card-body">
            	<div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Parent</th>
                                {{-- <th scope="col">short</th>
                                <th scope="col">Reviews</th> --}}
                                {{-- <th scope="col">Shop</th> --}}
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($categories as $categorie)

				            @php
				            	// $shop = $categorie->shop()->get();
				            	// dd($shop->toSql());
				            	$product_count = $categorie->products()->count();
                                $parent = $categorie->parent()->first();
                                // if ($categorie->id == 1){
                                //     dd($parent->toSql());
                                // }
                                // dd($products);
                                // dd($categorie);
				            	// dd($categories->toSql());
				            @endphp
                            <tr>
                                <th scope="row">{{ $categorie->id }}</th>
                                <td>{{-- {{ route('product.single', $categorie->id) }} --}}
                                	<a href="{{ $categorie->slug }}" class="d-flex">
                                		{{-- <div class="rounded">
                                			<img src="{{ $categorie->name }}" width="50px" height="50px">
                                		</div> --}}
                                		
                                        {{ $categorie->name }} <span class="font-success f-12">({{$product_count}})</span>
                                	</a>
                                </td>
                                <td>@if (!empty($parent->name))<a href="{{ $parent->slug }}">{{ $parent->name }}</a>@endif</td>
                                {{-- <td>
                                	@if (!empty($categorie->sale_price))
                                		<span class="price">@money($categorie->sale_price)</span>
                                		<del>@money($categorie->regular_price)</del>
									@else
                                		@money($categorie->regular_price)
                                	@endif
                                </td>
                                <td>
                                	@foreach ($categories as $cat)
                                		<a href="{{ $cat->slug }}" class="badge rounded-pill bg-light">{{ $cat->name }}</a>
                                	@endforeach
                                </td>
                                <td></td> --}}
                                {{-- <td><a href="{{ $shop->slug }}">{{ $shop->name }}</a></td> --}}
                                <td>
									<button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Delete</button>
									<button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</button>
								</td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                    <div class="paginage mt-4">
                    	{{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
