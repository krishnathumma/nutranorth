<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Files;

use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
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
}
