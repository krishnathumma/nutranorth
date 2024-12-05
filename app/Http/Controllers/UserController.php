<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Role;
use App\Models\UserLocationRelationship;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;
use Exception;

use App\Mail\SendMailsToUsers;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = DB::table('users')
            ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftjoin('locations', 'users.location_id', '=', 'locations.id')
            ->select('users.id_user','users.name','users.username','users.email', 'users.department', 'users.designation', 'roles.id','roles.role','locations.location_name')
            ->whereRaw('users.deleted_at = "" OR users.deleted_at IS NULL')
            ->get();

        $value = auth()->user();
        $role = Role::find($value->role_id);

        return view('user.user', [
            'user' => $user, 'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();
        $roles = Role::whereNull('deleted_at')->orderBy('role', 'asc')->get();

        return view('user.user-add',['locations' => $locations, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'username' => 'required|max:100|unique:users',
            'email' => 'required|max:100|email',
            'password' => 'required|max:200',
            'location_id' => 'required',
            'role_id' => 'required',
            'department' => 'required|max:200',
            'designation' => 'required|max:200',
        ]);

        $validated['password'] = Hash::make($request['password']);
        $user = User::create($validated);

        $this->usermail($request['username'], $request['password'], $request['name'], $request['email']);

        Alert::success('Success', 'User has been saved!');
        return redirect('/user');
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
        $user = User::findOrFail($id);
        $locations = Location::whereNull('deleted_at')->orderBy('location_name', 'asc')->get();
        $roles = Role::whereNull('deleted_at')->orderBy('role', 'asc')->get();

        return view('user.user-edit', [
            'user' => $user,
            'locations' => $locations, 
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|email',
            'location_id' => 'required',
            'role_id' => 'required',
            'department' => 'required|max:200',
            'designation' => 'required|max:200'
        ]);

        $validated['updated_by'] = auth()->user()->id_user;
        
        $user = User::findOrFail($id);
        $user->update($validated);

        Alert::success('Success', 'User has been Updated!');
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $deletedrole = User::findOrFail($id);

            $validated['deleted_by'] = auth()->user()->id_user;
            $validated['deleted_at'] = date('Y-m-d H:i:s');

            $deletedrole->update($validated);

            Alert::error('Success', 'User has been deleted!');
            return redirect('/user');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, User already used!');
            return redirect('/user');
        }
    }

    public function changePassword(Request $request)
    {
        // return view('user.user-edit', [
        //     'user' => $user,
        //     'locations' => $locations, 
        //     'roles' => $roles
        // ]);

        return view('user.change-password');
    }


    public function changePasswordSave(Request $request)
    {   
       
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = auth()->user();

	    // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) 
        {
            return back()->with('error', "Current Password is Invalid");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) 
        {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }
        $user =  User::findOrFail($auth->id_user);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', "Password Changed Successfully");
    }

    public function usermail($username, $password, $name, $emailId)
    {
        $subject = 'Welcome, ' .$name. '! Your Account Has Been Created';
        $url = "Thanks<br/>Nutra North";
        
        $htmldata = '<!doctype html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport"   content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">

                    <style>
                        p { font-size: 12px; }
                        .signature { font-style: italic; }
                    </style>
                </head>
                <body>
                <div style="font-size:13px;line-height:1.4;margin:0;padding:0">
                  <div style="background:#f7f7f7;font:13px; "Proxima Nova","Helvetica Neue",Arial,sans-serif;padding:2% 7%">
                    <div style="background:#fff;border-top-color:#ffa800;border-top-style:solid;border-top-width:4px;margin:25px auto">
                      <div style="border-color:#e5e5e5;border-style:none solid solid;border-width:2px;padding:7%">
                        <p style="color:#333;font-size:14px;line-height:1.4;margin:0 0 20px">Hello '.$name.',</p>
                        <p style="color:#333;font-size:13px;line-height:1.4;margin:20px 0">
                          Your account has been successfully created, and following are the login Details:<br />
                          User Name: '.ucfirst($username).' <br />
                          password: '.$password.' <br />
                        </p> 
                        '.$url.'
                      </div>
                    </div>
                  </div>
                </div>
              </body>';
              $htmldata .= '</html>';
              
            try {
                Mail::to($emailId)->send(new SendMailsToUsers($name, $subject, $htmldata));
            } catch (\Exception $e) {
                \Log::error('Mail error: ' . $e->getMessage());
            }      
    }
}
