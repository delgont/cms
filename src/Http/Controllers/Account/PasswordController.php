<?php

namespace Delgont\Cms\Http\Controllers\Account;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Delgont\Cms\Notifications\PasswordChangedNotification;

use App\User;

class PasswordController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        return view('delgont::account.password.index');
    }
 
    public function update(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required|password',
            'password' => 'required|min:6,max:12|confirmed',
        ],[
            'old_password.required' => 'Enter your old password'
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);
        auth()->user()->notify(new PasswordChangedNotification());
        Auth::logout();
        return redirect()->route('delgont.account');
    }
    
}
