<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\Machine;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machine = Machine::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('machine.index', [
            'machines' => $machine, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('machine.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|max:100',
            'machine_number' => 'required|max:100',
            'speed' => 'required|max:100',
        ]);

        $validated['created_by'] = auth()->user()->id_user;
        $validated['updated_by'] = auth()->user()->id_user;

        $machine = Machine::create($validated);

        Alert::success('Success', 'Machine has been saved!');
        return redirect('/machine');
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
        $machine = Machine::findOrFail($id);

        return view('machine.edit', [
            'machine' => $machine,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|max:100',
            'machine_number' => 'required|max:100',
            'speed' => 'required|max:100',
        ]);

        $validated['updated_by'] = auth()->user()->id_user;

        $role = Machine::findOrFail($id);
        $role->update($validated);

        Alert::info('Success', 'Machine has been updated!');
        return redirect('/machine');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            // $model = Location::find( $id );
            // $model->delete();

            $deletedrole = Machine::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedrole->update($validated);

            //$deletedrole->delete();

            Alert::error('Success', 'Machine has been deleted!');
            return redirect('/machine');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Location already used!');
            return redirect('/machine');
        }
    }
}
