@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Image Library</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Image library</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="pt-2 float-start">Uploaded Images</h5>
                    <a href="{{ route('admin.images.create', app()->getLocale()) }}" class="btn btn-primary float-end">Upload New</a>
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
            <div class="card-body position-relative image-list">
            	<div class="row g-2">
                    {{-- @php
                        dd($images)
                    @endphp --}}
                    @if (count($images) > 0)
                        @foreach ($images as $img)
                        <div class="col-md-3 mb-3 img">
                            <div class="img-box p-3" id="img-{{ $img['id'] }}">
                                @php
                                $img_src = $img['url'];
                                if ($img['extension'] == 'pdf') {
                                    $img_src = '/admin/assets/images/adobe-pdf-file-icon.svg';
                                }
                                @endphp
                                <img src="{{ $img_src }}" alt="{{ empty($img['alt'])?$img['name']:$img['alt'] }}" data-bs-toggle="modal" data-bs-target="#image_details">
                                <div class="img-info d-none">
                                    <p class="form-action-link">{{ route('admin.images.update', [app()->getLocale(), $img['id']]) }}</p>
                                    <p class="img-del-link">{{ route('admin.images.destroy', [app()->getLocale(), $img['id']]) }}</p>
                                    <p class="name">{{ $img['name'] }}</p>
                                    <p class="caption">{{ $img['caption'] }}</p>
                                    <p class="description">{{ $img['description'] }}</p>
                                </div>
                                <div class="img-delete">
                                    <form method="post" action="{{ route('admin.images.destroy', [app()->getLocale(), $img['id']]) }}" class="d-inline"> @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="paginage mt-4">
                        	{{ $images->links() }}
                        </div>
                    @else
                        <div class="col-md-12 text-muted">
                            File not found, please <a href="{{ route('admin.images.create', app()->getLocale()) }}">upload now</a>!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image_details" tabindex="-1" aria-labelledby="image_detailsLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Category</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <div class="img-preview">
                        <img src="" alt="">
                    </div>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Alt</label>
                            <input type="text" name="alt" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Caption</label>
                            <input type="text" name="caption" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Description</label>
                            <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
