<?php

namespace Delgont\Cms\Http\Controllers\Auth;


use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

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
        $this->redirectTo = config('delgont.route_prefix', '/dashboard');
    }


    public function index()
    {
        return view('delgont::auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
        ], $request->get('remember'))){
            return redirect()->intended(config('lad.route_prefix', '/dashboard'));
        }
        
        return back()
        ->withInput($request->only('email','remember'))
        ->with('failed', true)
        ->with('message', 'Invalid Credentials.');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('delgont.login')->with('success', 'You have successfully Logged Out.');
    }

    public function resetPassword()
    {
        return view('delgont::auth.resetpassword');
    }

    public function resetPwd(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $find = User::where('email', $request->email)->get(['email']);


        if(count($find) == 1){
            $email = $find[0]->email;
            return view('delgont::auth.resetpasswordcode', compact(['email']));
        }else{
            return back()->withInput()->with('failed', true)->with('message', 'Invalid Email Address');
        }

    }

    
    /**
     * API Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user(); 

            $success['token'] =  $user->createToken('token')->accessToken; 
            return response()->json($success, 200); 
        }
        return response()->json(['error'=>'Unauthenticated Please check your email and password'], 401); 
    }

    public function apiLogout(Request $request)
    {
        $success['message'] = "Successfully logged out.";
        $error = "Something went wrong.";

        $logout = $request->user()->token()->revoke();
        return ($logout) ? response()->json($success, 200) : response()->json(['error' => $error], 401);
    }

}
