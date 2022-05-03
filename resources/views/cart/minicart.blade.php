
@php
    // dd($cartItems);
$cartItems = getCartItems();
@endphp
@if ($cartItems)
    <table class="cart minicart mb-4">
        <thead>
            <tr>
                <th></th>
                <th>Product</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cartItems as $row)
                <tr id="cart-{{ $row['id'] }}">
                    <td>
                        <a class="capsule text-danger delete" href="{{ route('cart.index').'?remove='.$row['id'] }}"><i class="fas fa-trash"></i></a>
                    </td>
                    <td>
                        @php
                        if (!empty($row['feat_img'])) {
                            $row['feat_img'] = 'http://localhost:8000/admin/assets/images/login/1.jpg';
                        }
                        @endphp
                        <div class="product-info">
                            <p class="item-img m-0 me-2"><img src="{{ $row['feat_img'] }}" alt="{{ $row['name'] }}"></p>
                            <p class="item-title m-0">
                                <strong class="title">{{ $row['name'] }}</strong>
                                <span class="small">@money($row['price']) x {{ $row['quantity'] }}</span>
                            </p>
                        </div>
                        
                    </td>
                    <td>@money(getSubtotal($row['id']))</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="subtotal">
                <td class="st-title" colspan="2">Subtotal</td>
                <td class="st-amount">@money(getSubtotal())</td>
            </tr>
        </tfoot>
    </table>

    <table class="cart minicart charges mb-4 w-100">
    	<thead>
    		<tr>
    			<th colspan="2">Others</th>
    		</tr>
    	</thead>
    	<tfoot>
            <tr>
                <td>Cart Subtotal: </td>
                <td>@money(getSubtotal())</td>
            </tr>
            @php
            $charges = getCharges();
            // dd($charges);
            @endphp
            @if ($charges)
            @foreach ($charges as $charge)
            <tr class="charges">
                <td title="{{ $charge['name'] }}">{{ $charge['name'] }} @if ($charge['id'] == 'coupon') <a href="{{ route('cart.removecoupon') }}" class="text-danger">x</a> @endif</td>
                <td>@money(getChargeAmount($charge['id']))</td>
            </tr>
            @endforeach
            @endif
            {{-- <tr>
                <td>Total Charges</td>
                <td>@money(getChargeAmount())</td>
            </tr> --}}
            <tr class="total">
                <td>Total</td>
                <td>@money(getCartTotal())</td>
            </tr>
    	</tfoot>
    </table>
@else
    <div class="alert alert-warning my-4">The cart is empty.</div>
@endif