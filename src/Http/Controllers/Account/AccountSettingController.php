<?php

namespace Delgont\Cms\Http\Controllers\Account;

use Delgont\Lad\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Account\Account;

class AccountSettingController extends Controller
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
        return (request()->expectsJson()) ? response()->json(['settings' => 'Hello']) : view('delgont::account.settings.index');
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
    
}
