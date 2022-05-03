<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        // dd($brands);
        return view('admin.brands.list', compact('brands'));
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
    public function store($lang, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:brands|max:50',
            'website' => '',
            'contact_person' => '',
            'contact_number' => '',
            'contact_email' => '',
        ]);

        // $request['slug'] = Str::slug($request['name'], '-');
        // dd($validated);
        $brand = Brand::create($validated);
        if ($brand) {
            return redirect(route('admin.brands.index', app()->getLocale()))->with('success', 'A new brand is added successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $brand = Brand::find($id);
        // dd($brand);
        return view('admin.brands.edit', compact('brand'));
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
        $validated = $request->validate([
            'name' => 'required|max:50',
            'website' => '',
            'contact_person' => '',
            'contact_number' => '',
            'contact_email' => '',
        ]);

        $update = Brand::where('id', $id)->update($validated);

        if ($update) {
            return redirect(route('admin.brands.index', app()->getLocale()))->with('success', 'Brand is updated successfully!');
        }
        return redirect(route('admin.brands.index', app()->getLocale()))->with('error', 'Brand is not updated, please try again!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $deletedRows = Brand::where('id', $id)->delete();

        if ($deletedRows) {
            return redirect(route('admin.brands.index', app()->getLocale()))->with('success', 'Brand is deleted successfully!');
        }
        return redirect(route('admin.brands.index', app()->getLocale()))->with('error', 'Somethong went wrong! Brand cannot be deleted! Please try again!');
    }
}
