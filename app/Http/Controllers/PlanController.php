<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\PlanRequest;

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
     * @param  \App\Http\Requests\PlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, PlanRequest $request)
    {
        $input = $request->validated();
    
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
     * @param  \App\Http\Requests\PlanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update($lang, PlanRequest $request, Plan $plan)
    {
        $input = $request->validated();

        $plan->update($input);
    
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
