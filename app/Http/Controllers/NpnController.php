<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\Npn;
use App\Models\Files;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use App\DataTables\ExportDataTable;

class NpnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $npns = DB::table('npns')
                ->leftJoin('locations', 'npns.location_id', '=', 'locations.id')
                ->leftJoin('files', function($join) {
                    $join->on('npns.id', '=', 'files.type_id')
                        ->where('files.type', '=', 'Npn');
                })
                ->select('npns.*', 'locations.location_name', 'files.id as files_id')
                ->whereNull('npns.deleted_at')
                ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('npn.index', [
            'npns' => $npns, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();

        return view('npn.add',['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|max:100',
            'number' => 'max:200',
            'location_id' => 'required',
            'filename'=> 'mimes:pdf,doc,docx,xlx,csv,jpg,png|max:4048',
        ]);
        
        $validated['created_by'] = auth()->user()->id_user;
        $validated['updated_by'] = auth()->user()->id_user;

        $npn = Npn::create($validated);

        if($npn){
            if ($request->hasFile('filename')) {
                if ($request->file('filename')->isValid()) {
    
                    $file = new files();
    
                    $name = time().'_'.$request->file('filename')->getClientOriginalName();
                    $filePath = $request->file('filename')->storeAs('npns', $name, 'public');
        
                    $file->file_name = $name;
                    
                    $file->file_path = $filePath;
                    $file->type = 'Npn';
                    $file->type_id = $task->id;
                    $file->created_by = auth()->user()->id_user;
                    $file->updated_by = auth()->user()->id_user;
                    $file->save();
    
                }
            }
        }

        Alert::success('Success', 'Npn has been saved!');
        return redirect('/npn');
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
        $npn = Npn::findOrFail($id);
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();

        return view('npn.edit', [
            'npn' => $npn, 'users' => $users, 'locations' => $locations
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|max:100',
            'number' => 'max:200',
            'location_id' => 'required',
            //'filename' => 'file|mimes:pdf,zip|max:2048'
        ]);

        $validated['updated_by'] = auth()->user()->id_user;

        $npn = Npn::findOrFail($id);
        if($npn->update($validated)) {
            if($request->file != NULL) {
                $exist_files = Files::where('type_id',$id)->get();

                $name = time().'_'.$request->file('filename')->getClientOriginalName();
                $filePath = $request->file('filename')->storeAs('npns', $name, 'public');

                if($exist_files->count() != 0){
                    $file = Files::findOrFail(collect($exist_files)->first()->id);

                    $files_updated = [
                        'file_name' => $name,
                        'file_path' => $filePath,
                        'type' => 'Npn',
                        'type_id' => $id,
                        'updated_by' => auth()->user()->id_user
                    ];

                    $file->update($files_updated);

                } else {
                    $file = new files();

                    $file->file_name = $name;
                    $file->file_path = $filePath;
                    $file->type = 'Npn';
                    $file->type_id = $npn->id;
                    $file->created_by = auth()->user()->id_user;
                    $file->updated_by = auth()->user()->id_user;
                    $file->save();
                }
            }
        }

        Alert::success('Success', 'Npn has been saved!');
        return redirect('/npn');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletednpn = Npn::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletednpn->update($validated);

            Alert::error('Success', 'Npn has been deleted!');
            return redirect('/npn');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Npn already used!');
            return redirect('/npn');
        }
    }
}
