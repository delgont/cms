<?php

namespace Delgont\Cms\Http\Controllers\Account;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class AccountController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display admin account info.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = auth()->user();
        $activityLog = $account->activityLog()->orderBy('created_at', 'desc')->limit(2)->get();
        return (request()->expectsJson()) ? response()->json(['account' => $account, 'activityLog' => $activityLog]) : view('delgont::account.index', compact(['account', 'activityLog']));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showStatus()
    {
        return view('lad::account.status');
    }

   

    public function updateAvator(Request $request)
    {
        $request->validate([
            'avator' => 'required||mimes:jpeg,png,jpg|max:2048'
        ]);

        auth()->user()->avator()->updateOrCreate(['avatorable_id' => auth()->user()->id],[
            'url' => 'storage/'.request()->avator->store('avators', 'public')
        ]);

        return ($request->expectsJson()) ? response()->json(['success' => true], 200) : back()->withInput()->with('updated', 'Avator changed successfully');
    }
    
}
