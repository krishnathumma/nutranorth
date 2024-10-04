<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\UserLocationRelationship;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$user = User::orderBy('name', 'asc')->get();
        $user = DB::table('users')
            ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftjoin('locations', 'users.location_id', '=', 'locations.id')
            ->select('users.id_user','users.name','users.email', 'roles.id','roles.role','locations.location_name')
            ->whereRaw('users.deleted_at = "" OR users.deleted_at IS NULL')
            ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('user.user', [
            'user' => $user, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();
        $roles = Role::whereNull('deleted_at')->orderBy('role', 'asc')->get();

        return view('user.user-add',['locations' => $locations, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|max:200',
            'location_id' => 'required',
            'role_id' => 'required',
        ]);
        $validated['password'] = Hash::make($request['password']);
        

        $user = User::create($validated);

        Alert::success('Success', 'User has been saved !');
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();
        $roles = Role::whereNull('deleted_at')->orderBy('role', 'asc')->get();

        return view('user.user-edit', [
            'user' => $user,
            'locations' => $locations, 
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:users',
            'location_id' => 'required',
            'role_id' => 'required',
        ]);

        $validated['updated_by'] = auth()->user()->role_id;
        
        $role = User::findOrFail($id);
        $role->update($validated);

        Alert::success('Success', 'User has been saved !');
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $deletedrole = User::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedrole->update($validated);

            Alert::error('Success', 'User has been deleted !');
            return redirect('/user');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, User already used !');
            return redirect('/user');
        }
    }
}
