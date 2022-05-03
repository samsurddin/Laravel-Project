<x-front-layout>
    <x-breadcrumb/>

    <div class="cart-wrapper bg-white py-4 wrapper">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-lg-8">
                    <h1 class="page-title text-center">Checkout</h1>
                </div>
                <div class="col-lg-12">
                    
                    <x-alert/>
                    
                    @php
                    $cartItems = getCartItems();
                    @endphp

                    @if ($cartItems)
                        <form action="{{route('orders.store', app()->getLocale())}}" method="post" class="row checkout-form">
                            @csrf
                            <div class="col-lg-8">
                                <div class="shipping-info mb-4">
                                    <h3>Shipping Information</h3>
                                    @if (!$user)
                                    <div class="card mb-4 bg-gray">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <label for="">Full Name</label>
                                                <input type="text" name="shipping_fullname" value="{{ old('shipping_fullname') }}" class="form-control" placeholder="Write your full name">
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="">Mobile</label>
                                                    <input type="text" name="shipping_mobile" value="{{ old('shipping_mobile') }}" class="form-control mobile" placeholder="Write your mobile number">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Email</label>
                                                    <input type="text" name="shipping_email" value="{{ old('shipping_email') }}" class="form-control email" placeholder="Write your email address">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Password</label>
                                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="Write your password">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" placeholder="Write your password again">
                                                </div>
                                                <div class="col-md-12 mt-3 text-center">Do you have an account? <a class="btn btn-sm tz-info ms-2" href="{{ route('login', app()->getLocale()) }}">Login now</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="mb-4">
                                        <label for="">Full Name</label>
                                        <input type="text" name="shipping_fullname" value="{{ old('shipping_fullname', $user_info['name']) }}" class="form-control" placeholder="Write your full name">
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="">Mobile</label>
                                            <input type="text" name="shipping_mobile" class="form-control mobile" value="{{ old('shipping_mobile', $user_info['billing_mobile']) }}" placeholder="Write your mobile number">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Email</label>
                                            <input type="email" value="{{ old('shipping_email', $user_info['email']) }}" name="shipping_email" class="form-control email" placeholder="Write your email address">
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group mb-4">
                                        <label for="">Address</label>
                                        <textarea name="shipping_address" class="form-control" placeholder="Write your address">{{ old('shipping_address', $user_info['billing_address']) }}</textarea>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="shipping_state" class="form-label">Division</label>
                                            <select name="shipping_state" class="select2 form-control" data-placeholder="Type a division name">
                                                <option></option>
                                                {!! $dropdown['division_dd'] !!}
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            

                                            <label for="shipping_city" class="form-label">City</label>
                                            <select name="shipping_city" class="select2 form-control" data-placeholder="Type a city name">
                                                <option></option>
                                                {!! $dropdown['district_dd'] !!}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="shipping_zipcode" class="form-label">Zip</label>
                                            <select name="shipping_zipcode" class="select2 form-control" data-placeholder="Type a postcode or area name">
                                                <option></option>
                                                @foreach ($loc_data['postcodes'] as $postcode)
                                                    <option @if (old('shipping_zipcode', $user_info['billing_zipcode']) == $postcode['postCode']) selected @endif title="{{ $postcode['postOffice'] }}" value="{{ $postcode['postCode'] }}">
                                                        {{ $postcode['postCode'] }}, 
                                                        {{-- {{ $postcode['postOffice'] }},  --}}{{ $postcode['upazila'] }}, {{ $postcode['district']['name'] }}, {{ $postcode['division']['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="shipping_country" class="form-label">Country</label>
                                            <input type="text" name="shipping_country" class="form-control" placeholder="Write your country" id="shipping_country" value="{{ $user_info['billing_country'] }}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="">Alt. Contact Person (optional)</label>
                                        <input type="text" name="shipping_alt_contact" class="form-control" placeholder="Alternative person, if you were not available at time of shipping" value="{{ old('shipping_alt_contact') }}">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="">Alt. Mobile (optional)</label>
                                        <input type="text" name="shipping_alt_mobile" class="form-control mobile" placeholder="Write an alternative mobile number" value="{{ old('shipping_alt_mobile') }}">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="">Note (optional)</label>
                                        <textarea class="form-control" name="shipping_note" cols="30" rows="5" placeholder="Add delivery instruction or write anything about this order as note (Optional)">{{ old('shipping_note') }}</textarea>
                                        <small class="text-muted">eg. Please come before 5AM. or, Please call before come. or other instructions are can be added.</small>
                                    </div>
                                </div>

                                <div class="show-section hidden my-5" data-target="billing-info" aria-expanded="billing-info">
                                    <a href="" class="tz-info">
                                        Billing information is not same as shipping informaion <i class="fas fa-chevron-down me-2"></i>
                                        <input type="hidden" name="has_billing_info" value="no">
                                    </a>

                                </div>
                                
                                <div class="billing-info" style="display: none;">
                                    <h3>Billing Information</h3>

                                    <div class="mb-4">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="billing_fullname" value="{{ $user_info['name'] }}" class="form-control" placeholder="Write your full name">
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Mobile</label>
                                            <input type="text" name="billing_mobile" class="form-control mobile" value="{{ $user_info['billing_mobile'] }}" placeholder="Write your mobile number">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" value="{{ $user_info['email'] }}" name="billing_email" class="form-control" placeholder="Write your email address">
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label">Address</label>
                                        <textarea name="billing_address" class="form-control" placeholder="Write your address">{{ $user_info['billing_address'] }}</textarea>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Division</label>
                                            <select name="billing_state" class="select2 form-control" data-placeholder="Type a division name">
                                                <option></option>
                                                {!! $dropdown['division_dd'] !!}
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <select name="billing_city" class="select2 form-control" data-placeholder="Type a city name">
                                                <option></option>
                                                {!! $dropdown['district_dd'] !!}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Zip</label>
                                            <select name="billing_zipcode" class="select2 form-control" data-placeholder="Type a postcode or area name">
                                                <option></option>
                                                @foreach ($loc_data['postcodes'] as $postcode)
                                                    <option @if ($user_info['billing_zipcode'] == $postcode['postCode']) selected @endif title="{{ $postcode['postOffice'] }}" value="{{ $postcode['postCode'] }}">
                                                        {{ $postcode['postCode'] }}, 
                                                        {{-- {{ $postcode['postOffice'] }},  --}}{{ $postcode['upazila'] }}, {{ $postcode['district']['name'] }}, {{ $postcode['division']['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Country</label>
                                            <input type="text" name="billing_country" class="form-control" placeholder="Write your country" value="{{ $user_info['billing_country'] }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="summery">
                                    <section class="minicart">
                                        <h4>Cart Summery</h4>
                                        <div id="minicart_wrapper">
                                            @include('cart.minicart')
                                        </div>
                                    </section>

                                    <section class="coupon mb-4">
                                        <div class="input-group">
                                            <input id="coupon_code" class="form-control" name="coupon_code" placeholder="Coupon code" type="text">
                                            <a id="apply_coupon" href="{{route('cart.applycoupon', app()->getLocale())}}" class="btn btn-brand fw-bold text-light">Apply Coupon</a>
                                        </div>
                                    </section>

                                    <section class="payment-option mb-4">
                                        <h4>Payment option</h4>
                                        <div class="form-check mb-2">
                                            <label class="form-check-label">
                                                <input type="radio" checked class="form-check-input tz-info" name="payment_method" value="cash_on_delivery">
                                                <strong class="check-title d-block">Cash on delivery</strong>
                                                <span class="check-desc d-block mt-1">Sapiente, reprehenderit placeat rem, ex perspiciatis consectetur, harum autem ipsa quod tenetur similique minima voluptatem corrupti veritatis dignissimos omnis nesciunt animi repellendus?</span>
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input tz-info" name="payment_method" value="paypal">
                                                <strong class="check-title d-block">Paypal</strong>
                                                <span class="check-desc d-block mt-1">Lorem ipsum dolor sit amet consectetur adipisicing, exercitationem illum sit, adipisci esse velit facilis temporibus ipsa! Nihil pariatur laboriosam illo?</span>
                                            </label>
                                        </div>
                                    </section>

                                    <section class="agreement mb-4">
                                        <h4>Terms &amp; Conditions</h4>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" checked class="form-check-input tz-info" name="accept_tc">
                                                Accept terms &amp; conditions
                                            </label>
                                        </div>
                                    </section>
                                    <div class="checkout-btn d-grid gap-2">
                                        <button type="submit" class="btn tz-info">Place Order <i class="fas fa-arrow-right ms-2 text-light"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="col-md-12">
                            <div class="alert alert-warning my-4">The cart is empty.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="two-col">
        <div class="container-fluid">
            <div class="row wrapper">
                <div class="col-lg-12 product-list">
                </div>
            </div>
        </div>
    </section>

    @push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <style>

    </style>
    @endpush

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" defer></script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            (function($) {
                $(".select2").select2({
                    theme: "bootstrap-5",
                    placeholder: 'Type to find quickly',
                });

                $('.select2').on('select2:select', function (e) {
                    var data = e.params.data;
                    console.log(data);
                });

                $('.mobile').focusin(function(event) {
                    // console.log($(this))
                    if ($(this).val() == '') {
                        $(this).val('+88')
                    }
                });

                $('.mobile').focusout(function(event) {
                    // console.log($(this))
                    if ($(this).val() == '+88') {
                        $(this).val('')
                    }
                });

                $('form.checkout-form').find('select[name="shipping_city"]').change(function(event) {
                    let city = $(this).val();
                    // let csrf = $('meta[name="csrf-token"]').attr('content');
                    // console.log(city);
                    // console.log(csrf);
                    // return false;
                    $.ajax({
                        url: "{{ route('cart.addshipping', app()->getLocale()) }}",
                        type: 'POST',
                        dataType: 'html',
                        data: {city: city},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(response) {
                        $('#minicart_wrapper').html(response)
                        make_toast('Delivery charge has been applied successfully.', "success");
                    })
                    .fail(function(response) {
                        // console.log(response);
                        // console.log("error");
                        make_toast('Delivery charge cannot applied successfully.', "danger");
                    })
                    .always(function(response) {
                        // console.log(response);
                        // console.log("complete");
                    });
                });
                $('#apply_coupon').click(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();

                    $.ajax({
                        url: "{{ route('cart.applycoupon', app()->getLocale()) }}",
                        type: 'GET',
                        dataType: 'html',
                        data: {code: $(this).prev('input').val()},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(response) {
                        if (response != '') {
                            $('#minicart_wrapper').html(response)
                            make_toast('Coupon has been applied successfully.', "success");
                        } else {
                            make_toast('Coupon cannot applied successfully.', "danger");
                        }
                    })
                    .fail(function(response) {
                        make_toast('Coupon cannot applied successfully.', "danger");
                        // console.log(response);
                        // console.log("error");
                    })
                    .always(function(response) {
                        // make_toast('Coupon is applying, please wait!.', "warning");
                        // console.log(response);
                        // console.log("complete");
                    });
                });

                $('section.payment-option').find('label').click(function(event) {
                    event.preventDefault();
                    $(this).closest('section').find('label').removeClass('active');
                    $(this).addClass('active');

                    $(this).closest('section').find('input').removeAttr('checked')
                    $(this).find('input').attr('checked', true)
                });

                $('section.payment-option').find('input:checked').closest('label').addClass('active');

                $('.checkout-form').submit(function(event) {
                    if ($('input[name="accept_tc"]').is(':checked') == false) {
                        $('#simpleModal').find('.modal-title').text('Are you accepting?')
                        $('#simpleModal').find('.modal-body').html('<div class="col-md-12">Do you agree with the <a href="http://www.w3.org">terms and conditions</a></div>')

                        $('#simpleModal').modal('show');

                        return false;
                    }
                    // prepare_phone_data();
                    // return false;
                });
                $('#simpleModal').find('form').submit(function(event) {
                    $('input[name="accept_tc"]').prop('checked', true);
                    $('.checkout-form').submit();
                    return false;
                });
                function prepare_phone_data(selector='.mobile') {
                    $(selector).each(function(index, el) {
                        el_val = $(el).val()
                        console.log(el_val)
                        if (el_val != '') {
                            $(el).val(el_val.split('+88')[1])
                        }
                    });
                }
            })(jQuery);
        });
    </script>
    @endpush
</x-front-layout>