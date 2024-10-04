<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\Customerenquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CustomerenquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ces = DB::table('customer_enquiry')
        ->leftjoin('locations', 'customer_enquiry.location_id', '=', 'locations.id')
        ->select('customer_enquiry.*','locations.location_name')
        ->whereRaw('customer_enquiry.deleted_at = "" OR customer_enquiry.deleted_at IS NULL')
        ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('customerenquiry.index', [
            'ces' => $ces, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();

        return view('customerenquiry.add',['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'mobile' => 'required|max:200',
            'location_id' => 'required',
            'customer_intrest' => 'required',
            'quotetion_status' => 'required',
            //'filename' => 'file|mimes:pdf,zip|max:2048'
        ]);

        
        $validated['created_by'] = auth()->user()->role_id;
        $validated['updated_by'] = auth()->user()->role_id;

        $ces = Customerenquiry::create($validated);

        Alert::success('Success', 'Customer Enquiry has been saved !');
        return redirect('/customerenquiry');
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
        $ces = Customerenquiry::findOrFail($id);
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();

        return view('customerenquiry.edit', [
            'ces' => $ces, 'users' => $users, 'locations' => $locations
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'mobile' => 'required|max:200',
            'location_id' => 'required',
            'customer_intrest' => 'required',
            'quotetion_status' => 'required',
            //'filename' => 'file|mimes:pdf,zip|max:2048'
        ]);

        
        $validated['updated_by'] = auth()->user()->role_id;

        $ces = Customerenquiry::findOrFail($id);
        $ces->update($validated);

        
        Alert::success('Success', 'Customer Enquiry has been saved !');
        return redirect('/customerenquiry');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletedRecord = Customerenquiry::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedRecord->update($validated);

            Alert::error('Success', 'Customer Enquiry has been deleted !');
            return redirect('/customerenquiry');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Customer Enquiry already used !');
            return redirect('/customerenquiry');
        }
    }
}
