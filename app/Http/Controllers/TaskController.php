<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\Task;
use App\Models\Files;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mail\SendMailsToUsers;
use Illuminate\Support\Facades\Mail;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->taskmail(2, 'add');
        
        $task = DB::table('tasks')
            ->leftjoin('users', 'tasks.assigned_to', '=', 'users.id_user')
            ->leftjoin('files', 'tasks.id', '=', 'files.type_id')
            ->select('tasks.*','users.name', 'files.id as files_id')
            ->whereRaw('tasks.deleted_at = "" OR tasks.deleted_at IS NULL')
            ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('task.index', [
            'task' => $task, 'role' => $role
        ]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('task.add',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_category' => 'required|max:100',
            'task_type' => 'required|max:100',
            'assigned_to' => 'required|max:200',
            'assigned_date' => 'required',
            'source' => 'required',
            'due_date' => 'required',
            'status' => 'required|max:250',
            'description' => 'max:1200',
            'filename' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:10000'
        ]);

        
        $validated['created_by'] = auth()->user()->role_id;
        $validated['updated_by'] = auth()->user()->role_id;

        //dd($request->file('filename')->getClientOriginalName());
        $this->taskmail(2, 'add');
        $task = Task::create($validated);
        
        if($task){
            if ($request->hasFile('filename')) {
                if ($request->file('filename')->isValid()) {
    
                    $file = new files();
    
                    $name = time().'_'.$request->file('filename')->getClientOriginalName();
                    $filePath = $request->file('filename')->storeAs('tasks', $name, 'public');
        
                    $file->file_name = $name;
                    
                    $file->file_path = $filePath;
                    $file->type = 'Task';
                    $file->type_id = $task->id;
                    $file->created_by = auth()->user()->role_id;
                    $file->updated_by = auth()->user()->role_id;
                    $file->save();
                }
            }
        }

        Alert::success('Success', 'Task has been saved !');
        return redirect('/task');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $users = User::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('task.edit', [
            'task' => $task, 'users' => $users
        ]);
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'task_category' => 'required|max:100',
            'task_type' => 'required|max:100',
            'assigned_to' => 'required|max:200',
            'assigned_date' => 'required',
            'source' => 'required',
            'due_date' => 'required',
            'status' => 'required|max:250',
            'description' => 'max:1200'
        ]);
        
        $validated['updated_by'] = auth()->user()->role_id;

        $task = Task::findOrFail($id);
        if($task->update($validated)) {

            $exist_files = Files::where('type_id',$id)->get();

            $name = time().'_'.$request->file('filename')->getClientOriginalName();
            $filePath = $request->file('filename')->storeAs('tasks', $name, 'public');

            if($exist_files->count() != 0){
                $file = Files::findOrFail(collect($exist_files)->first()->id);

                $files_updated = [
                    'file_name' => $name,
                    'file_path' => $filePath,
                    'type' => 'Task',
                    'type_id' => $id,
                    'updated_by' => auth()->user()->role_id
                ];

                $file->update($files_updated);

            } else {
                $file = new files();

                $file->file_name = $name;
                $file->file_path = $filePath;
                $file->type = 'Task';
                $file->type_id = $task->id;
                $file->created_by = auth()->user()->role_id;
                $file->updated_by = auth()->user()->role_id;
                $file->save();
            }
        }

        Alert::info('Success', 'Task has been updated !');
        return redirect('/task');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletedtask = Task::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->role_id;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedtask->update($validated);

            Alert::error('Success', 'Task has been deleted !');
            return redirect('/task');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Task already used !');
            return redirect('/task');
        }
    }

    public function taskmail($id, $type='')
    {

        $task = DB::table('tasks')->where('id', $id)->first();
        
        $user = DB::table('users')->where('id_user', $task->assigned_to)->first();
		$user_name = $user->name;

		$task_assigned = DB::table('users')->where('id_user', $task->created_by)->first();
		$task_assigned_name = $task_assigned->name;

		if(strtolower($type) == 'add'){
			$subject = 'Task ID ('.$task->id.') Added';
			$assign_by = "Task Assigned By";
			$tag = "Task has been Added";
			$emailId = $user->email;
		} else if(strtolower($type) == 'edit'){
			$subject = 'Task ID ('.$task->id.') Updated';
			$assign_by = "Task Assigned By";
			$tag = "Task has been Added";
			$emailId = $user->email;
		} else {
			$subject = 'Task ID ('.$task->id.') Status Changed';
			$assign_by = "Task Updated By";
			$tag = "Task Status Changed";
			$emailId = $task_assigned->email;
		}

		$url = "Thanks<br/>Nutra North";
        $htmlheader = '<!doctype html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport"
                                    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                <meta http-equiv="X-UA-Compatible" content="ie=edge">

                                <style>
                                    p {
                                        font-size: 12px;
                                    }

                                    .signature {
                                        font-style: italic;
                                    }
                                </style>
                            </head>';

		if(strtolower($type) == 'add' || strtolower($type) == 'edit'){
			$htmlbody  ='<body>
	          <div style="font-size:13px;line-height:1.4;margin:0;padding:0">
	            <div style="background:#f7f7f7;font:13px; "Proxima Nova","Helvetica Neue",Arial,sans-serif;padding:2% 7%">
	              <div style="background:#fff;border-top-color:#ffa800;border-top-style:solid;border-top-width:4px;margin:25px auto">
	                <div style="border-color:#e5e5e5;border-style:none solid solid;border-width:2px;padding:7%">
	                  <p style="color:#333;font-size:14px;line-height:1.4;margin:0 0 20px">Hello '.$user_name.',</p>
	                  <p style="color:#333;font-size:13px;line-height:1.4;margin:20px 0">
	                    '.$tag.'<br />
	                    Task ID: '.$task->id.' <br />
	                    Task Category: '.ucfirst($task->task_category).' <br />
	                    Task Type: '.ucfirst($task->task_type).' <br />
	                    Task Status: '.ucfirst($task->status).' <br />
	                    '.$assign_by.': '.$task_assigned_name.' <br />
	                    Task Assign Date: '.date("Y/m/d H:i:s A",strtotime($task->assigned_date)).' <br />
	                    Task Due Date: '.date("Y/m/d H:i:s A",strtotime($task->due_date)).' <br />
	                    Description: '.$task->description.'<br/>
	                  </p> 
	                  '.$url.'
	                </div>
	              </div>
	            </div>
	          </div>
	        </body>';

		} else {
            $updated_user = DB::table('users')->where('id', $task->updated_by)->first();
			$htmlbody  ='<body>
	          <div style="font-size:13px;line-height:1.4;margin:0;padding:0">
	            <div style="background:#f7f7f7;font:13px; "Proxima Nova","Helvetica Neue",Arial,sans-serif;padding:2% 7%">
	              <div style="background:#fff;border-top-color:#ffa800;border-top-style:solid;border-top-width:4px;margin:25px auto">
	                <div style="border-color:#e5e5e5;border-style:none solid solid;border-width:2px;padding:7%">
	                  <p style="color:#333;font-size:14px;line-height:1.4;margin:0 0 20px">Hello '.$task_assigned_name.',</p>
	                  <p style="color:#333;font-size:13px;line-height:1.4;margin:20px 0">
	                    '.$tag.'<br />
	                    Task ID: '.$task->id.' Status Changed to '.ucfirst($task->status).' on '.date("Y/m/d H:i:s A",strtotime($task->updated_at)).' by '.ucfirst($updated_user->name).'  <br />
	                  </p> 
	                  '.$url.'
	                </div>
	              </div>
	            </div>
	          </div>
	        </body>';
		}

        $htmlfooter = '</html>';

        $html = $htmlheader.$htmlbody.$htmlfooter;
        $files = DB::table('files')->where(['type_id'=> $task->id,'type'=>'Task'])->first();
        $filePath = '';
        $user->email = "psyennam@gmail.com";
        // if($files != null || $files != '')
        // {
        //     //dd('Files');
        //     $filePath = public_path('app/public/'. $files->file_path);
        //     Mail::to("psyennam@gmail.com")->send(new SendMailsToUsers($user->name, $html, $subject, $filePath));
        // } else {
        //     //dd('Empty');
        //     Mail::to("psyennam@gmail.com")->send(new SendMailsToUsers($user->name, $html, $subject));
        // }

        

        // $flag = send($subject, $htmlbody, $emailId);
	    
	    // if($flag == 1){
	    // 	$data = [
	    //         'subject' => $subject,
	    //         'status' => "Success",
	    //         'to' => $emailId,
	    //         'content' => $htmlbody,
	    //         'error_log' => "",
	    //         'created_by' => $this->session->userdata('userid'),
	    //         'created_at' => date('Y-m-d H:i:s')
	    //     ];
	    // } else {
	    //   	$data = [
	    //         'subject' => $subject,
	    //         'status' => "Failed",
	    //         'to' => $emailId,
	    //         'content' => $htmlbody,
	    //         'error_log' => $flag,
	    //         'created_by' => $this->session->userdata('userid'),
	    //         'created_at' => date('Y-m-d H:i:s')
	    //     ];
	    // }
	    // $this->db->insert('mail_logs', $data);


    }
    
}
