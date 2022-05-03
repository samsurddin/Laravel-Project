<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Specification;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $specs = Specification::all();
        return view('admin.products.create', compact('categories', 'brands', 'specs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        if ($request['slug'] == '') {
            $request['slug'] = Str::slug($request['name'], '-');
        }
        if ($request['brand_id'] == 0) {
            $request['brand_id'] = NULL;
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products|max:255',
            'short_description' => '',
            'description' => '',
            'regular_price' => 'required|numeric|min:1',
            'sale_price' => 'numeric|min:1|nullable',
            'brand_id' => 'numeric|min:1|nullable',
            'featured_img' => '',
            'sku' => '',
            'stock_quantity' => '',
            'stock_available' => '',
            'what_is_q' => '',
            'what_is_a' => '',
        ]);

        // dd($validated);
        $product = Product::create($validated);
        if (!empty($request['cat_id'])) {
            $product->categories()->attach($request['cat_id']);
        }
        
        foreach ($request['spac_val'] as $key => $value) {
            if ($key != 0 && !empty($value)) {
                $product->specifications()->attach($key, ['value'=>$value]);
            }
        }
        if (!is_null($request['image'])) {
            $request['image'] = array_unique($request['image']);
            $product->images()->attach($request['image']);
        }
        // dd($request['image']);

        // dd($product);
        if ($product) {
            return redirect(route('products.index'))->with('success', 'A new product is added successfully!');
        }


        // Product::all()->each(function($product) use ($categories)
        // {
        //     $product->categories()->attach(
        //         $categories->random(1)->pluck('id')
        //     );
        // });
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
        $categories = Category::all();
        $brands = Brand::all();
        $specs = Specification::all();
        $product = Product::where(['id'=>$id])->with('images')->with('specifications')->with('categories')->with('brand')->first();

        // dd($category);
        return view('admin.products.edit', compact('categories', 'brands', 'specs', 'product'));
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
        // dd($request->all());
        $product = Product::find($id);
        if (empty($product)) {
            return redirect(route('products.index'))->with('error', 'Product not found!');
        }

        if ($request['slug'] == '') {
            $request['slug'] = Str::slug($request['name'], '-');
        }
        if ($request['brand_id'] == 0) {
            $request['brand_id'] = NULL;
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'short_description' => '',
            'description' => '',
            'regular_price' => 'required|numeric|min:1',
            'sale_price' => 'numeric|min:1|nullable',
            'brand_id' => 'numeric|min:1|nullable',
            'featured_img' => '',
            'sku' => '',
            'stock_quantity' => '',
            'stock_available' => '',
            'what_is_q' => '',
            'what_is_a' => '',
        ]);
        // dd($validated);

        $product->update($validated);
        if (!empty($request['cat_id'])) {
            // $product->categories()->detach();
            // $product->categories()->attach($request['cat_id']);
            $product->categories()->sync([$request['cat_id']]);
        }

        if (isset($request['spac_val']) && !empty($request['spac_val'])) {
            $product->specifications()->detach();
            foreach ($request['spac_val'] as $key => $value) {
                if (!empty($value)) {
                    $product->specifications()->attach($key, ['value'=>$value]);
                }
            }
        }

        if (!is_null($request['image'])) {
            $product->images()->detach();
            $request['image'] = array_unique($request['image']);
            $product->images()->attach($request['image']);
        }
        // dd($request['image']);

        // dd($product);
        return redirect(route('products.index'))->with('success', 'A new product is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedRows = Product::where('id', $id)->delete();

        if ($deletedRows) {
            return redirect(route('products.index'))->with('success', 'Product is deleted successfully!');
        }
        return redirect(route('products.index'))->with('error', 'Somethong went wrong! Product cannot be deleted! Please try again!');
    }
}
