<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $location = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();

        $value = auth()->user();
        $current_role = Role::find($value->role_id);

        return view('location.index', [
            'location' => $location, 'role' => $current_role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|max:100|unique:locations',
            'location_code' => 'required|max:100|unique:locations',
        ]);

        $location = Location::create($request->all());

        Alert::success('Success', 'Location has been saved!');
        return redirect('/location');
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
        $location = Location::findOrFail($id);

        return view('location.edit', [
            'location' => $location,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'location_name' => 'required|max:100|unique:locations,location_name,' . $id . ',id',
            'location_code' => 'required|max:100|unique:locations,location_code,' . $id . ',id',
        ]);

        $location = Location::findOrFail($id);
        $location->update($validated);

        Alert::info('Success', 'Location has been updated!');
        return redirect('/location');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            $deletedlocation = Location::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedlocation->update($validated);


            Alert::error('Success', 'Location has been deleted!');
            return redirect('/location');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Location already used!');
            return redirect('/location');
        }
    }
}
