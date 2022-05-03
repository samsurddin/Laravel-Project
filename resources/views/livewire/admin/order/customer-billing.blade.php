<div class="col billing order-info">
    <h6 class="overflow-hidden">
        <span class="col-title">Billing</span>
        <span class="float-end btns">
            <a href="#" class="edit btn btn-sm btn-light text-primary" data-target="edit_address" data-alt-target="address"><i data-feather="edit-2"></i> Edit</a>
            <a href="#" class="load_customer_shipping btn btn-sm btn-light text-info" title="Copy from shipping address"><i data-feather="copy"></i></a>
            <a href="#" class="load_customer_shipping btn btn-sm btn-light" title="Load from profile"><i data-feather="repeat"></i></a>
        </span>
    </h6>
    <div class="address">
        <div class="main-address shipping mb-3">
            <p class="mb-1">
                {!! $order['billing_full_address'] !!}
            </p>
            <p class="mb-1">
                <strong>Email address:</strong> <a href="mailto:{{ $order['billing_email'] }}">{{ $order['billing_email'] }}</a>
            </p>
            <p>
                <strong>Phone:</strong> <a href="tel:{{ $order['billing_mobile'] }}">{{ $order['billing_mobile'] }}</a>
            </p>
        </div>
    </div>

    <div class="edit_address">
        <p class="form-field billing_fullname ">
            <label for="billing_fullname">Name</label>
            <input type="text" class="form-control form-control-sm" name="billing_fullname" id="billing_fullname" value="{{ $order['billing_fullname'] }}" placeholder="">
        </p>
        <p class="form-field billing_address ">
            <label for="billing_address">Address</label>
            <textarea class="form-control form-control-sm" name="billing_address" id="billing_address" cols="30" rows="3">{{ $order['billing_address'] }}</textarea>
        </p>
        <p class="form-field billing_city ">
            <label for="billing_city">City</label>
            <select name="billing_city" class="select2 form-select form-select-sm" data-placeholder="Type a city name">
                <option></option>
                {!! $dropdown['billing']['district'] !!}
            </select>
        </p>
        <p class="form-field billing_state ">
            <label for="billing_state">State</label>
            <select name="billing_state" class="select2 form-select form-select-sm" data-placeholder="Type a state name">
                <option></option>
                {!! $dropdown['billing']['division'] !!}
            </select>
        </p>
        <p class="form-field billing_zipcode ">
            <label for="billing_zipcode">Postcode / ZIP</label>
            <select name="billing_zipcode" class="select2 form-select form-select-sm" data-placeholder="Type a postcode or area name">
                <option></option>
                {!! $dropdown['billing']['postcode'] !!}
            </select>
        </p>
        <p class=" form-field billing_country">
            <label for="billing_country">Country / Region</label>
            <input type="text" name="billing_country" class="form-control form-control-sm" placeholder="Write your country" value="Bangladesh" disabled>
        </p>
        <p class="form-field billing_email ">
            <label for="billing_email">Email address</label>
            <input type="text" class="form-control form-control-sm" style="" name="billing_email" id="billing_email" value="{{ $order['billing_email'] }}" placeholder="">
        </p>
        <p class="form-field billing_mobile ">
            <label for="billing_mobile">Phone</label>
            <input type="text" class="form-control form-control-sm" style="" name="billing_mobile" id="billing_mobile" value="{{ $order['billing_mobile'] }}" placeholder="">
        </p>
    </div>
</div>
