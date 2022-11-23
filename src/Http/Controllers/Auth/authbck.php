<?php

namespace Stephendevs\Lad\Http\Controllers\Auth;


use Stephendevs\Lad\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Stephendevs\Lad\Models\Admin\Admin;


class AuthController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admins to the applications dashboard and
    | redirecting them to login screen if not logged in.
    |
    */

    public function __construct()
    {
        /**
        * Where to redirect users after login.
        * @var string
        */
        $this->redirectTo = config('lad.route_prefix', '/dashboard');
        $this->middleware('guest:'.config('lad.auth_guard', 'admin'))->except(['logout','resetPassword','resetPwd']);
    }


    public function index()
    {
        return view('lad::auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        if(Auth::guard(config('lad.auth_guard', 'admin'))->attempt([
            'email' => $request->email, 
            'password' => $request->password
        ], $request->get('remember'))){
            return redirect()->intended('/dashboard');
        }
        //return $request->only('email','remember');
        //return back()->withInput($request->only('email','remember'));
        return back()
        ->withInput($request->only('email','remember'))
        ->with('failed', true)
        ->with('message', 'Invalid Credentials.');
    }


    protected function guard()
    {
        return Auth::guard(config('lad.auth_guard', 'admin'));
    }

    public function logout(Request $request)
    {
        Auth::guard(config('lad.auth_guard', 'admin'))->logout();
        return redirect()->route('lad.login')->with('success', 'You have successfully Logged Out.');
    }

    public function resetPassword()
    {
        return view('phoebi::auth.resetpassword');
    }

    public function resetPwd(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $find = Admin::where('email', $request->email)->get(['email']);


        if(count($find) == 1){
            $email = $find[0]->email;
            return view('lad::auth.resetpasswordcode', compact(['email']));
        }else{
            return back()->withInput()->with('failed', true)->with('message', 'Invalid Email Address');
        }

    }



}
