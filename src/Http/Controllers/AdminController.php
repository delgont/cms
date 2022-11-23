<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;

use Delgont\Cms\Http\Requests\AdminRequest;
use Delgont\Cms\Http\Requests\EditAdminRequest;
use Illuminate\Http\Request;


use Delgont\Cms\Models\Activity\ActivityLog;
use Illuminate\Support\Str;

use App\User;

use Delgont\Cms\Models\Admin\Admin;



class AdminController extends Controller
{
    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(4);
        return (request()->expectsJson()) ? response()->jsonp($admins) : view('delgont::admins.index', compact(['admins']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //get default passwords for admin creattion --> FS

        return view('delgont::admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $admin = new Admin();

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;

        $admin->save();

        $admin->user()->create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        ($request->hasFile('avator')) ? $admin->user->avator()->create(['url' => 'storage/'.request()->avator->store(config('delgont.media_dir', 'media'), 'public')]) : '';

        return back()->withInput();

    }

    /**
     * Display the specified Admin.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
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
    }

    /**
     * Completelt remove the specified admin from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    public function table()
    {
       
    }


    public function changePassword(Request $request, $id)
    {
        
    }

}
