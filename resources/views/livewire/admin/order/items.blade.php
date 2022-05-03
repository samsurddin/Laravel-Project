<div class="order_items border-top pt-4">
    <h6 class="text-center">
        <span class="col-title">Purchased Items</span>
    </h6>

    <table cellpadding="0" cellspacing="0" class="table table-hover">
        <thead>
            <tr>
                <th class="item sortable" colspan="2" data-sort="string-ins">Item</th>
                <th class="item_cost sortable" data-sort="float">Cost</th>
                <th class="quantity sortable" data-sort="int">Qty</th>
                <th class="line_cost sortable" data-sort="float">Total</th>
            </tr>
        </thead>

        @php
            // dd($order['items']);
        @endphp
        <tbody id="order_line_items">
            @foreach ($order['items'] as $item)
            <tr class="item " data-order_item_id="25">
                <td class="thumb" width="50">
                    <div class="order-item-thumbnail">
                        @php
                            $item['thumb'] = "https://images.unsplash.com/photo-1636743716922-1884c23fb6f6?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=50&h=50&q=80";
                        @endphp
                        
                        <img src="{{ $item['thumb'] }}" class="attachment-thumbnail size-thumbnail" alt="{{ $item['name'] }}" loading="lazy" title="{{ $item['name'] }}">
                    </div>
                </td>
                <td class="name" data-sort-value="{{ $item['name'] }}">
                    <a href="{{ route('admin.products.edit', $item['product_id']) }}" class="order-item-name" title="Click to edit product">{{ $item['name'] }}</a>
                    @if (!empty($item['sale_price']))
                    <div class="order-item-sku">
                        <strong>Regular Price:</strong> <del>@money_tag($item['regular_price'])</del>
                    </div>
                    @endif
                </td>

                <td class="item_cost" width="1%" data-sort-value="498">
                    <div class="view">
                        <span class="price-amount amount">
                            @money_tag($item['sale_price'])
                        </span>
                    </div>
                </td>
                <td class="quantity">
                    <div class="view">
                        <small class="times">×</small> {{ $item['quantity'] }}
                    </div>
                    <div class="edit" style="display: none;">
                        <input type="number" step="1" min="0" autocomplete="off" name="order_item_qty[25]" placeholder="0" value="2" data-qty="2" size="4" class="quantity">
                    </div>
                    <div class="refund" style="display: none;">
                        <input type="number" step="1" min="0" max="2" autocomplete="off" name="refund_order_item_qty[25]" placeholder="0" size="4" class="refund_order_item_qty">
                    </div>
                </td>
                <td class="line_cost" data-sort-value="996">
                    <div class="view">
                        <span class="price-amount amount">
                            @php
                                $item_sub_total = $item['sale_price'] * $item['quantity']
                            @endphp
                            @money_tag($item_sub_total)
                        </span>
                    </div>
                    <div class="edit" style="display: none;">
                        <div class="split-input">
                            <div class="input">
                                <label>Before discount</label>
                                <input type="text" name="line_subtotal[25]" placeholder="0" value="996" class="line_subtotal input_price" data-subtotal="996">
                            </div>
                            <div class="input">
                                <label>Total</label>
                                <input type="text" name="line_total[25]" placeholder="0" value="996" class="line_total input_price" data-tip="After pre-tax discounts." data-total="996">
                            </div>
                        </div>
                    </div>
                    <div class="refund" style="display: none;">
                        <input type="text" name="refund_line_total[25]" placeholder="0" class="refund_line_total input_price">
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

        @php
            // dd($order['charges']);
            // dd(json_decode($order['charges']));
            $tax = '';
            $discount = '';
            $shipping = '';
            foreach ($order['charges'] as $charge) {
                $calculateCharge = calculateCharge($charge->amount, $charge->amount_type, $order['sub_total']);
                // if ($charge->type == 'tax') {
                    $tax .= '<tr class="'.$charge->type.'">';
                        $tax .= '<td class="name text-end" colspan="2">';
                            $tax .= '<div class="view">';
                                $tax .= $charge->name;
                            $tax .= '</div>';
                        $tax .= '</td>';
                        $tax .= '<td class="line_cost" colspan="3">';
                            $tax .= '<div class="view">';
                                $tax .= '<span class="price-amount amount">';
                                    // $tax .= @money_tag($calculateCharge);
                                    $tax .= '<bdi><span class=\"price-currency-symbol\">৳&nbsp;</span>' . number_format($calculateCharge, 0) . '</bdi>';
                                $tax .= '</span>';
                            $tax .= '</div>';
                        $tax .= '</td>';
                    $tax .= '</tr>';
                // }
            }
        @endphp
        <tbody id="order_fee_line_items">
            {!! $tax !!}
        </tbody>

        <tfoot>
            <tr>
                <td class="total" colspan="2">
                    Total:
                </td>
                <td class="grand_total amount" colspan="3">
                    @money_tag($order['grand_total'])
                </td>
            </tr>
        </tfoot>
    </table>
</div>