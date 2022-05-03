<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        // dd($categories);
        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request['name'], '-');

        if ($request['parent_id'] == 0) {
            $request['parent_id'] = NULL;
        }

        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'parent_id' => '',
            'slug' => '',
            'order' => 'numeric|min:1',
        ]);

        // $request['slug'] = Str::slug($request['name'], '-');
        // dd($validated);
        $category = Category::create($validated);
        if ($category) {
            return redirect(route('categories.index', app()->getLocale()))->with('success', 'A new category is added successfully!');
        }
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
        $existingCats = Category::all();
        $category = Category::find($id);
        // dd($category);
        return view('admin.categories.edit', compact('category', 'existingCats'));
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
        if ($request['slug'] == '') {
            $request['slug'] = Str::slug($request['name'], '-');
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'numeric|min:1',
            'slug' => '',
            'order' => 'numeric|min:1',
        ]);

        $update = Category::where('id', $id)->update($validated);

        if ($update) {
            return redirect(route('categories.index', app()->getLocale()))->with('success', 'Category is updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deletedRows = Category::where('id', $id)->delete();

        if ($deletedRows) {
            return redirect(route('categories.index', app()->getLocale()))->with('success', 'Category is deleted successfully!');
        }
        return redirect(route('categories.index', app()->getLocale()))->with('error', 'Somethong went wrong! Category cannot be deleted! Please try again!');
    }
}
