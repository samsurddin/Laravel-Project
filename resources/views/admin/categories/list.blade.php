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
                    <a href="{{-- {{ route('categories.create') }} --}}" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal1">Add New</a>
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
                            @php
                                $options = '';
                            @endphp
                        	@foreach ($categories as $category)

				            @php
                                $options .= '<option value="'.$category->id.'">'.$category->name.'</option>';
				            	// $shop = $category->shop()->get();
				            	// dd($shop->toSql());
				            	$product_count = $category->products()->count();
                                $parent = $category->parent()->first();
                                // if ($category->id == 1){
                                //     dd($parent->toSql());
                                // }
                                // dd($products);
                                // dd($categorie);
				            	// dd($categories->toSql());
				            @endphp
                            <tr data-cat="{{ $category->id }}">
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{-- {{ route('product.single', $category->id) }} --}}
                                	<a href="{{ $category->slug }}" class="d-flex">
                                		{{-- <div class="rounded">
                                			<img src="{{ $category->name }}" width="50px" height="50px">
                                		</div> --}}
                                		
                                        {{ $category->name }} <span class="font-success f-12">({{$product_count}})</span>
                                	</a>
                                </td>
                                <td>@if (!empty($parent->name))<a href="{{ $parent->slug }}">{{ $parent->name }}</a>@endif</td>
                                {{-- <td>
                                	@if (!empty($category->sale_price))
                                		<span class="price">@money($category->sale_price)</span>
                                		<del>@money($category->regular_price)</del>
									@else
                                		@money($category->regular_price)
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
                                    <form method="post" action="{{ route('categories.destroy', $category->id) }}" class="d-inline"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
									<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success btn-xs edit" title="">Edit</a>
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

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Category</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <form class="form-bookmark" method="post" action="{{ route('categories.store') }}">
                        @csrf
                        
                        <div class="row g-2">
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" required placeholder="Enter category name" name="name">
                            </div>
                            <div class="mb-3 col-md-12">
                                <select class="form-control" name="parent_id" id="">
                                    <option value="0">-- Select parent --</option>
                                    {!! $options !!}
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-secondary" type="submit" data-bs-original-title="" title="">Save</button>
                        <button class="btn btn-primary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
