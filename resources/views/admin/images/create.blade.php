@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Image Library</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Images</li>
<li class="breadcrumb-item active">Image Upload</li>
@endsection

							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="pt-2 float-start">Upload New Image</h5>
                    <a href="{{ route('admin.images.index', app()->getLocale()) }}" class="btn btn-warning float-end">Go Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.images.store', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="user-image mb-3 text-center">
                        <div class="imgPreview"> </div>
                    </div>            

                    <div class="custom-file">
                        <input type="file" name="imageFile[]" class="custom-file-input" id="images" multiple="multiple">
                        <label class="custom-file-label" for="images">Choose image</label>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                        Upload Images
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script>
        
        $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    $(imgPreviewPlaceholder).html('');
                    for (i = 0; i < filesAmount; i++) {
                        var extension = input.files[i].name.split('.').pop().toLowerCase();
                        var reader = new FileReader();

                        if (extension == 'pdf') {
                            $($.parseHTML('<img>')).attr('src', '/admin/assets/images/adobe-pdf-file-icon.svg').appendTo(imgPreviewPlaceholder);
                        } else {
                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                            }
                        }
                        // $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };

            let selected_file = [];
            $('#images').on('change', function() {
                multiImgPreview(this, 'div.imgPreview');
            });
        });
    </script>
@stop