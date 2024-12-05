<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Agency;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$employee = Employee::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        $employee = DB::table('employee')
            ->leftjoin('agency', 'employee.agency', '=', 'agency.id')
            ->select('employee.*','agency.name as agency_name')
            ->whereRaw('employee.deleted_at = "" OR employee.deleted_at IS NULL')
            ->get();
        

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('employee.index', [
            'employee' => $employee, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agency = Agency::orderBy('name', 'asc')->get();

        return view('employee.add',['agency' => $agency]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|max:100',
            'mobile' => 'required|max:100',
            'agency' => 'max:100',
        ]);

        $validated['created_by'] = auth()->user()->id_user;
        $validated['updated_by'] = auth()->user()->id_user;

        $employee = Employee::create($validated);

        Alert::success('Success', 'Employee has been saved!');
        return redirect('/employee');
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
        $employee = Employee::findOrFail($id);
        $agency = Agency::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('employee.edit', [
            'employee' => $employee,
            'agency' => $agency,
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
            'mobile' => 'required|max:100',
        ]);

        $validated['updated_by'] = auth()->user()->id_user;

        $role = Employee::findOrFail($id);
        $role->update($validated);

        Alert::info('Success', 'Employee has been updated!');
        return redirect('/employee');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $deletedrole = Employee::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedrole->update($validated);

            Alert::error('Success', 'Employee has been deleted!');
            return redirect('/employee');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Location already used!');
            return redirect('/employee');
        }
    }
}
