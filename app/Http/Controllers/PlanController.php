<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::orderBy('id','DESC')->paginate(5);
        return view('plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, StorePlanRequest $request)
    {
        $input = $this->validate($request, [
            'name' => 'required|unique:App\Models\TenantRole,name',
            'permission' => 'nullable',
        ]);
    
        $plan = Plan::create($input);
    
        return redirect()->route('plans.index', app()->getLocale())
                        ->with('success','Plan created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update($lang, UpdatePlanRequest $request, Plan $plan)
    {
        $input = $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'features' => 'nullable',
            'price' => 'required',
            'price_yearly' => 'nullable',
        ]);
    
        // $plan->name = $input['name'];
        $plan->save($input);
    
        return redirect()->route('plans.index', app()->getLocale())
                        ->with('success','Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index', app()->getLocale())
                        ->with('success','Plan deleted successfully');
    }
}
