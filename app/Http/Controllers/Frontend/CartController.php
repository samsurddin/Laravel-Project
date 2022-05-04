<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Product;
use App\Models\Tenant\Division;
use App\Models\Tenant\District;
use App\Models\Tenant\Postcode;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->get('add-to-cart'))) {
            $pid = $request->get('add-to-cart');
            $this->addToCart($pid);

            return back()->with('success', 'You product is successfully added to the cart.');
        }
        if (!empty($request->get('remove'))) {
            $this->removeItems($request->get('remove'));
            return back()->with('success', 'You product has been removed from cart.');
        }
        return view('cart.cart');
    }

    public function addToCart($pid, $qty=1)
    {
        $product = Product::where('id', $pid)->get(['id', 'name', 'regular_price', 'sale_price', 'featured_img'])->first();
        // dd($product);
        if (empty($product)) {
            return redirect('shop');
        }
        if ($this->updateQty($pid, $qty)) {
            return back()->with('success', 'You product is successfully updated to the cart.');
        }

        $items = [
            'id' => $product->id, // inique row ID
            'name' => $product->name,
            'regular_price' => $product->regular_price,
            'price' => empty($product->sale_price)?$product->regular_price:$product->sale_price,
            'quantity' => $qty,
            'feat_img' => $product->featured_img,
            'sale_price' => $product->sale_price,
            // 'associatedModel' => $product
        ];

        $old_items = getCartItems();
        $old_items[$product->id] = $items;
        
        start_session();
        $_SESSION['items'] = $old_items;

        $this->addDefaultCharges();
        return true;
    }

    private function updateQty($pid, $qty, $replace=false)
    {
        $items = getCartItems();
        // dd(isExist($pid));
        if (isExist($pid)) {
            if ($replace) {
                $_SESSION['items'][$pid]['quantity'] = $qty;
                return true;
            }
            $existQty = $_SESSION['items'][$pid]['quantity'];
            $_SESSION['items'][$pid]['quantity'] = $existQty + $qty;
            return true;
        }
        return false;
    }

    public function addCharge($charge=[], $chargeId=NULL)
    {
        if (empty($charge)) {
            $charge = $this->getDefaultCharges();
        }

        start_session();
        $old_charge = getCharges();
        if ($old_charge) {
            // echo '<pre>';
            // print_r($old_charge);
            if (is_null($chargeId)) {
                $old_charge = array_merge($old_charge, $charge);
            } else $old_charge[$chargeId] = $charge;
            // print_r($old_charge);
            // echo '</pre>';
            // exit;
            $_SESSION['charges'] = $old_charge;
        } elseif (!is_null($chargeId)) {
            $_SESSION['charges'][$chargeId] = $charge;
        } else {
            $_SESSION['charges'] = $charge;
        }
    }

    private function addDefaultCharges()
    {
        if (getCharges()) {
            return false;
        }
        $this->addCharge();
    }

    private function getDefaultCharges()
    {
        return [
            'vat-15' => [
                'id' => 'vat-15',
                'name' => 'VAT 15%',
                'type' => 'tax',
                'amount' => '15',
                'amount_type' => 'percent',
                'target' => 'subtotal',
            ],
            'delivery' => [
                'id' => 'delivery',
                'name' => 'Delivery (Inside Dhaka)',
                'type' => 'shipping',
                'amount' => '40',
                'amount_type' => 'plus',
            ]
        ];
    }

    public function removeCharge($chargeId=NULL)
    {
        start_session();
        if (is_null($chargeId)) {
            unset($_SESSION['charges']);
        } else unset($_SESSION['charges'][$chargeId]);
    }

    private function removeItems($pid=NULL)
    {
        start_session();
        if (empty($pid)) {
            unset($_SESSION['items']);
        } else {
            unset($_SESSION['items'][$pid]);
        }
    }

    public function applyCoupon(Request $request)
    {
        // echo 'hello';
        // dd($request->get('code'));
        $code = $request->get('code');
        if (empty($code)) {
            return false;
        }
        $coupon = [
            'id' => 'coupon',
            'name' => 'Coupon ('.$code.')',
            'type' => 'promo',
            'amount' => '10',
            'amount_type' => 'percent',
            'target' => 'subtotal',
            'extra' => [
                'coupon_code' => $code
            ]
        ];
        $this->addCharge($coupon, 'coupon');

        if (request()->ajax()) {
            return view('cart.minicart');    
        }
        return back()->with('success', 'Coupon has been applied successfully.');
    }

    public function removeCoupon(Request $request)
    {
        $this->removeCharge('coupon');

        if (request()->ajax()) {
            return view('cart.minicart');    
        }
        return back()->with('success', 'Coupon has been removed successfully.');
    }

    public function checkout(Request $request)
    {
        // $this->removeCharge();
        // exit;
        
        $user = auth()->user();
        // dd($user);
        $selected = ['division' => '', 'district' => ''];
        $user_info = [
            'name' => '',
            'email' => '',
            'billing_mobile' => '',
            'billing_address' => '',
            'billing_state' => '',
            'billing_city' => '',
            'billing_zipcode' => '',
            'billing_country' => 'Bangladesh',
        ];
        if ($user) {
            $selected = [
                'division' => $user->billing_state, 
                'district' => $user->billing_city
            ];

            $user_info = [
                'name' => $user->name,
                'email' => $user->email,
                'billing_mobile' => $user->billing_mobile,
                'billing_address' => $user->billing_address,
                'billing_state' => $user->billing_state,
                'billing_city' => $user->billing_city,
                'billing_zipcode' => $user->billing_zipcode,
                'billing_country' => 'Bangladesh',
            ];
            $this->addDeliveryCharge($request, $user->billing_city);
        }

        $selected = [
            'division' => old('shipping_state', $selected['division']), 
            'district' => old('shipping_city', $selected['district'])
        ];
        // dd($selected);

        $loc_data['divisions'] = Division::select(['id', 'name'])->with('districts')->get()->toArray();
        $loc_data['districts'] = District::get(['id', 'name'])->toArray();

        // $districts = [];
        // foreach ($loc_data['districts'] as $dis) {
        //     $districts[] = $dis['name'];
        // }
        // dd($districts, $loc_data['districts']);
        // dd(array_count_values($districts));

        // $loc_data['postcodes'] = Postcode::select('postCode', 'upazila', 'district_id', 'division_id')->with('district:id,name')->with('division')->first()->toArray();
        // $loc_data['postcodes'] = Postcode::select('postCode', 'postOffice', 'upazila', 'district_id', 'division_id')->with('district:id,name')->with('division:id,name')->get()->groupBy('district_id')->toArray();
        $loc_data['postcodes'] = Postcode::select('postCode', 'postOffice', 'upazila', 'district_id', 'division_id')->with('district:id,name')->with('division:id,name')->get()->toArray();
        // dd($loc_data);
        $dropdown = mk_loc_dd($loc_data['divisions'], $selected);

        return view('cart.checkout', compact('loc_data', 'user', 'user_info', 'dropdown'));
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
        $validated = $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'numeric|min:1',
        ]);
        // dd($validated);
        $this->addToCart($validated['product_id'], $validated['quantity']);

        return back()->with('success', 'You product is successfully added to the cart.');
    }

    public function addDeliveryCharge(Request $request, $city='1')
    {
        if (empty($request['city'])) {
            $request['city'] = $city;
        }
        if (is_numeric((int) $request['city']) && $request['city'] > 0) {
            $shipping = [
                'id' => 'delivery',
                'name' => 'Delivery (Inside Dhaka)',
                'type' => 'shipping',
                'amount' => '40',
                'amount_type' => 'plus',
            ];

            // outside of Dhaka
            if ($request['city'] != 1) {
                $shipping['name'] = 'Delivery (Outside Dhaka)';
                $shipping['amount'] = '100';
            }
            $this->addCharge($shipping, 'delivery');
        }
        // else {
        //     return false;
        //     exit;
        // }

        if ($request->ajax()) {
            return view('cart.minicart');
        }
        return back()->with('success', 'Delivery charge has been successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
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
    public function update($lang, Request $request, $id)
    {
        // dd($request, $id);
        $validated = $request->validate([
            'quantity' => 'numeric|min:1',
        ]);
        // dd($validated);

        $this->updateQty($id, $validated['quantity'], true);
        return back()->with('success', 'The cart has been updated successfully.');
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
}
