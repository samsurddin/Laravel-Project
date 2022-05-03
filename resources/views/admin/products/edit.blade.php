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
                    <h5 class="pt-2 float-start">Update Product</h5>
                    <a href="{{ route('admin.products.index', app()->getLocale()) }}" class="btn btn-warning float-end">Go Back</a>
                </div>
                {{-- <span>Product list will sho</span> --}}

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
            <span id="temp_img_response" class="d-none"></span>
            <form class="theme-form product-create" method="post" action="{{ route('admin.products.update', [app()->getLocale(), $product->id]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="featured_img" name="featured_img" value="{{ $product->featured_img }}">
                    
                <div class="card-body">
                    @php
                        // dd([$categories, $brands, $specs, $product])
                    @endphp

                    <div id="basic_info">
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_name_input">Name</label>
                            <input name="name" class="form-control" id="pro_name_input" type="text" placeholder="Enter name" value="{{ empty(old('name'))?$product->name:old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_slug_input">Slug</label>
                            <input name="slug" class="form-control" id="pro_slug_input" type="text" placeholder="Enter slug" value="{{ empty(old('slug'))?$product->slug:old('slug') }}">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_sdesc_ta">Short Description</label>
                            <textarea name="short_description" class="form-control" id="pro_sdesc_ta" cols="30" rows="3" placeholder="Enter short description">{{ empty(old('short_description'))?$product->short_description:old('short_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_desc_ta">Long Description</label>
                            <textarea name="description" class="form-control" id="pro_desc_ta" cols="30" rows="4" placeholder="Enter description">{{ empty(old('description'))?$product->description:old('description') }}</textarea>
                        </div>
                    </div>

                    <div id="price_stock" class="pt-4 mt-5">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pro_regular_price_input" class="form-label">Regular Price</label>
                                <input type="number" name="regular_price" class="form-control" id="pro_regular_price_input" value="{{ empty(old('regular_price'))?$product->regular_price:old('regular_price') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pro_sale_price_input" class="form-label">Sale Price</label>
                                <input type="number" name="sale_price" class="form-control" id="pro_sale_price_input" value="{{ empty(old('sale_price'))?$product->sale_price:old('sale_price') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="pro_sku_input" class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control" id="pro_sku_input" value="{{ empty(old('sku'))?$product->sku:old('sku') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="pro_sku_input" class="form-label">Stock Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control" id="pro_stock_quantity_input" value="{{ empty(old('stock_quantity'))?$product->stock_quantity:old('stock_quantity') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="pro_stock_available_input" class="form-label">Available stock?</label>
                                @php
                                $stock_available =  empty(old('stock_available'))?$product->stock_available:old('stock_available');
                                @endphp
                                <select name="stock_available" id="pro_stock_available_input" class="form-control">

                                    <option value="yes" {{ $stock_available == 'yes'?'selected':'' }}>Yes</option>
                                    <option value="no" {{ $stock_available == 'no'?'selected':'' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="qa_box" class="pt-4 mt-5">
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_what_is_q_input">"What is" Question</label>
                            <input name="what_is_q" class="form-control" id="pro_what_is_q_input" type="text" placeholder="Enter what is question" value="{{ empty(old('what_is_q'))?$product->what_is_q:old('what_is_q') }}">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="pro_what_is_a_ta">"What is" Answer</label>
                            <textarea name="what_is_a" class="form-control" id="pro_what_is_a_ta" cols="30" rows="3" placeholder="Enter what is answer">{{ empty(old('what_is_a'))?$product->what_is_a:old('what_is_a') }}</textarea>
                        </div>
                    </div>

                    <div id="product_meta_box" class="pt-4 mt-5">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="pro_cat_id_input">Category</label>
                                @php
                                    $cat_id = empty($product->categories()->first())?old('cat_id'):$product->categories()->first()->id
                                @endphp
                                <select name="cat_id" id="pro_cat_id_input" class="form-control">
                                    <option value="0">-- Select category --</option>
                                    @foreach ($categories as $cat)
                                        @if ( $cat->id == $cat_id )
                                            <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                        @else
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="pro_brand_id_input">Brand</label>
                                <select name="brand_id" id="pro_brand_id_input" class="form-control">
                                    <option value="0">-- Select brand --</option>
                                    @foreach ($brands as $brand)
                                        @if ($brand->id == ( empty(old('brand_id'))?$product->brand_id:old('brand_id') ))
                                            <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                                        @else
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="specification_box" class="pt-4 mt-5">
                        @php
                            // dd($product->specifications)
                        @endphp
                        @foreach ($product->specifications as $spec)
                            @php
                                // dd($spec)
                                // dd(empty(old('spac_key[]')))
                                // dd(empty(old('spac_key[]'))?$spec->id:old('spac_key[]'))
                            @endphp
                            <div class="row mb-3 position-relative spec-row">
                                <button type="button" class="btn-close position-absolute"></button>
                                <div class="col-md-6 spec_key">
                                    <label class="col-form-label pt-0">Specification</label>
                                    <select name="spac_key[]" class="form-control spac_key">
                                        <option value="0">-- Select specification --</option>
                                        @foreach ($specs as $a_spac)
                                            @if ($a_spac->type != 'head')
                                                @php
                                                    $head_name = '';
                                                    if (!empty($a_spac->head_id)) {
                                                        $head_name = $a_spac->parent()->first()->name . ' >> ';
                                                    }
                                                @endphp

                                                @if ($a_spac->id == ( empty(old('spac_key[]'))?$spec->id:old('spac_key[]') ))
                                                    <option value="{{ $a_spac->id }}" selected>{{ $head_name }}{{ $a_spac->name }}</option>
                                                @else
                                                    <option value="{{ $a_spac->id }}">{{ $head_name }}{{ $a_spac->name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 spec_val">
                                    <label class="form-label">Specification Value</label>
                                    <input type="text" name="spac_val[{{$spec->id}}]" value="{{ $spec->pivot->value }}" class="form-control spac_val">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="#" id="add_spec_row">Add More Specification</a>

                    <div id="image_box" class="images mb-3 pt-4 mt-5">
                        <label for="pro_regular_price_input" class="form-label">Images</label>
                        <div id="img_preview" class="preview row">
                            @php
                                // dd($product->images);
                                $img_inputs = '';
                            @endphp
                            @foreach ($product->images as $img)
                                @php
                                $img_inputs .= '<input type="hidden" name="image[]" value="'. $img->id .'" id="img-input-'. $img->id .'">';

                                $feat_class = '';
                                if ($product->featured_img == $img->url) {
                                    $feat_class = 'featured';
                                }
                                @endphp
                                <div class="col-md-3 position-relative">
                                    <div class="img-item {{ $feat_class }}">
                                        <img src="{{ $img->url }}" id="img-{{ $img->id }}">
                                        <button class="close-btn" id="remove-img-{{ $img->id }}"></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="uploaded_files">{!! $img_inputs !!}</div>
                        <div id="drop-area">
                            <p>Upload multiple files with the file dialog or by dragging and dropping images onto the dashed region</p>
                            <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                            <label class="button btn btn-outline-primary" for="fileElem">Select some files</label>
                            <div class="upload-prograss">
                                <progress id="progress-bar" max=100 value=0></progress>
                            </div>
                            <span id="insert_media_popup" data-bs-toggle="modal" data-bs-target="#insert_image_modal" class="btn btn-outline-primary btn-sm">Insert Existing Files</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
            <div id="spec_clone_fields" class="d-none">
                <div class="row mb-3 position-relative spec-row">
                    <button type="button" class="btn-close position-absolute" data-bs-original-title="" title=""></button>
                    <div class="col-md-6 spec_key">
                        <label class="col-form-label pt-0">Specification</label>
                        <select name="spac_key[]" class="form-control spac_key">
                            <option value="">-- Select specification --</option>

                            @foreach ($specs as $a_spac)
                                @if ($a_spac->type != 'head')
                                    @php
                                        $head_name = '';
                                        if (!empty($a_spac->head_id)) {
                                            $head_name = $a_spac->parent()->first()->name . ' >> ';
                                        }
                                    @endphp

                                    <option value="{{ $a_spac->id }}">{{ $head_name }}{{ $a_spac->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 spec_val">
                        <label class="form-label">Specification Value</label>
                        <input type="text" name="spac_val[]" class="form-control spac_val">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="insert_image_modal" tabindex="-1" aria-labelledby="insert_image_modal_label" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insert_image_modal_label">Upload Image</h5>
                    <a href="#" class="btn btn-primary ms-2" id="insert_image_btn">Insert Selected Images</a>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        {{-- <div id="drop-area">
                            <p>Upload multiple files with the file dialog or by dragging and dropping images onto the dashed region</p>
                            <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                            <label class="button" for="fileElem">Select some files</label>
                            <progress id="progress-bar" max=100 value=0></progress>
                            <div id="gallery"></div>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    {{-- <script src="{{ asset('admin/assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone/dropzone-script.js') }}"></script> --}}

    <script>
        // ************************ Drag and drop ***************** //
        let dropArea = document.getElementById("drop-area")

        // Prevent default drag behaviors
        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)   
            document.body.addEventListener(eventName, preventDefaults, false)
        })

        // Highlight drop area when item is dragged over it
        ;['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false)
        })

        ;['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false)
        })

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false)

        function preventDefaults (e) {
            e.preventDefault()
            e.stopPropagation()
        }

        function highlight(e) {
            dropArea.classList.add('highlight')
        }

        function unhighlight(e) {
            dropArea.classList.remove('active')
        }

        function handleDrop(e) {
            var dt = e.dataTransfer
            var files = dt.files

            handleFiles(files)
        }

        let uploadProgress = []
        let progressBar = document.getElementById('progress-bar')

        function initializeProgress(numFiles) {
            progressBar.value = 0
            uploadProgress = []

            for(let i = numFiles; i > 0; i--) {
                uploadProgress.push(0)
            }
        }

        function updateProgress(fileNumber, percent) {
            uploadProgress[fileNumber] = percent
            let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
            console.debug('update', fileNumber, percent, total)
            progressBar.value = total
        }

        function handleFiles(files) {
            files = [...files]
            initializeProgress(files.length)
            files.forEach(uploadFile)
            // files.forEach(previewFile)
        }

        function previewFile(file, id) {
            let reader = new FileReader()
            reader.readAsDataURL(file)
            reader.onloadend = function() {
                let img = document.createElement('img')
                img.src = reader.result
                img.id = 'img-'+id;

                let div = document.createElement('div')
                div.className = 'col-md-3 position-relative'

                let div_img_frame = document.createElement('div')
                div_img_frame.className = 'img-item'

                let close_btn = document.createElement('button')
                close_btn.className = 'close-btn'
                close_btn.id = 'remove-img-'+id;

                div_img_frame.appendChild(img)
                div_img_frame.appendChild(close_btn)
                div.appendChild(div_img_frame)

                // document.getElementById('gallery').appendChild(div)

                let input = document.createElement('input')
                input.setAttribute('value', id)
                input.id = 'img-input-'+id
                input.name = 'image[]'
                input.type = 'hidden'

                document.getElementById('uploaded_files').appendChild(input)
                document.getElementById('img_preview').appendChild(div)
            }
        }

        function generate_img_preview_tags(img_src, id='', target_id='gallery') {
            let img = document.createElement('img')
            img.src = img_src
            img.id = 'img-'+id;

            let div = document.createElement('div')
            div.className = 'col-md-3 position-relative'

            let close_btn = document.createElement('button')
            close_btn.className = 'close-btn'
            close_btn.id = 'remove-img-'+id;

            div.appendChild(img)
            div.appendChild(close_btn)

            document.getElementById(target_id).appendChild(div)
            console.log(div)
            console.log(document.getElementById(target_id))
        }

        function uploadFile(file, i) {
            // var url = 'https://api.cloudinary.com/v1_1/joezimim007/image/upload'
            var url = '{{ route('imageUpload', app()->getLocale()) }}'
            var xhr = new XMLHttpRequest()
            var formData = new FormData()
            xhr.open('POST', url, true)
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))

            // Update progress (can be used to show progress indicator)
            xhr.upload.addEventListener("progress", function(e) {
                updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
            })

            xhr.addEventListener('readystatechange', function(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    updateProgress(i, 100) // <- Add this
                    console.log(e);
                    console.log('readystatechange')
                    console.log(this.responseText)
                    let response = JSON.parse(xhr.responseText);
                    console.log(response)
                    console.log(response.id)
                    previewFile(file, response.id);
                }
                else if (xhr.readyState == 4 && xhr.status != 200) {
                    // Error. Inform the user
                }
            })

            formData.append('upload_preset', 'ujpu6gyk')
            formData.append('imageFile', file)
            xhr.send(formData)

            // xhr.addEventListener("load", event => {
            //     console.log(event)
            //     console.log('<< Uploaded')
            // });
            // xhr.addEventListener("error", event => {
            //     console.log(event)
            //     console.log('<< error')
            // });
        }

        $('#img_preview').on('click', '.close-btn', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            let id = $(this).attr('id').split('remove-img-')[1]

            $(this).closest('.col-md-3').remove()
            $('#uploaded_files').find('input[value='+id+']').remove()
            console.log(id)
        });

        $('.product-create').on('click', '#insert_media_popup', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('admin.images.index', app()->getLocale()) }}',
                type: 'GET',
                dataType: 'html'
            })
            .done(function(response) {
                console.log("success");
                $('#insert_image_modal').find('.modal-body').html(response);
                // console.log(response)
            })
            .fail(function(response) {
                console.log("error");
                console.log(response)
            })
            .always(function(response) {
                console.log("complete");
                // console.log(response)
            });
        });

        $('#insert_image_modal').on('click', 'a.page-link', function(event) {
            event.preventDefault();

            if ($(this).parent().hasClass('active')) {
                return;
            }
            let paginate_url = $(this).attr('href');

            $.ajax({
                url: paginate_url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(response) {
                console.log("success");
                $('#insert_image_modal').find('.modal-body').html(response);
                // console.log(response)
            })
            .fail(function(response) {
                console.log("error");
                console.log(response)
            })
            .always(function(response) {
                console.log("complete");
                // console.log(response)
            });
            return false;
        });

        $(document).on('click', '#insert_image_btn', function(event) {
            event.preventDefault();
            // event.stopImmediatePropagation();

            console.log('insert_image_btn clicked')

            $('#img-list').find('input[type="checkbox"]:checked').each(function(index, el) {
                console.log($(this).val())
                let img_id = $(this).val()

                let img_url = $(this).closest('.img-box').find('img').attr('src');
                let preview_item_html = '<div class="col-md-3 position-relative"><div class="img-item"><img src="'+img_url+'" id="img-'+img_id+'"><button class="close-btn" id="remove-img-'+img_id+'"></button></div></div>';
                
                $('#img_preview').append(preview_item_html);
                $('#uploaded_files').append('<input type="hidden" name="image[]" value="'+img_id+'" id="img-input-'+img_id+'">');

                $('#insert_image_modal').find('button.btn-close').click();
            });
        });

        $('#img_preview').on('click', '.img-item', function(event) {
            event.preventDefault();
            
            let img_src = $(this).find('img').attr('src')
            console.log($(this))
            console.log(img_src)
            $('#img_preview').find('.img-item').removeClass('featured');
            $(this).addClass('featured');
            $('input#featured_img').val(img_src);
        });
    </script>

    {{-- EDITOR --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#pro_sdesc_ta' ) )
            .catch( error => {
                console.error( error );
            } );
        ClassicEditor
            .create( document.querySelector( '#pro_desc_ta' ) )
            .catch( error => {
                console.error( error );
            } );
        ClassicEditor
            .create( document.querySelector( '#pro_what_is_a_ta' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            /* width: 480px; */
            height: 100%;
            margin: 15px 0;
            padding: 80px 20px;
            text-align: center;
            background: #fff;
        }
        #drop-area.highlight {
            border-color: #7366ff;
            background-color: #f6f5ff;
        }
        p {
            margin-top: 0;
        }
        .my-form {
            margin-bottom: 10px;
        }
        #gallery {
            margin-top: 10px;
        }
        #gallery img {
            width: 150px;
            margin-bottom: 10px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .button {
            display: inline-block;
            padding: 10px;
            background: #ccc;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .button:hover {
            background: #ddd;
        }
        #fileElem {
            display: none;
        }
    </style>
@endsection