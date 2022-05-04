<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Category;
use App\Models\Tenant\Brand;
use App\Models\Tenant\Specification;
use App\Models\Tenant\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang, Request $request, Brand $brand)
    {
        $categories = Category::all()->toArray();
        $category_tree = Category::where(['parent_id' => NULL])->with('parent')->with('child')->get()->toArray();
        $all_categories = Category::all();
        $brands = Brand::all();
        $specs = Specification::all();

        $products = Product::with('images')->paginate(15);

        $filter = $request->toArray();
        if (!empty($filter)) {
            // dd($filter);
            $products = $this->getProducts($filter);
            // dd($products);
        }
        $selected_brand = '';
        if (!empty($brand->id)) {
            $products = $brand->products()->paginate(15);
            $selected_brand = $brand->id;
        }
        $rating_filter = $this->getRatingFilter();

        $product_min_max_price = Product::selectRaw(" MIN(regular_price) AS min_price, MAX(regular_price) AS max_price")->get()->toArray();
        $product_min_max_price = \Illuminate\Support\Arr::flatten($product_min_max_price);
        $price_filter = $this->getPriceFilter($product_min_max_price[0], $product_min_max_price[1]);

        return view('products.shop', compact('categories', 'category_tree', 'all_categories', 'brands', 'specs', 'products', 'rating_filter', 'price_filter', 'product_min_max_price', 'filter', 'selected_brand'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Category $category)
    {
        $categories = Category::all()->toArray();
        $category_tree = $category->where(['parent_id' => NULL])->with('parent')->with('child')->get()->toArray();
        $parent_cats = $category->parent()->with('child')->get()->toArray();
        $child_cats = $category->child()->with('parent')->get()->toArray();
        $brands = Brand::all();
        $specs = Specification::all();

        $category_ids = $this->getChildCatIds($category);

        // \Illuminate\Support\Facades\DB::enableQueryLog();
        if (!is_array($category_ids)) {
            $products = $category->products()->paginate(15);
        } else {
            // $products = Product::with(['categories' => function($q) use ($category_ids)
            // {
            //     $q->whereIn('category_id', $category_ids);
            // }])->paginate(15);

            $products = Product::whereHas('categories', function($q) use ($category_ids)
            {
                $q->whereIn('category_id', $category_ids);
            })->paginate(15);
        }
        // $query_dump = \Illuminate\Support\Facades\DB::getQueryLog();
        // dd($query_dump);

        // dd($category_ids);
        // dd($products);

        $rating_filter = $this->getRatingFilter();
        
        $product_min_max_price = Product::selectRaw(" MIN(regular_price) AS min_price, MAX(regular_price) AS max_price")->get()->toArray();
        $product_min_max_price = \Illuminate\Support\Arr::flatten($product_min_max_price);
        $price_filter = $this->getPriceFilter($product_min_max_price[0], $product_min_max_price[1]);

        return view('products.shop', compact('categories','category_tree', 'parent_cats', 'child_cats', 'brands', 'specs', 'products', 'rating_filter', 'price_filter', 'product_min_max_price'));
    }

    public function getProducts($filter=[])
    {
        $category_ids = [];
        if (isset($filter['category'])) {
            $category_ids = $this->getChildCatIds($filter['category']);
        }

        // dd(isset($filter['min']) && isset($filter['max']));
        if (isset($filter['min']) && isset($filter['max'])) {
        // \Illuminate\Support\Facades\DB::enableQueryLog();
            return $products = Product::whereBetween('regular_price', [$filter['min'], $filter['max']])->paginate(15);
        //     dd($products);
        // $query_dump = \Illuminate\Support\Facades\DB::getQueryLog();
        // dd($query_dump);
        }

        $keyword = isset($filter['s'])?$filter['s']:'';
        if (!is_array($category_ids)) {
            $category = Category::find($category_ids);
            if (empty($category)) {
                return null;
            }
            $products = $category->products()->where(function ($query) use($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->orWhere('short_description', 'like', '%' . $keyword . '%');
                $query->orWhere('description', 'like', '%' . $keyword . '%');
            })->paginate(15);
        } else {
            // $products = Product::with(['categories' => function($q) use ($category_ids)
            // {
            //     $q->whereIn('category_id', $category_ids);
            // }])->paginate(15);
            // $products = Product::where('name', 'like', '%' . $filter['s'] . '%')->orWhere('short_description', 'like', '%' . $filter['s'] . '%')->orWhere('description', 'like', '%' . $filter['s'] . '%')->whereHas('categories', function($q) use ($category_ids)
            // {
            //     $q->whereIn('category_id', $category_ids);
            // })->paginate(15);
            $products = Product::where(function ($query) use($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->orWhere('short_description', 'like', '%' . $keyword . '%');
                $query->orWhere('description', 'like', '%' . $keyword . '%');
            })->whereHas('categories', function($q) use ($category_ids)
            {
                $q->whereIn('category_id', $category_ids);
            })->paginate(15);

        }
        return $products;
    }

    public function getChildCatIds($cat)
    {
        $cat_id = is_numeric($cat)?$cat:$cat->id;
        $child_cats = Category::where('id', $cat_id)->with('child')->select('id')->first();
            
        if ($child_cats == NULL) {
            return null;
        }

        $cat_ids = $cat_id;
        if (!empty($child_cats['child']) && count($child_cats['child']) > 0) {
            $child_cats = $child_cats->toArray();
            $cat_ids = [$cat_id];
            foreach ($child_cats['child'] as $child) {
                $cat_ids[] = $child['id'];
            }
            // dd($child_cats['child']);
        }
            // dd($cat_ids);
            // dd(count($child_cats['child']) > 0);
            // dd(!empty($child_cats['child']) && count($child_cats['child']) < 1);
        return $cat_ids;
    }

    public function getRatingFilter($rating = 1)
    {
        return $rating_filter = [
            1 => 43,
            2 => 12,
            3 => 77,
            4 => 888,
            5 => 556,
        ];
    }

    public function getPriceFilter($min=0, $max=3000)
    {
        return $price_filter = [
            ['min' => 0, 'max' => 250, 'label' => 'Under tk250'],
            ['min' => 251, 'max' => 500, 'label' => 'tk251 to tk500'],
            ['min' => 501, 'max' => 1000, 'label' => 'tk501 to tk1000'],
            ['min' => 1001, 'max' => 2000, 'label' => 'tk1001 to tk2000'],
            ['min' => 2001, 'max' => $max, 'label' => 'Above tk2000'],
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Category $category)
    {
        //
    }
}
