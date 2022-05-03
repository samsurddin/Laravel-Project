@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Product Specifications</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Product Specifications</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="mb-3 float-start">Specification List</h5>
                    <a href="{{-- {{ route('admin.specifications.create', app()->getLocale()) }} --}}" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal1">Add New</a>
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
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($specifications as $spec)

				            @php
                                $product_count_or_head = $spec->products()->count();

                                if ($spec->type == 'head'){
                                    $product_count_or_head = 'head';
                                }

				            	// dd($categories->toSql());
				            @endphp
                            <tr data-cat="{{ $spec->id }}">
                                <th scope="row">{{ $spec->id }}</th>
                                <td>
                                	{{ $spec->name }} <span class="font-success f-12">({{$product_count_or_head}})</span>
                                </td>
                                <td>
                                    <form method="post" action="{{ route('admin.specifications.destroy', [app()->getLocale(), $spec->id]) }}" class="d-inline"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
									<a href="{{ route('admin.specifications.edit', [app()->getLocale(), $spec->id]) }}" class="btn btn-success btn-xs edit" title="">Edit</a>
								</td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                    <div class="paginage mt-4">
                    	{{ $specifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add New Specification</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <form class="form-bookmark" method="post" action="{{ route('admin.specifications.store', app()->getLocale()) }}">
                        @csrf
                        
                        <div class="row g-2">
                            <div class="mb-3 col-md-12">
                                <input class="form-control" type="text" required placeholder="Enter spec name" name="name">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="me-4">
                                    <input type="radio" name="type" value="head"> Is head?
                                </label>
                                <label>
                                    <input class="" type="radio" name="type" value="key" checked> Is key?
                                </label>
                            </div>
                            <div class="mb-3 col-md-12 head_dd">
                                <select class="form-control" name="head_id" id="">
                                    <option value="">-- Select head --</option>
                                    @foreach ($spec_heads as $sp_head)
                                        <option value="{{ $sp_head->id }}">{{ $sp_head->name }}</option>
                                    @endforeach
                                </select>
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

@section('script')
    <script>
        $(function() {
            $('.modal').on('change', 'input[name="type"]', function(event) {
                event.preventDefault();
                let val = $(this).val()

                if (val=='head') {
                    $('.head_dd').slideUp(300);
                } else {
                    $('.head_dd').slideDown(500);
                }
            });
        });
    </script>
@endsection