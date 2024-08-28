<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'UserName';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required',
            'Password' => 'required',
        ]);
    }

    public function login(Request $request){
        $this->validateLogin($request);

        if(Auth::attempt(['UserName' => $request->UserName, 'password' => $request->Password])) {
            return redirect()->route('home');
        }  else {
            $this->incrementLoginAttempts($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
