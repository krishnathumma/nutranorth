<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use App\Models\Role;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use App\Http\Controllers\File;
use Illuminate\Support\Facades\File;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timesheet = Timesheet::whereNotNull('deleted_at')->orderBy('name', 'asc')->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('timesheet.index', [
            'timesheet' => $timesheet, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timesheet = Timesheet::orderBy('name', 'asc')->get();
        $agency = Agency::whereNull('deleted_at')->orderBy('name', 'asc')->get();


        return view('timesheet.add',['timesheet' => $timesheet, 'agencies' => $agency]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
