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
                    <h5 class="mb-3 float-start">Specification Update</h5>
                    <a href="{{ route('admin.specifications.index', app()->getLocale()) }}" class="btn btn-warning float-end">Go Back</a>
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
            <form class="theme-form" method="post" action="{{ route('admin.specifications.update', [app()->getLocale(), $specification->id]) }}">
                @csrf
                @method('PUT')

                @php
                    // dd($spec_heads)
                @endphp
                    
                <div class="card-body">
                    <div class="mb-3">
                        <label class="col-form-label pt-0" for="cat_name_input">Specification Name</label>
                        <input name="name" class="form-control" id="cat_name_input" type="text" placeholder="Enter name" value="{{ $specification->name }}">
                    </div>
                    <div class="mb-3">
                        @php
                            $head = '';
                            $key = 'checked';
                            if ($specification->type == 'head') {
                                $head = 'checked';
                                $key = '';
                            }
                        @endphp
                        <label class="col-form-label pt-0">
                            <input name="type" class="" type="radio" value="head" {{ $head }}> Is head?
                        </label>
                        <label class="col-form-label pt-0">
                            <input name="type" class="" type="radio" value="key" {{ $key }}> Is key?
                        </label>
                    </div>

                    @if (!empty($spec_heads))
                    <div class="mb-3 head_dd" @if ($key=='') style="display:none;" @endif>
                        <label class="col-form-label pt-0" for="spec_head_dd">Specification Head</label>
                        <select class="form-control" name="head_id" id="spec_head_dd">
                            <option value="">-- Select head --</option>
                            @foreach ($spec_heads as $head)
                                <option value="{{ $head->id }}">{{ $head->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="mb-3">
                        <alert class="alert-warning">No head found, please add first!</alert>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function() {
            $('.theme-form').on('change', 'input[name="type"]', function(event) {
                event.preventDefault();
                let val = $(this).val()
                console.log(val)

                if (val=='head') {
                    console.log('slideup')
                    $('.head_dd').slideUp(300);
                } else {
                    console.log('slidedown')
                    $('.head_dd').slideDown(500);
                }
            });
        });
    </script>
@endsection