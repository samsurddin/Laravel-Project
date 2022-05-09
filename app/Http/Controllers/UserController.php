<?php

namespace App\Http\Controllers;

use App\Models\Tenant\Postcode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Role;
use App\Models\TenantRole as Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index', app()->getLocale())
                        ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, User $user)
    {
        // dd($lang, $user);
        return view('users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile($lang, User $user)
    {
        // dd($lang, $user);
        // dd(is_null($user->id));
        if (is_null($user->id)) {
            $user = auth()->user();
        }

        // dd($user->billing_zipcode);

        $user_postcode = null;
        if ($user->billing_zipcode != NULL) {
            // $user = User::find($user->id)->with('district:id,name')->with('division:id,name');
            $user_postcode = Postcode::where('postCode', $user->billing_zipcode)->with('district:id,name')->with('division:id,name')->first();
        }
        
        $postcodes = Postcode::with('district:id,name')->with('division:id,name')->get();

        // dd($user_postcode);
        return view('users.profile', compact('user', 'postcodes', 'user_postcode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        // dd($userRole, $roles);
    
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, User $user)
    {
        $input = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'confirmed',
            'roles' => 'required'
        ]);
    
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
    
        $user->update($input);
        // $user->syncRoles($request->input('roles'));
        $user->syncRoles($input['roles']);
    
        return redirect()->route('users.index', app()->getLocale())
                        ->with('success', 'User updated successfully');
    }

    /**
     * Update the profile data in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile_update($lang, Request $request, User $user)
    {
        // dd($request, $user);

        $input = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'billing_address' => 'nullable',
            'billing_city' => 'nullable',
            'billing_state' => 'nullable',
            'billing_zipcode' => 'nullable',
            'billing_mobile' => 'nullable',
            'billing_alt_mobile' => 'nullable'
        ]);
    
        $user->update($input);

        if ($request->ajax()) {
            return view('users.profile_ajax', compact('user'));
        }
    
        return redirect()->route('profile', app()->getLocale())
                        ->with('success', 'Your profile has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, User $user)
    {
        $user->delete();
        return redirect()->route('users.index', app()->getLocale())
                        ->with('success', 'User deleted successfully');
    }
}
