<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
// use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    public function show()
    {
        
        return view('customers.show');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = new Customer();
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->city = $request->city;
        $data->zip = $request->zip;
        $data->password = $request->password;
        $data->save();

        return redirect()->route('admin.customers.index',app()->getLocale());

    }

    public function edit($id)
    {
        // dd($id);
        // $customer = Customer::findOrFail($id);
        // return view('customers.edit',compact('customer'));
        // dd($id);
        
        return view('customers.edit');

        // http://ka.com -> domain
        // /en -> lang

        // /admin -> string (eita login korar por route theke set kora hoyece)
        // /customers -> string
        // /1 -> id
        // /edit -> string

    }

    public function update()
    {

    }
    // public function destroy($id)
    // {
    //     $student =  Customer::find($id);
    //     $student->delete($id);
    //     return redirect(route('admin.customers.index'));
    // }


    public function destroy($id)
    {
 
        $data = Customer::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.customers.index',app()->getLocale());
        
    }

    function a():bool
    {
        return true;
    }

    // $a = 5;
    // function b():void
    // {
    //     $a += 6;
    // }
    // function c():void
    // {
    //     return a();
    // }
    // function d():bool
    // {
    //     return b();
    // }
}