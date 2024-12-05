<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agency = Agency::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('agency.index', [
            'agency' => $agency, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agency.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:agency',
            'mobile' => 'required|max:200',
            'location' => 'required|max:500',
            'contact_person' => 'required|max:500',
        ]);

        $validated['created_by'] = auth()->user()->id_user;
        $validated['updated_by'] = auth()->user()->id_user;

        $agency = Agency::create($validated);

        Alert::success('Success', 'Agency has been saved!');
        return redirect('/agency');
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
        $agency = Agency::findOrFail($id);
        

        return view('agency.edit', [
            'agency' => $agency
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:agency',
            'mobile' => 'required|max:200',
            'location' => 'required|max:500',
            'contact_person' => 'required|max:500',
        ]);

        $validated['updated_by'] = auth()->user()->id_user;

        $agency = Agency::findOrFail($id);
        $agency->update($validated);

        Alert::success('Success', 'Agency has been saved !');
        return redirect('/agency');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletednpn = Agency::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletednpn->update($validated);

            Alert::error('Success', 'Agency has been deleted!');
            return redirect('/agency');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Agency already used!');
            return redirect('/agency');
        }
    }
}
