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
                    <h5 class="mb-3 float-start">Category Update</h5>
                    <a href="{{ route('categories.index', app()->getLocale()) }}" class="btn btn-warning float-end">Go Back</a>
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
            <form class="theme-form" method="post" action="{{ route('categories.update', [app()->getLocale(), $category->id]) }}">
                @csrf
                @method('PUT')
                    
                <div class="card-body">
                    {{-- @php
                        dd($category->name)
                    @endphp --}}
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_name_input">Category Name</label>
                        <input name="name" class="form-control" id="cat_name_input" type="text" placeholder="Enter name" value="{{ $category->name }}">
                        {{-- <small class="form-text text-muted" id="emailHelp">We'll never share your email with anyone else.</small> --}}
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_slug_input">Category Slug</label>
                        <input name="slug" class="form-control" id="cat_slug_input" type="text" placeholder="Enter slug" value="{{ $category->slug }}">
                        {{-- <small class="form-text text-muted" id="emailHelp">We'll never share your email with anyone else.</small> --}}
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_parent_input">Category Parent</label>
                        {{-- <input class="form-control" id="cat_parent_input" type="text" placeholder="Enter slug" value="{{ $category->slug }}"> --}}
                        <select name="parent_id" id="" class="form-control">
                            <option value="0">-- Select parent --</option>
                            @foreach ($existingCats as $excat)
                                @if ($excat->id == $category->parent_id)
                                    <option value="{{ $excat->id }}" selected>{{ $excat->name }}</option>
                                @else
                                    <option value="{{ $excat->id }}">{{ $excat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        {{-- <small class="form-text text-muted" id="emailHelp">We'll never share your email with anyone else.</small> --}}
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_order_input">Category Slug</label>
                        <input name="order" class="form-control" id="cat_order_input" type="number" placeholder="Enter order" value="{{ $category->order }}">
                        {{-- <small class="form-text text-muted" id="emailHelp">We'll never share your email with anyone else.</small> --}}
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    {{-- <button class="btn btn-secondary" data-bs-original-title="" title="">Cancel</button> --}}
                </div>
            </form>
        </div>
    </div>
@stop
