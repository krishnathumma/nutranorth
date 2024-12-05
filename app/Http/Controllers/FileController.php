<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection; 

use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    public function create(){
        $files = Files::where('type', '=', 'Npn-data')->get();
        
        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('upload', [
            'files' => $files, 'role' => $role
        ]);
    }

    public function download($filename)
    {
        $files = Files::findOrFail($filename);
        //dd($files);
        // Define the path where files are stored
        $path = storage_path('app/public/'. $files->file_path);

        // Check if file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Return the file for download
        return response()->download($path);
    }

    public function upload(Request $request)
    {
                
        $request->validate([
            'status' => 'required|max:100',
            'filename'=> 'required|mimes:csv,xlx,xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:4048',
        ]);


        if ($request->hasFile('filename')) {
            if ($request->file('filename')->isValid()) {

                $file = new files();
                $loaction = $request->status.'/data';

                $name = time().'_'.$request->file('filename')->getClientOriginalName();
                $filePath = $request->file('filename')->storeAs($loaction, $name, 'public');
    
                $file->file_name = $name;
                
                $file->file_path = $filePath;
                $file->type = 'Npn-data';
                $file->type_id = 99665;
                $file->created_by = auth()->user()->id_user;
                $file->updated_by = auth()->user()->id_user;
                $file->save();

                return back()
                ->with('success', 'File has been uploaded.')
                ->with('file', $name);

            }
        }
    }

    public function execute(string $id){
        
        $files = Files::findOrFail($id);
        //dd($files);
        // Define the path where files are stored
        $path = storage_path('app/public/'. $files->file_path);
        //$path = base_path('public/' .$files->file_path);
        
        

        // Check if file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        $handle = fopen($path, "r");
        $excelSpreadSheetData = Excel::toCollection(null, $path);

        foreach($excelSpreadSheetData as $key => $value){
            dd($value);
        }
    }
}
