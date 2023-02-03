<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
                'username' => ['required','string','between:4,12'],
                'mail' => ['required','string','email','between:4,12','unique:users'],
                'password' => ['required','alpha_num','between:4,12','confirmed'],
                'password-confirm' => ['required'],
            ],);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mail'],
            'password' => bcrypt($data['password']),
        ]);
    }


    // public function registerForm(){
    //     return view("auth.register");
    // }

    public function register(Request $request){
        if($request->isMethod('post')){
            $request->validate([
                'username' => 'required|string|min:4|max:12',
                'mail' => 'required|string|email|min:4|max:12|unique:users',
                'password' => 'required|string|min:4|max:12|confirmed|unique:users'
            ]);
            $data = $request->input();
            $this->create($data);
            return redirect('added');
        }
        return view('auth.register');
    }

    public function added(){
        $user_name = DB::table('users')->latest()->value('username');
        return view("auth.added", ['user_name' => $user_name]);
    }
}
