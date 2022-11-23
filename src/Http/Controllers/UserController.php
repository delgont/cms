<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;
use Delgont\Cms\Http\Requests\AdminRequest;
use Delgont\Cms\Http\Requests\EditAdminRequest;
use Illuminate\Http\Request;


use Delgont\Cms\Models\Activity\ActivityLog;
use Illuminate\Support\Str;

use App\User;



class UserController extends Controller
{
    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withUserable()->where('id', '!=' ,auth()->user()->id)->orderBY('created_at', 'desc')->paginate(10);
        return (request()->expectsJson()) ? response()->json($users) : view('delgont::users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //get default passwords for admin creattion --> FS

        return view('delgont::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $data = $request->validated();

        //Creating new admin
        $admin = new Admin();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;

        //saving admin to the db
        return $saved = $admin->save();

        $admin->user()->create([
            'name' => $request->username,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        return (request()->expectsJson()) ? response()->json(['message' => 'Admin created successfully']) : back()->withInput()->with('created', 'Admin Created successfully');
    }

    /**
     * Display the specified Admin.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::withUserable()->with(['roles'])->where('name', $username)->firstOrFail();
        return (request()->expectsJson()) ? response()->json($admin) : view('delgont::users.show', compact(['user']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAdminRequest $request, $id)
    {
        $data = $request->validated();

        $admin = Admin::with('user')->findOrFail($id);
        
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->save();

        $admin->user()->update([
            'name' => $request->username,
            'email' => $request->email
        ]);

        return ($request->expectsJson()) ? response()->json([
            'message' => 'Admin details updated successfully',
            'admin' => $admin
        ]) : back()->withInput()->with('updated', 'Admin Edited successfully.');
    }

    /**
     * Completelt remove the specified admin from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        
        return (request()->expectsJson()) ? response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully'
        ], 200) : back()->with('deleted', 'Admin Deleted successfully.');

    }

    public function table()
    {
        $paginated = true;
        $admins = Admin::where('id', '!=', Auth(config('Cms.base.auth_guard', 'admin'))->user()->id)->orderBY('created_at', 'desc')->getAdmins(true, 4);
        return view('Cms::core.includes.tables.listAdminsTable', compact(['admins']));
    }


    public function changePassword(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'required|min:6,max:12|confirmed',
        ]);
        $admin = Admin::with('user')->find($id);
        $admin->user()->update([
            'password' => bcrypt($request->password)
        ]);
        return (request()->expectsJson()) ? response()->json([
            'message' => 'Password changed successfully'
        ], 200) : back()->withInput()->with('updated', 'Password updated successfully');
    }

}
