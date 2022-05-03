<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specification;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specifications = Specification::paginate(10);
        $spec_heads = Specification::heads()->get();
        // dd($spec_heads);
        return view('admin.specifications.list', compact('specifications', 'spec_heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['type'] == 'head') {
            $request['head_id'] = NULL;
        }
        $validated = $request->validate([
            'name' => 'required|unique:specifications|max:50',
            'type' => 'required',
            'head_id' => 'numeric|min:1|nullable',
        ]);

        // dd($validated);

        // $request['slug'] = Str::slug($request['name'], '-');
        // dd($validated);
        $specification = Specification::create($validated);
        if ($specification) {
            return redirect(route('specifications.index'))->with('success', 'A new specification is added successfully!');
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
        $specification = Specification::find($id);
        $spec_heads = Specification::where(['type'=>'head'])->get();
        // dd($specification);
        return view('admin.specifications.edit', compact('specification', 'spec_heads'));
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
        if ($request['type'] == 'head') {
            $request['head_id'] = NULL;
        }
        $validated = $request->validate([
            'name' => 'required|max:50',
            'type' => 'required',
            'head_id' => 'numeric|min:1|nullable',
        ]);
        if ($validated['type'] == 'key' && $validated['head_id'] == $id) {
            return redirect(route('specifications.index'))->with('error', 'A head can not be converted when it is a head!');
        }

        // dd($request->all());
        // dd($validated);

        $update = Specification::where('id', $id)->update($validated);

        if ($update) {
            return redirect(route('specifications.index'))->with('success', 'Specification is updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedRows = Specification::where('id', $id)->delete();

        if ($deletedRows) {
            return redirect(route('specifications.index'))->with('success', 'Specification is deleted successfully!');
        }
        return redirect(route('specifications.index'))->with('error', 'Somethong went wrong! Specification cannot be deleted! Please try again!');
    }
}
