<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Files;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = DB::table('suppliers')
            ->leftjoin('users', 'suppliers.created_by', '=', 'users.id_user')
            ->leftJoin('files', function($join) {
                $join->on('suppliers.id', '=', 'files.type_id')
                    ->where('files.type', '=', 'Supplier');
            })
            ->select('suppliers.*','users.name as user_name','files.id as files_id')
            ->whereRaw('suppliers.deleted_at = "" OR suppliers.deleted_at IS NULL')
            ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('supplier.index', [
            'suppliers' => $suppliers, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('supplier.add',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'place' => 'required|max:100',
            'product' => 'required|max:200',
            'email' => 'required',
            'currency' => 'required',
            'mobile' => 'required|max:12',
            'price' => 'required|max:250',
            'received_date' => 'max:1200',
            'filename' => 'file|mimes:pdf,zip|max:2048'
        ]);

        
        $validated['created_by'] = auth()->user()->role_id;
        $validated['updated_by'] = auth()->user()->role_id;

        $supplier = Supplier::create($validated);

        if($supplier){
            if ($request->hasFile('filename')) {
                if ($request->file('filename')->isValid()) {
    
                    $file = new files();
    
                    $name = time().'_'.$request->file('filename')->getClientOriginalName();
                    $filePath = $request->file('filename')->storeAs('suppliers', $name, 'public');
        
                    $file->file_name = $name;
                    
                    $file->file_path = $filePath;
                    $file->type = 'Supplier';
                    $file->type_id = $supplier->id;
                    $file->created_by = auth()->user()->role_id;
                    $file->updated_by = auth()->user()->role_id;
                    $file->save();
    
                }
            }
        }

        Alert::success('Success', 'Supplier has been saved!');
        return redirect('/supplier');
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
        $supplier = Supplier::findOrFail($id);
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('supplier.edit', [
            'supplier' => $supplier, 'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'place' => 'required|max:100',
            'product' => 'required|max:200',
            'email' => 'required',
            'currency' => 'required',
            'mobile' => 'required|max:12',
            'price' => 'required|max:250',
            'received_date' => 'max:120'
        ]);
        
        $validated['updated_by'] = auth()->user()->role_id;

        $supplier = Supplier::findOrFail($id);
        if($supplier->update($validated)){
            if($request->file != NULL) {
                $exist_files = Files::where('type_id',$id)->get();
                $name = time().'_'.$request->file('filename')->getClientOriginalName();
                $filePath = $request->file('filename')->storeAs('suppliers', $name, 'public');

                if($exist_files->count() != 0){
                    $file = Files::findOrFail(collect($exist_files)->first()->id);

                    $files_updated = [
                        'file_name' => $name,
                        'file_path' => $filePath,
                        'type' => 'Supplier',
                        'type_id' => $id,
                        'updated_by' => auth()->user()->role_id
                    ];

                    $file->update($files_updated);

                } else {
                    $file = new files();

                    $file->file_name = $name;
                    $file->file_path = $filePath;
                    $file->type = 'Supplier';
                    $file->type_id = $id;
                    $file->created_by = auth()->user()->role_id;
                    $file->updated_by = auth()->user()->role_id;

                    $file->save();
                }
            }
    
                      
        }

        Alert::info('Success', 'Supplier has been updated !');
        return redirect('/supplier');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletedsupplier = Supplier::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedsupplier->update($validated);

            Alert::error('Success', 'Supplier has been deleted !');
            return redirect('/supplier');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Supplier already used !');
            return redirect('/supplier');
        }
    }
}
