<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $redirectback="";
        if (!empty($request->input('redirectback')))
            $redirectback=$request->input('redirectback');

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $logged_in=Auth::user();
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
            $redirlink="/profile";
            if ($role=="admin")
                $redirlink='/home';
            else if (!empty($redirectback))
                $redirlink=$redirectback;
            return redirect($redirlink);
        }
        return redirect('/login')->withErrors(['email'=>'Credenciais inválidas']);
    }
}
