<div class="note-block">
    <div class="notes">
        <h6 class="overflow-hidden">
            <span class="col-title">Notes</span>
            {{-- <span class="float-end btns show-toggle">
                <a href="#" class="edit btn btn-sm btn-light text-primary"><i data-feather="edit-2"></i> Edit</a>
                <a href="#" class="load_customer_shipping btn btn-sm btn-light text-info" title="Copy from shipping address"><i data-feather="copy"></i></a>
                <a href="#" class="load_customer_shipping btn btn-sm btn-light text-success" title="Reload order data"><i data-feather="refresh-cw"></i> Reload</a>
            </span> --}}
        </h6>

        @php
        // dd($order['notes']);

        if (!empty($order['notes'])) {
            $count = count($order['notes']);
            $notes_html = '';
            for ($i = 0; $i < $count; $i++) {
                $notes = $order['notes'][$i];
                if ($i>3) {
                    $notes_html .= '<div class="more-block ajax">';
                        $notes_html .= '<div class="more-contents">';
                }

                $show_publicly = ' &middot; <span class="badge bg-light text-success">Restricted</span>';
                if ($notes['public'] != 0) {
                    $show_publicly = ' &middot; <span class="badge bg-light text-danger">Public</span>';
                }

                $note_by = ' &middot; <span class="badge bg-light text-primary">By admin</span>';
                if ($notes['by_user'] != 0) {
                    $note_by = ' &middot; <span class="badge bg-light text-info">By user</span>';
                }

                $notes_html .= '<div class="note-entry">';
                    $notes_html .= '<span class="float-end btns show-toggle">';
                        $notes_html .= '<a href="#" class="load_customer_shipping btn btn-sm btn-light text-danger" title="Mark as delete"><i data-feather="delete"></i> Delete</a>';
                    $notes_html .= '</span>';

                    $notes_html .= '<p class="meta mb-1">';
                        $notes_html .= '<span class="text-muted">'.date_to_human($notes['date']) .'</span>' . $note_by . $show_publicly;
                    $notes_html .= '</p>';

                    $notes_html .= '<p class="note">';
                        $notes_html .= $notes['note'];
                    $notes_html .= '</p>';
                $notes_html .= '</div>';

                if ($i>3) {
                        $notes_html .= '</div>';
                        $notes_html .= '<p class="more-text"><a href="#">more...</a></p>';
                    $notes_html .= '</div>';
                }
            }
        }
        @endphp

        {!! $notes_html !!}
    </div>

    <div class="add-notes">
        <h6>
            <span class="col-title">Add New Notes</span>
            <span class="float-end btns show-toggle">
                {{-- <a href="#" class="edit btn btn-sm btn-light text-primary"><i data-feather="edit-2"></i> Edit</a>
                <a href="#" class="load_customer_shipping btn btn-sm btn-light text-info" title="Copy from billing address"><i data-feather="copy"></i></a>
                <a href="#" class="load_customer_shipping btn btn-sm btn-light" title="Load from profile"><i data-feather="repeat"></i></a> --}}
                {{-- <a href="#" class="copy_billing_info btn btn-sm btn-light"><i data-feather="repeat"></i> Load shipping address</a> --}}
            </span>
        </h6>
        <div class="edit_address">
            <p class="form-field note ">
                <label for="note_note">Note</label>
                <textarea class="form-control form-control-sm" rows="3" cols="40" name="note" tabindex="6" id="note_note" placeholder="Write your note"></textarea>
            </p>
            <p class=" form-field Date">
                <label for="note_date">Date</label>
                <input type="datetime-local" name="note_date" id="date" class="form-control form-control-sm" placeholder="Pick a date">
                <span class="hint text-muted">Defult: {{ date('m/d/Y H:i A') }}</span>
            </p>
            <div class="form-field billing_email ">
                {{-- <label for="billing_email">Show</label> --}}
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="show_user" name="by_user" checked>
                    <label class="form-check-label" for="show_user">Show to user too</label>
                </div>
            </div>
            <div class="form-field mt-2">
                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
            </div>
        </div>
    </div>
</div>