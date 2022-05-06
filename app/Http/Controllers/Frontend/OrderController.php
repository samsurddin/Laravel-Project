<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Order;
use Illuminate\Http\Request;
use App\Rules\PhoneNumber;
// use App\Actions\Fortify\CreateNewUser;
use App\Models\Tenant\Postcode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(site_url());
        // dd(env('APP_URL'));
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
    public function store($lang, Request $request)
    {
        // dd($request->all());
        // dd(getCartItems());
        $cartItems = getCartItems();
        if (!$cartItems) {
            return back()->with('error', 'Your cart is empty, please add product first.');
        }
        $charges = getCharges();

        $order_data = $request->validate([
            "shipping_fullname" => ['required', 'string', 'max:255'],
            "shipping_mobile" => ['required', new PhoneNumber, 'max:15', 'min:11'],
            "shipping_email" => ['nullable', 'string', 'email', 'max:255'],
            "shipping_address" => ['required', 'string', 'max:255'],
            // "shipping_state" => ['required', 'numeric'],
            // "shipping_city" => ['required', 'numeric'],
            "shipping_zipcode" => ['required', 'numeric'],
            "shipping_alt_contact" => ['nullable', 'string', 'max:255'],
            "shipping_alt_mobile" => ['nullable', 'required_with:shipping_alt_contact', new PhoneNumber, 'max:15', 'min:11'],
            "shipping_note" => ['nullable', 'string', 'max:255'],
            
            "has_billing_info" => ['required', 'string'],
            "billing_fullname" => ['nullable', 'required_if:has_billing_info,yes', 'string', 'max:255'],
            "billing_mobile" => ['nullable', 'required_if:has_billing_info,yes', new PhoneNumber, 'max:15', 'min:11'],
            "billing_email" => ['nullable', 'string', 'email', 'max:255'],
            "billing_address" => ['nullable', 'required_if:has_billing_info,yes', 'string', 'max:255'],
            // "billing_state" => ['nullable', 'required_if:has_billing_info,yes', 'numeric'],
            // "billing_city" => ['nullable', 'required_if:has_billing_info,yes', 'numeric'],
            "billing_zipcode" => ['nullable', 'required_if:has_billing_info,yes', 'numeric'],
            "coupon_code" => ['nullable', 'string'],
            "payment_method" => ['required'],
            "accept_tc" => ['required', 'accepted'],
        ]);

        $shipping_zip_info = Postcode::where('postCode', $request['shipping_zipcode'])->first();
        // $shipping_zip_info = Postcode::where('postCode', $request['shipping_zipcode'])->with(['district', 'division'])->first();
        // dd($shipping_zip_info->district->id);

        if (is_null($shipping_zip_info)) {
            return back()->with('error', 'Invalid Zipcode! Can not completed the order. Please contact authority.');
        }
        $order_data['shipping_state'] = $shipping_zip_info->division_id;
        $order_data['shipping_city'] = $shipping_zip_info->district_id;
        
        
        $billing_zipcode = $request['billing_zipcode']??$request['shipping_zipcode'];
        
        $billing_zip_info = Postcode::where('postCode', $billing_zipcode)->first();
        $order_data['billing_state'] = $billing_zip_info->division_id;
        $order_data['billing_city'] = $billing_zip_info->district_id;

        $user = auth()->user();
        if (!$user) {
            // $new_user_info = [
            //     'name' => $request['shipping_fullname'],
            //     'email' => $request['shipping_email'],
            //     'password' => $request['password'],
            //     'password_confirmation' => $request['password_confirmation'],
            //     'billing_mobile' => $request['billing_mobile']??$request['shipping_mobile'],
            //     'billing_address' => $request['billing_address']??$request['shipping_address'],
            //     'billing_state' => $shipping_zip_info->division_id,
            //     'billing_city' => $shipping_zip_info->district_id,
            //     'billing_zipcode' => $request['billing_zipcode']??$request['shipping_zipcode']
            // ];
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'billing_mobile' => $request['billing_mobile']??$request['shipping_mobile'],
                'billing_address' => $request['billing_address']??$request['shipping_address'],
                'billing_state' => $shipping_zip_info->division_id,
                'billing_city' => $shipping_zip_info->district_id,
                'billing_zipcode' => $request['billing_zipcode']??$request['shipping_zipcode']
            ]);
    
            event(new Registered($user));

            // $CreateNewUser = new CreateNewUser();
            // $user = $CreateNewUser->create($new_user_info);
            // $user->roles()->attach(4);
            auth()->login($user, true);
        }

        if ($request['has_billing_info'] != 'yes') {
            $billing_data = [
                'billing_fullname' => $request['shipping_fullname'],
                'billing_mobile' => $request['shipping_mobile'],
                'billing_email' => $request['shipping_email'],
                'billing_address' => $request['shipping_address'],
                'billing_zipcode' => $request['shipping_zipcode']
            ];
            $order_data = array_merge($order_data, $billing_data);
        }

        if ($charges) {
            // $order_data['charges'] = json_encode($charges);
            $order_data['charges'] = json_encode($charges);
        }

        // $order_data['order_number'] = $user->id .'-'. abs( crc32( uniqid() ) ) . "-".date('y') . date('m');
        $order_data['order_number'] = abs( crc32( uniqid() ) ) . '-' . date('dHis');
        // dd($order_data['order_number']);
        $order_data['user_id'] = $user->id;
        $order_data['grand_total'] = getCartTotal();
        $order_data['sub_total'] = getSubtotal();
        $order_data['total_charges'] = getChargeAmount();
        $order_data['item_count'] = getTotalQuantity();
        // $order_data['is_paid'] = false;
        $order_data['ip_address'] = $request->ip();
        $order_data['mac'] = substr(exec('getmac'), 0, 17);
        // $order_data['mac'] = exec('getmac');
        // $order_data['mac_substr'] = substr(exec('getmac'), 0, 17);
        // $order_data['mac_shell_exec'] = shell_exec('getmac');
        // $order_data['mac_substr_shell'] = substr(shell_exec('getmac'), 159,20);
        // $order_data['coupon_id'] = 1;
        // $order_data['status_id'] = 1;

        $order_data['status'] = 'Processing';
        $order_data['status_id'] = 3;
        $tracking_data = [ // 3 = Awaiting Fulfillment
            'note'=> 'Order created successfully, preparing for shipment.',
            'show_on_tracking'=> true,
        ];

        if ($order_data['payment_method'] != 'cash_on_delivery') {
            $order_data['status'] = 'Pending payment';
            $order_data['status_id'] = 1;
            $tracking_data = [ // 3 = Pending
                'note'=> 'Order created, pending for payment.',
                'show_on_tracking'=> true,
            ];
        }

        // dd($order_data, $tracking_data);

        $order = Order::create($order_data);

        foreach($cartItems as $item) {
            $order->order_items()->attach($item['id'], [
                'name'=> $item['name'],
                'thumb'=> $item['feat_img'],
                'regular_price'=> $item['regular_price'],
                'sale_price'=> $item['sale_price'],
                'quantity'=> $item['quantity'],
                'price'=> $item['price'],
                'item_total'=> getSubtotal($item['id'])
            ]);
        }

        $order->tracking()->attach($order_data['status_id'], $tracking_data);

        // $order->generateSubOrders();
        // if (request('payment_method') == 'paypal') {
        //     return redirect()->route('paypal.checkout', $order->id);
        // }

        cart_clear();

        // OrderPlaced::dispatch($order);
        // Mail::to($request->user())->send(new OrderPlacedMail($order));

        return redirect()->route('shop.index', app()->getLocale())->withMessage('Order has been placed');
    }

    private function order_created(Order $order)
    {
        dd($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Order $order)
    {
        //
    }

    /**
     * Create invoice for the specified order.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    // public function invoice(Order $order)
    public function invoice()
    {
        $client = new Party([
            'name'          => 'Roosevelt Lloyd',
            'phone'         => '(520) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Ashley Medina',
            'address'       => 'The Green Street 12',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);

        $items = [
            (new InvoiceItem())->title('Service 1')->description('additional text')->pricePerUnit(47.79)->quantity(2)->discount(10),
            (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
            (new InvoiceItem())->title('Service 3')->pricePerUnit(4.56),
            (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
            (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            (new InvoiceItem())->title('Service 6')->pricePerUnit(76.32)->quantity(9),
            (new InvoiceItem())->title('Service 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
            (new InvoiceItem())->title('Service 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
            (new InvoiceItem())->title('Service 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
            (new InvoiceItem())->title('Service 11')->pricePerUnit(97.45)->quantity(2),
            (new InvoiceItem())->title('Service 12')->pricePerUnit(92.82),
            (new InvoiceItem())->title('Service 13')->pricePerUnit(12.98),
            (new InvoiceItem())->title('Service 14')->pricePerUnit(160)->units('hours'),
            (new InvoiceItem())->title('Service 15')->pricePerUnit(62.21)->discountByPercent(5),
            (new InvoiceItem())->title('Service 16')->pricePerUnit(2.80),
            (new InvoiceItem())->title('Service 17')->pricePerUnit(56.21),
            (new InvoiceItem())->title('Service 18')->pricePerUnit(66.81)->discountByPercent(8),
            (new InvoiceItem())->title('Service 19')->pricePerUnit(76.37),
            (new InvoiceItem())->title('Service 20')->pricePerUnit(55.80),
        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('receipt')
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->status('Paid')
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('invoice');
            // ->stream();

        // $link = $invoice->url();
        // Then send email to party with link
        // dd($link);

        // And return invoice itself to browser or have a different view
        // return $invoice;
        return $invoice->stream();
    }
}
