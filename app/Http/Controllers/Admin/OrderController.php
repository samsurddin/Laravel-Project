<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\PhoneNumber;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\District;
use App\Models\Division;
use App\Models\Postcode;
use App\Models\PaymentMethod;
// use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = Order::with('shipping_city:id,name')->with('latest_status:title')->withCount('items')->paginate(20)->toArray();
        // $orders = Order::with('shipping_city:id,name')->with('latest_status:title')->withCount('items')->paginate(20);
        $orders = Order::withCount('items')->paginate(20);
        // $orders = Order::with('user')->with('items')->withCount('items')->with('status:title')->paginate(20)->toArray();
        // $orders = Order::with('status:title')->get()->toArray();
        // $orders = User::with('orders')->get();
        // dd($orders->toArray());

        return view('admin.orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('user')
                    ->with('items')
                    // ->withCount('items')
                    ->with('tracking')
                    ->with('notes')
                    // ->with('shipping_city:id,name')
                    // ->with('shipping_state:id,name')
                    // ->with('shipping_zipcode:postCode,postOffice')
                    // ->with('billing_city:id,name')
                    // ->with('billing_state:id,name')
                    // ->with('billing_zipcode:postCode,postOffice')
                    // ->find($id);
                    ->find($id)->toArray();
        $statuses = OrderStatus::all()->toArray();
        $order_status_dd = order_status_dd($statuses, $order['status_id']);
        $payment_methods = PaymentMethod::all();
        // $districts = District::all();
        // $divisions = Division::select(['id', 'name'])->with('districts')->get();
        // $postcodes = Postcode::select('postCode', 'postOffice', 'upazila', 'district_id', 'division_id')->with('district:id,name')->with('division:id,name')->get();

        // $divisions = Division::select(['id', 'name'])->with('city_with_postcodes')->get()->toArray();
        // // dd($divisions);

        // $selected = [
        //     'shipping' => [
        //         'division' => old('shipping_state', $order['shipping_state']), 
        //         'district' => old('shipping_city', $order['shipping_city']),
        //         'postcode' => old('shipping_zip', $order['shipping_zipcode']),
        //     ],
        //     'billing' => [
        //         'division' => old('billing_state', $order['billing_state']), 
        //         'district' => old('billing_city', $order['billing_city']),
        //         'postcode' => old('billing_zip', $order['billing_zipcode']),
        //     ]
        // ];

        // $dropdown = location_dd($divisions, $selected);
        $dropdown = make_loc_dd($order);

        // $dropdown['zipcode'] = postcodes_dd($postcodes, $selected);
        // dd($dropdown);
        // dd($order->shipping_state, $order->shipping_city, $order->shipping_zipcode);
        // dd($order, $statuses, $districts, $divisions);
        // dd($order->toArray());
        // dd($order->shipping_full_address);
        // dd($order['shipping_full_address']);
        return view('admin.orders.view', compact('order', 'order_status_dd', 'dropdown', 'payment_methods'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update order status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request, $id)
    {
        //
    }

    /**
     * Update order status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_billing(Request $request, $id)
    {
        $order = Order::find($id);
        if (empty($order)) {
            if (request()->ajax()) {
                return ['error' => 'The order is not found!'];
            }
            return back()->with('error', 'The order is not found!');
        }

        $billing_data = $request->validate([
            "billing_fullname" => ['required', 'string', 'max:255'],
            "billing_address" => ['required', 'string', 'max:255'],
            "billing_city" => ['required', 'numeric'],
            "billing_state" => ['required', 'numeric'],
            "billing_zipcode" => ['required', 'numeric'],
            "billing_email" => ['nullable', 'string', 'email', 'max:255'],
            "billing_mobile" => ['nullable', 'required', new PhoneNumber, 'max:15', 'min:11'],
        ]);

        if ($order->update($billing_data)) {
            $order = Order::find($id)->toArray();
            $dropdown = make_loc_dd($order);
            if (request()->ajax()) {
                return [
                    'event' => 'billing_data_updated', 
                    'success' => true, 
                    'msg' => 'Billing data has been updated.', 
                    'order' => $order, 
                    'form_selector' => '.order-billing .edit_address', 
                    'info_block_selector' => '.order-billing .address',
                    'template_selector' => '.billing.order-info', 
                    'template' => (string) view('admin.orders.parts.billing', compact('order', 'dropdown'))
                ];
            }
            return back()->with('success', 'Billing data has been updated.');
        }



        // return [$id, $request->all()];
    }

    /**
     * Add new tracking for specific order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_tracking(Request $request)
    {
        //
    }

    /**
     * Delete a specific tracking record
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_tracking($id)
    {
        //
    }

    /**
     * Add new note for specific order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_note(Request $request)
    {
        //
    }

    /**
     * Delete a specific note
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_note($id)
    {
        //
    }
}
