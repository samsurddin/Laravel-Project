<div class="tracking-block">
    <div class="tracking">
        <h6 class="overflow-hidden">
            <span class="col-title">Tracking</span>
        </h6>

        @php
        if (!empty($order['tracking'])) {
            $count = count($order['tracking']);
            $tracking_html = '';
            for ($i = 0; $i < $count; $i++) {
                $tracking = $order['tracking'][$i]['pivot'];
                if ($i>3) {
                    $tracking_html .= '<div class="more-block ajax">';
                        $tracking_html .= '<div class="more-contents">';
                }

                $show_tracking = ' &middot; <span class="badge bg-light text-success">Showing</span>';
                if ($tracking['show_on_tracking'] != 0) {
                    $show_tracking = ' &middot; <span class="badge bg-light text-danger">Hidden</span>';
                }

                $tracking_html .= '<div class="note-entry">';
                    $tracking_html .= '<span class="float-end btns show-toggle">';
                        $tracking_html .= '<a href="#" class="load_customer_shipping btn btn-sm btn-light text-danger" title="Mark as delete"><i data-feather="delete"></i> Delete</a>';
                    $tracking_html .= '</span>';

                    $tracking_html .= '<p class="meta mb-1">';
                        $tracking_html .= '<span class="text-muted">'.date_to_human($tracking['updated_at']) .'</span> &middot; <span class="badge bg-primary">'. $order['tracking'][$i]['title'] .'</span>' . $show_tracking;
                    $tracking_html .= '</p>';

                    $tracking_html .= '<p class="note">';
                        $tracking_html .= '<strong>Date: </strong> ';
                        $tracking_html .= show_date($tracking['date'], 'd M Y') . '<br>';

                        $tracking_html .= '<strong>Note: </strong> ';
                        $tracking_html .= $tracking['note'];
                    $tracking_html .= '</p>';
                $tracking_html .= '</div>';

                if ($i>3) {
                        $tracking_html .= '</div>';
                        $tracking_html .= '<p class="more-text"><a href="#">more...</a></p>';
                    $tracking_html .= '</div>';
                }
            }
        }
        @endphp

        {!! $tracking_html !!}
    </div>

    <div class="add-tracking mt-3">
        <h6>
            <span class="col-title">Add New Tracking</span>
        </h6>
        <div class="edit_address">
            <p class="form-field tracking_status ">
                <label for="tracking_status">Tracking Status</label>
                @if (isset($order_status_dd) && !empty($order_status_dd))
                    <select id="tracking_status" name="tracking_status" class="form-select form-select-sm">
                        {!! $order_status_dd !!}
                    </select>
                @endif
            </p>
            <p class="form-field tracking_note ">
                <label for="tracking_note">Tracking Note</label>
                <textarea class="form-control form-control-sm" rows="3" cols="40" name="tracking_note" tabindex="6" id="tracking_note" placeholder="Write your tracking note"></textarea>
            </p>
            <p class=" form-field tracking_date">
                <label for="tracking_date">Date</label>
                <input type="datetime-local" name="tracking_date" id="tracking_date" class="form-control form-control-sm" placeholder="Pick a date">
                <span class="hint text-muted">Defult: {{ date('m/d/Y H:i A') }}</span>
            </p>
            <div class="form-field billing_email ">
                {{-- <label for="billing_email">Show</label> --}}
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="tracking_show" name="tracking_show" checked>
                    <label class="form-check-label" for="tracking_show">Restrict</label>
                </div>
            </div>
            <div class="form-field mt-2">
                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
            </div>
        </div>
    </div>
</div>