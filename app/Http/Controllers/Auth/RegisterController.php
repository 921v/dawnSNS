<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/login';

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
    public function validator(Request $request)
    {
        return Validator::make($data,
            [
                'username' => ['required','string','length:{minimum:4,maximum:12}'],
                'mail' => ['required','string','email','length:{minimum:4,maximum:12}','unique:users'],
                'password' => ['required','alpha_num','length:{minimum:4,maximum:12}'],
                'password-confirm' => ['required','length:{minimum:4,maximum:12}','same:password'],
            ],
            [
                'username.required' => '必須項目です',
                'username.length:{minimum:4,maximum:12}' => '4文字以上12文字以内で入力してください',
                'mail.required' => '必須項目です',
		        'mail.email' => 'メールアドレスではありません',
		        'password.required' => '必須項目です',
		        'password.length:{minimum:4,maximum:12}' => '4文字以上12文字以内で入力してください',
		        'password-confirm.required' => '必須項目です',
		        'password-confirm.length:{minimum:4,maximum:12}' => '4文字以上12文字以内で入力してください',
		        'password-confirm.same' => 'パスワードと確認用パスワードが一致していません',
                ]
        );
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
            $data = $request->input();
            $this->create($data);
            return redirect('added');
        }
        return view('auth.register');
    }

    public function added(){
        return view('auth.added');
    }
}
