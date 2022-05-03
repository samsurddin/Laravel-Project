@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Order</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Orders</li>
<li class="breadcrumb-item">#{{ $order['order_number'] }}</li>
@endsection
                            
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5 class="pt-2 float-start">#{{ $order['order_number'] }}</h5>
                    <a href="{{ route('products.index', app()->getLocale()) }}" class="btn btn-warning float-end"><i data-feather="eye"></i> Invoice</a>
                </div>

                <x-alert/>
            </div>

            <div class="card-body">
                {{-- {{ order_items($order['items']) }} --}}
                @php
                    // dd($order)
                @endphp
                
                <div id="order_data" class="panel order-data">
                    
                    {{-- <h2 class="order-data__heading">Order #91 details</h2> --}}

                    {{-- <p class="order-data__meta order_number">
                        Payment via Cash on delivery. Customer IP: <span class="order-customer-ip">::1</span>
                    </p> --}}

                    <div class="status time-line">
                        <div class="row text-center justify-content-center mb-5">
                            <div class="col-xl-6 col-lg-8">
                                <h2 class="font-weight-bold">Order #{{ $order['id'] }} details</h2>
                                <p class="text-muted">Payment via {{ Str::headline($order['payment_method']) }}. Customer IP: <span class="order-customer-ip">{{ $order['ip_address'] }}</span></p>
                            </div>
                        </div>
                        {{-- @php
                            foreach ($order['tracking'] as $tracking) {
                                if (in_array($tracking['pivot']['order_status_id'], [1,2,3,4])) {
                                    echo $tracking['pivot']['order_status_id'];
                                }
                            }
                            dd($order['tracking']);
                        @endphp --}}

                        <div class="row">
                            <div class="col">
                                @include('admin.orders.parts.timeline')
                            </div>
                        </div>
                    </div>

                    <div class="order_data_container row mt-4 mb-4 pt-5 border-top">
                        <div class="col summery order-info">
                            @include('admin.orders.parts.summery')
                        </div>
                        <div class="col billing order-info">
                            @include('admin.orders.parts.billing')
                        </div>
                        <div class="col shipping order-info">
                            @include('admin.orders.parts.shipping')
                        </div>
                    </div>

                    @include('admin.orders.parts.items')
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-danger" type="submit">Cancel</button>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </div>

        <div class="order-other-data row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @include('admin.orders.parts.trackings')
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @include('admin.orders.parts.notes')
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
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        // $('.show-toggle').parent().hover(function() {
        //     // $(this).find('.btns').show('fast');
        //     $(this).find('.btns').addClass('show');
        // }, function() {
        //     $(this).find('.btns').removeClass('show');
        // });

        $(document).on({
                mouseenter: function() {
                    $(this).find('.btns').addClass('show');
                },
                mouseleave: function() {
                    $(this).find('.btns').removeClass('show');
                }
            }, '.switch-btns-hover'
        );
        
        $(document).on('click', '.btns a', function (event) {
            event.preventDefault();
            
            if ($(this).data('target')) {
                let target = $(this).data('target')
                let alt_target = $(this).data('alt-target')
                let link_class = $(this).data('class')
                let link_alt_class = $(this).data('alt-class')
                let icon = $(this).data('icon')
                let alt_icon = $(this).data('alt-icon')

                let text = '<i data-feather="'+icon+'"></i> ' + $(this).data('text')
                let alt_text = '<i data-feather="'+alt_icon+'"></i> ' + $(this).data('alt-text')

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active')
                    $(this).addClass(link_class)
                    $(this).removeClass(link_alt_class)
                    $(this).html(text)
                } else {
                    $(this).addClass('active')
                    $(this).html(alt_text)
                    $(this).removeClass(link_class)
                    $(this).addClass(link_alt_class)
                }
                feather.replace()

                $(this).closest('.order-info').find('.'+target).slideToggle()
                $(this).closest('.order-info').find('.'+alt_target).slideToggle()

                console.log($(this).data('target'))
            }
        });
        // if($('.btns').find('a').data('target')) {
        //     console.log($(this))
        // }

        $(document).on('click', '.more-text', function(event) {
            event.preventDefault();

            var text = $(this).find('a').text() == 'less'?'more...':'less';
            $(this).find('a').text(text);
            
            $(this).closest('.more-block').find('.more-contents').slideToggle('fast');
        });

        // $('.submit_form').submit(function(event) {
        $(document).on('submit', '.submit_form', function(event) {
            event.preventDefault();
            let formTag = $(this)
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                console.log(response)
                console.log("success");

                $(response.template_selector).html(response.template)
                // $(response.template_selector).find('.switch-view').click();

                let toast_type = 'success';
                if (!response.success) {
                    toast_type = 'danger';
                }
                make_toast(response.msg, toast_type);
            })
            .fail(function(error) {
                console.log(error)
                console.log("error");

                make_toast('Something went wrong!', 'danger');
            })
            .always(function(response, error, request) {
                // console.log(error)
                // console.log(response)
                // console.log(request)
                // console.log("complete");
            });
            
        });
        function make_toast(msg, type="success") {
            // console.log(type)
            // $(".toast").toast('hide')
            $(".toast").find('.toast-body').text(msg);
            $(".toast").addClass('bg-'+type);
            $('.toast').toast('show');
        }
        function destroy_toast(selector='.toast') {
            $(selector).toast('hide');
        }
    </script>
@endsection

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    </style>
@endsection