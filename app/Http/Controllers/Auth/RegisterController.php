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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Carbon\Carbon;

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

        $captcha=DB::table('captcha')->first();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify?secret=$captcha->key&response=$response",
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
            'cpf' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'policy_accept' =>['required', 'accepted'],
            'g-recaptcha-response' => 'required',
        ],
        [
            'cpf.unique' => 'Este CPF já existe em nosso sistema.',
            'email.unique' => 'Já existe um cadastro com este e-mail em nosso sistema.',
            'email.email' => 'Email inválido.',
            'policy_accept.accepted' => 'Você precisa aceitar nossa política para continuar.',
            'policy_accept.required' => 'Você precisa aceitar nossa política para continuar.',
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
        $role=Role::where('name','=','candidate')->first();
        if (empty($role))
            $role = Role::create(['name' => 'candidate']);

        $permission=Permission::where('name','=','profile')->first();
        if (empty($permission))
            $permission = Permission::create(['name' => 'profile']);

        $role->givePermissionTo($permission);

        $user= new User;
        $user->name=$data['name'];
        $user->email=$data['email'];
        $user->cpf=str_replace([".","-","/"],"",$data['cpf']);
        $user->password=Hash::make($data['password']);
        $user->policy_accept=$data['policy_accept'];
        $user->policy_accept_date=now();
        $user->save();

        $candidate=new Candidate;
        $candidate->user_id=$user->id;
        $candidate->name=$data['name'];
        $candidate->cpf = str_replace([".","-","/"],"",$data['cpf']);
        $candidate->email=$data['email'];
        $candidate->save();

        $user->assignRole('candidate');
        return $user;
    }

    public function register(Request $request)
    {
        $data=$request->all();
        $data['cpf'] = str_replace([".","-","/"],"",$data['cpf']);
        $validator = $this->validator($data);

        if ($validator->fails()) {
            return Redirect::to(url('/register'))
                ->withErrors($validator)
                ->withInput();
        }

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

        // cria usuário
        event(new \Illuminate\Auth\Events\Registered(
            $user = $this->create($request->all())
        ));

        // login
        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }
}
