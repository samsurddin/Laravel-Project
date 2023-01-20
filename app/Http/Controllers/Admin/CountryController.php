<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Countrie;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jsonurl = "https://raw.githubusercontent.com/hiiamrohit/Countries-States-Cities-database/master/countries.json";

        $json = file_get_contents($jsonurl);
        $data = json_decode($json, TRUE);
        $countries = $data['countries'];
        $name = $countries;

        $coun = Countrie::all();
        return view('country.index',
        [
            'coun'=>$coun,
            'data'=>$name
        ]
    );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   
        return view('country.create');
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = new Countrie();
        $country->iso = $request->iso;
        $country->name = $request->name;
        $country->nicename = $request->nicename;
        $country->iso3 = $request->iso3;
        $country->numcode = $request->numcode;
        $country->phonecode = $request->phonecode;

        $country->save();
        return redirect()->route('admin.country.index', app()->getLocale());
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('country.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $country = Countrie::find($id);
        return view('country.edit', ["country"=>$country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, $id)
    {
        $country = Countrie::find($id);
        $country->iso = $request->iso;
        $country->name = $request->name;
        $country->nicename = $request->nicename;
        $country->iso3 = $request->iso3;
        $country->numcode = $request->numcode;
        $country->phonecode = $request->phonecode;

        $country->save();
        return  redirect()->route('admin.country.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $country = Countrie::find($id);
        $country->delete();
        return redirect()->route('admin.country.index', app()->getLocale());
        
    }
}
