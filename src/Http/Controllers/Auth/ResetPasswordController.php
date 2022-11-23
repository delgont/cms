<?php

namespace Stephendevs\Lad\Http\Controllers\Auth;


use Stephendevs\Lad\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


use Stephendevs\Lad\Models\Admin\Admin;

use  Stephendevs\Lad\Notifications\Admin\ResetPassword;

use Illuminate\Foundation\Auth\ResetsPasswords;



class ResetPasswordController extends Controller
{
    use ResetsPasswords;

     /*
    |--------------------------------------------------------------------------
    | Reset Password Controller For Admin
    |--------------------------------------------------------------------------
    |
    | This controller handles password reset for admins to the applications dashboard.
    |
    */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('lad::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function index()
    {
        return view('lad::auth.resetpassword');
    }

 



    protected function guard()
    {
        return Auth::guard('user');
    }

    public function broker()
    {
        return Password::broker('users');
    }

}
