<x-front-layout>
    <section class="section-header py-4 wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @php
                        // $images = $product->images;
                        // dd($product->specifications()->get())
                        // dd($images)
                    @endphp
                    <!-- <h1 class="section-title">
                        Lenovo Ideapad 320 Core i3 Laptop
                    </h1> -->
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Shop</a></li>
                            <li class="breadcrumb-item"><a href="#">Consumer Electrics</a></li>
                            <li class="breadcrumb-item"><a href="#">Audios & Theaters</a></li>
                            <li class="breadcrumb-item"><a href="#">Headphone</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="cart-wrapper bg-white py-4 wrapper">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-lg-8">
                    <h1 class="page-title text-center">Cart</h1>
                </div>
                <div class="col-lg-10">
                    <div class="alert-box my-4">
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
                    @php
                        // dd($cartItems);
                    $cartItems = getCartItems();
                    @endphp
                    @if ($cartItems)
                        <table class="cart w-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cartItems as $row)
                                @php
                                    // dd($row)
                                @endphp
                                    <tr id="cart-{{ $row['id'] }}">
                                        <td>
                                            <a class="btn btn-light btn-sm text-danger delete" href="{{ route('cart.index').'?remove='.$row['id'] }}"><i class="fas fa-trash"></i></a>
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
                                                    @if (!empty($row['sale_price']))
                                                        <span class="ragular-price">Ragular Price: <del>@money($row['regular_price'])</del></span>
                                                    @endif
                                                </p>
                                            </div>
                                            
                                        </td>
                                        <td>@money($row['price'])</td>
                                        <td width="130px">
                                            <form action="{{ route('cart.update', $row['id']) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="qty-input">
                                                    <span class="qty-btn qty_minus">-</span>
                                                    <input class="form-control" type="text" value="{{ $row['quantity'] }}" name="quantity" qty="{{ $row['quantity'] }}">
                                                    <span class="qty-btn qty_plus">+</span>
                                                </div>
                                                <button class="btn btn-light btn-sm text-success edit qty-update" type="submit"><i class="fas fa-check"></i></button>
                                            </form>
                                        </td>
                                        <td>@money(getSubtotal($row['id']))</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="subtotal">
                                    <td colspan="2">&nbsp;</td>
                                    <td class="st-title" colspan="2">Subtotal</td>
                                    <td class="st-amount">@money(getSubtotal())</td>
                                </tr>
                                @php
                                    $charges = getCharges();
                                @endphp
                                {{-- {{ dd(getCharges()) }} --}}
                                @if ($charges)
                                    @foreach ($charges as $charge)
                                    <tr class="charges">
                                        <td colspan="2">&nbsp;</td>
                                        <td title="{{ $charge['name'] }}" colspan="2">{{ $charge['name'] }}</td>
                                        {{-- <td>@money(getChargeAmount($charge['id']))</td> --}}
                                        <td>@money(getChargeAmount($charge['id']))</td>
                                    </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2">Total Charges</td>
                                    <td>@money(getChargeAmount())</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2">Total</td>
                                    <td>@money(getCartTotal())</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="checkout-btn text-end my-5">
                            <a href="{{route('cart.checkout')}}" class="btn tz-info">Proceed to checkout <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
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
    <style>

    </style>
    @endpush

    @push('script')
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            (function($) {
                $('.qty-input').on('click', '.qty-btn', function(event) {
                    event.preventDefault();
                    let current_val = parseInt($(this).parent().find('input').val());

                    let new_val = current_val;
                    if ($(this).is('.qty_plus')) {
                        new_val++
                    } else {
                        if (new_val > 1) {
                            new_val--;
                        }
                    }
                    $(this).parent().find('input').val(new_val);

                    let old_qty = $(this).parent().find('input').attr('qty')
                    if(new_val == old_qty) {
                        $(this).closest('form').find('button').css('opacity', 0);
                    } else {
                        $(this).closest('form').find('button').css('opacity', 1);
                    }
                });
            })(jQuery);
        });
    </script>
    @endpush
</x-front-layout>