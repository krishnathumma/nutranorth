<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::whereNull('deleted_at')->orderBy('role', 'asc')->get();

        $value = auth()->user();
        $current_role = Role::find($value->role_id);

        return view('role.index', [
            'role' => $role, 'current_role' => $current_role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|max:100|unique:roles',
        ]);

        $role = Role::create($request->all());

        Alert::success('Success', 'Role has been saved !');
        return redirect('/role');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        return view('role.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'role' => 'required|max:100|unique:roles,role,' . $id . ',id',
        ]);

        $role = Role::findOrFail($id);
        $role->update($validated);

        Alert::info('Success', 'role has been updated!');
        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            // $model = Location::find( $id );
            // $model->delete();
            $deletedrole = Role::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedrole->update($validated);

            Alert::error('Success', 'Role has been deleted !');
            return redirect('/role');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Location already used !');
            return redirect('/role');
        }
    }
}
