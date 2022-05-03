<div class="order-shipping">
    <h6>
        <span class="col-title">Shipping</span>
        <span class="float-end btns show-toggle">
            <a href="#" class="edit btn btn-sm btn-light text-primary" data-target="edit_address" data-alt-target="address" data-text="Edit" data-alt-text="Cancel" data-class="text-primary" data-alt-class="text-danger" data-icon="edit-2" data-alt-icon="slash"><i data-feather="edit-2"></i> Edit</a>
            <a href="#" class="load_customer_shipping btn btn-sm btn-light text-info" title="Copy from billing address"><i data-feather="copy"></i></a>
            <a href="#" class="load_customer_shipping btn btn-sm btn-light" title="Load from profile"><i data-feather="repeat"></i></a>
            {{-- <a href="#" class="copy_billing_info btn btn-sm btn-light"><i data-feather="repeat"></i> Load shipping address</a> --}}
        </span>
    </h6>
    <div class="address">
        <div class="main-address shipping mb-3">
            <p class="mb-1">
                {!! $order['shipping_full_address'] !!}
            </p>
            <p class="mb-1">
                <strong>Email address:</strong> <a href="mailto:{{ $order['shipping_email'] }}">{{ $order['shipping_email'] }}</a>
            </p>
            <p>
                <strong>Phone:</strong> <a href="tel:{{ $order['shipping_mobile'] }}">{{ $order['shipping_mobile'] }}</a>
            </p>
        </div>
        <div class="alt-address shipping mb-3">
            <p class="mb-1">
                <strong>Alt. Contact:</strong> <br>
                {{ $order['shipping_alt_contact'] }}
            </p>
            <p>
                <strong>Alt. Mobile:</strong> <br>
                {{ $order['shipping_alt_mobile'] }}
            </p>
        </div>
    </div>
    <div class="edit_address">
        <p class="form-field shipping_fullname ">
            <label for="shipping_fullname">Name</label>
            <input type="text" class="form-control form-control-sm" style="" name="shipping_fullname" id="shipping_fullname" value="{{ $order['shipping_fullname'] }}" placeholder="">
        </p>
        <p class="form-field shipping_address ">
            <label for="shipping_address">Address</label>
            <textarea class="form-control form-control-sm" name="shipping_address" id="shipping_address" cols="30" rows="3">{{ $order['shipping_address'] }}</textarea>
        </p>
        <p class="form-field shipping_city ">
            <label for="shipping_city">City</label>
            <select name="shipping_city" class="select2 form-select form-select-sm" data-placeholder="Type a city name">
                <option></option>
                {!! $dropdown['shipping']['district'] !!}
            </select>
        </p>
        <p class="form-field shipping_state ">
            <label for="shipping_state">State</label>
            <select name="shipping_state" class="select2 form-select form-select-sm" data-placeholder="Type a state name">
                <option></option>
                {!! $dropdown['shipping']['division'] !!}
            </select>
        </p>
        <p class="form-field shipping_zipcode ">
            <label for="shipping_zipcode">Postcode / ZIP</label>
            <select name="shipping_zipcode" class="select2 form-select form-select-sm" data-placeholder="Type a postcode or area name">
                <option></option>
                {!! $dropdown['shipping']['postcode'] !!}
            </select>
        </p>
        <p class=" form-field shipping_country">
            <label for="shipping_country">Country / Region</label>
            <input type="text" name="shipping_country" class="form-control form-control-sm" placeholder="Write your country" value="Bangladesh" disabled>
        </p>
        <p class="form-field billing_email ">
            <label for="billing_email">Email address</label>
            <input type="text" class="form-control form-control-sm" style="" name="billing_email" id="billing_email" value="{{ $order['billing_email'] }}" placeholder="">
        </p>
        <p class="form-field billing_mobile ">
            <label for="billing_mobile">Phone</label>
            <input type="text" class="form-control form-control-sm" style="" name="billing_mobile" id="billing_mobile" value="{{ $order['billing_mobile'] }}" placeholder="">
        </p>
        <p class="form-field form-field-wide">
            <label for="excerpt">Customer provided note:</label>
            <textarea class="form-control form-control-sm" rows="3" cols="40" name="excerpt" tabindex="6" id="excerpt" placeholder="Customer notes about the order">{{ $order['shipping_note'] }}
            </textarea>
        </p>
        <p class="form-field">
            <input type="submit" class="btn btn-primary btn-sm w-100" value="Submit">
        </p>
    </div>
</div>