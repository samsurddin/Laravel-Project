<div class="col summery order-info">
    <h6 class="overflow-hidden">
        <span class="col-title">Summery</span>
        <span class="float-end btns">
            <a href="#" class="load_customer_shipping btn btn-sm btn-light text-success" title="Reload order data"><i data-feather="refresh-cw"></i> Reload</a>
        </span>
    </h6>

    <p class="order-number">
        Order Number:
        <br><strong>{{ $order['order_number'] }}</strong>
    </p>

    <p class="order-date">
        Date created:
        <br><strong>{{ $order['updated_at'] }}</strong> ({{ $order['updated_at_human'] }})
    </p>

    <p class="customer-user">
        Customer: <a href="#"> View other orders →</a> <a href="#"> Profile →</a>
        <br><strong>{{ $order['user']['name'] }} (#{{ $order['user']['id'] }} &ndash; {{ $order['user']['email'] }})</strong>
    </p>

    <p class="form-field form-field-wide order-status">
        <label for="order_status">
            Status:
        </label>
        <select id="order_status" name="order_status" class="form-select form-select-sm" tabindex="-1" aria-hidden="true">
            {!! $order_status_dd !!}
        </select>
    </p>

    <p class="form-field form-field-wide">
        <label>Payment method:</label>
        <select name="payment_method" id="payment_method" class="form-select form-select-sm">
            <option value="">N/A</option>
            @foreach ($payment_methods as $pm)
                <option value="{{ $pm->id }}" @if ($pm->unique_key == $order['payment_method']) selected="selected" @endif>{{ $pm->name }}</option>
            @endforeach
        </select>
    </p>

    <div class="more-block">
        <div class="more-contents">
            <p class="order-date">
                Total Products:
                <br><strong>{{ count($order['items']) }}</strong>
            </p>

            <p class="order-date">
                Total Quantity:
                <br><strong>{{ $order['item_count'] }}</strong>
            </p>

            <p class="order-date">
                Total Amount:
                <br><strong>@money_tag($order['grand_total'])</strong>
            </p>
        </div>
        <p class="more-text"><a href="#">more...</a></p>
    </div>
</div>
