<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = DB::table('category')
                ->whereRaw('category.deleted_at = "" OR category.deleted_at IS NULL')
                ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('category.index', [
            'category' => $category, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:category',
        ]);

        $category = Category::create($request->all());

        Alert::success('Success', 'Category has been saved!');
        return redirect('/category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:category,name,' . $id . ',id',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        Alert::info('Success', 'Category has been updated!');
        return redirect('/category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            $deletedcategory = Category::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedcategory->update($validated);


            Alert::error('Success', 'Category has been deleted!');
            return redirect('/category');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Category already used!');
            return redirect('/category');
        }
    }
}
