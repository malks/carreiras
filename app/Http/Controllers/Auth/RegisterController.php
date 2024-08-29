<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Candidate;
use App\Mail\Register;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    private function validCaptcha($response)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify?secret=6LfI3jEqAAAAACCiQl9QIs6PgmdpADt2UftYI5Wx&response=$response",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "secret":"6LeDKVMmAAAAAF1ZAASR79OFby6iqi0yZDnnM4i1",
    "response":"'.$response.'"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'policy_accept' =>['required', 'min:1'],
            'g-recaptcha-response' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $response="-";
        if (!empty($data['g-recaptcha-response']))
            $response = $data['g-recaptcha-response'];
        
        $response_validated = $this->validCaptcha($response);

        if (!empty($response_validated)) {
            $json = json_decode($response_validated);
            if (!isset($json->success) || $json->success != true) {
                return Redirect::to(url('/register'))->with('error', "Necessário fazer a validação do Captcha.")
                    ->withInput();
            }
        }

        $role=Role::where('name','=','candidate')->first();
        if (empty($role))
            $role = Role::create(['name' => 'candidate']);

        $permission=Permission::where('name','=','profile')->first();
        if (empty($permission))
            $permission = Permission::create(['name' => 'profile']);

        $role->givePermissionTo($permission);

        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'policy_accept' => $data['policy_accept'],
        ]);

        $candidate=new Candidate;
        $candidate->user_id=$user->id;
        $candidate->name=$data['name'];
        $candidate->email=$data['email'];
        $candidate->save();

        Mail::to($candidate->email,$candidate->name)->send(new Register($candidate));
        $user->assignRole('candidate');
        return $user;
    }
}
