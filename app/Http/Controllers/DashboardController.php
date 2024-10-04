<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Employee;
use App\Models\Task;
use App\Models\Npn;
use App\Models\Supplier;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = User::whereNull('deleted_at')->count();
        $emp = Employee::whereNull('deleted_at')->count();
        $tasks = Task::whereNull('deleted_at')->count();
        $npn = Npn::whereNull('deleted_at')->count();
        $supplier = Supplier::whereNull('deleted_at')->count();

        return view('dashboard.dashboard', [
            'user' => $user, 'emp' => $emp, 'task' => $tasks, 'npn' => $npn, 'supplier' => $supplier
        ]);
    }
}
