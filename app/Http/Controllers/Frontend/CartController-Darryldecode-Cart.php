<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(empty($request->get('add-to-cart')));
        // $userId = auth()->user();
        // $userId = Auth::user();
        // dd($userId);

        if (!empty($request->get('add-to-cart'))) {
            $pid = $request->get('add-to-cart');
            $product = Product::where('id', $pid)->first();
            // dd($product->name);
            // dd(empty($product));

            // if ($product->isEmpty()) {
            if (empty($product)) {
                return redirect('shop');
            }

            \Cart::add(array(
                'id' => $product->id, // inique row ID
                'name' => $product->name,
                'regular_price' => $product->regular_price,
                'price' => empty($product->sale_price)?$product->regular_price:$product->sale_price,
                'quantity' => 1,
                'attributes' => array(
                    'feat_img' => $product->featured_img,
                    'regular_price' => $product->regular_price,
                    'sale_price' => $product->sale_price,
                ),
                'associatedModel' => $product
            ));

            return back()->with('success', 'You product is successfully added to the cart.');
        }
        if (!empty($request->get('remove'))) {
            \Cart::remove($request->get('remove'));
            return back()->with('success', 'You product has been removed from cart.');
        }

        $this->addConditions();
        return view('cart.cart');
    }

    public function checkout()
    {
        $this->addConditions();
        return view('cart.checkout');
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

    public function add(Product $product)
    {
        
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

        $product = Product::where('id', $validated['product_id'])->first();
        // dd($product->name);
        // dd(empty($product));

        // if ($product->isEmpty()) {
        if (empty($product)) {
            return redirect('shop')->with('error', 'Product is not found! Your product cannot be added to the cart.');
        }

        \Cart::add(array(
            'id' => $product->id, // inique row ID
            'name' => $product->name,
            'regular_price' => $product->regular_price,
            'price' => empty($product->sale_price)?$product->regular_price:$product->sale_price,
            'quantity' => $validated['quantity'],
            'attributes' => array(
                'feat_img' => $product->featured_img,
                'regular_price' => $product->regular_price,
                'sale_price' => $product->sale_price,
            ),
            'associatedModel' => $product
        ));

        return back()->with('success', 'You product is successfully added to the cart.');
    }

    public function addConditions($condition_arr=[])
    {
        if (empty($condition_arr)) {
            $condition_arr = [
                'name' => 'VAT 12.5%',
                'type' => 'tax',
                'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '12.5%',
                'attributes' => [ // attributes field is optional
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                ]
            ];
        }
        // add single condition on a cart bases
        $condition = new \Darryldecode\Cart\CartCondition($condition_arr);
        // dd($condition);
        \Cart::condition($condition);
    }

    public function addDeliveryCharge(Request $request, $city='dhaka')
    {
        // dd($request->ajax());
        // dd($request);

        $deliveryCharge = [
            'inside_dhaka' => [
                'name' => 'Shipping',
                'type' => 'shipping',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '+40',
                'attributes' => [ // attributes field is optional
                    'description' => 'Inside Dhaka City',
                ]
            ],
            'outside_dhaka' => [
                'name' => 'Shipping',
                'type' => 'shipping',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '+100',
                'attributes' => [ // attributes field is optional
                    'description' => 'Outside Dhaka City',
                ]
            ],
        ];

        \Cart::removeConditionsByType('shipping');

        $city = strtolower($city);
        if ($city == 'dhaka') {
            $this->addConditions($deliveryCharge['inside_dhaka']);
        } else {
            $this->addConditions($deliveryCharge['outside_dhaka']);
        }

        if ($request->ajax()) {
            return json_encode(['status'=>'success', 'msg'=>'Delivery charge has been successfully added.', 'deliveryCharge' => \Cart::getConditionsByType('shipping')]);
        }
        return back()->with('success', 'Delivery charge has been successfully added.');
    }

    public function clear()
    {
        \Cart::clear();
        \Cart::clearCartConditions();
        // request()->session()->flush();
        dd('hello');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // dd($request->quantity);
        \Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);
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



