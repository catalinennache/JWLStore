<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

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
    protected function validator(array $data)
    {   $email = substr($data['email'],0);
        $usr = DB::table('Customers')->where('email',$email)->first();
       if($usr) error_log(">> before alteration ".$usr->activated." >> "); 

        if($usr && $usr->activated == 0){
            $obj_user = User::find($usr->customer_id);
            $obj_user->email .="m";
            error_log("email altered >> ".$obj_user->email);
            $obj_user->save();
            Auth::logout();
           $validation =  ['required', 'string', 'email', 'max:255'];

        }else {
            $validation =  ['required', 'string', 'email', 'max:255', 'unique:Customers'];
            error_log(">> else validation ");
        }

    //  if($usr)  error_log("after ".$obj_user->email);
   
        error_log($data['email']);
        $result = Validator::make($data, [
        'email' =>$validation,
        'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        error_log($result->fails());
        
       if($usr) error_log(">> before restore ".$usr->activated." >> "); 

        if($usr && $usr->activated == 0){
            $obj_user = User::find($usr->customer_id);
            $obj_user->email = substr($obj_user->email,0,strlen($obj_user->email)-1);
            error_log("email back to normal ".$obj_user->email);
            $obj_user->save();
            Auth::logout();
        }
        error_log("after ");
   
        return $result;
    }

    protected function failedValidation(Validator $validator)
    {   
       error_log("validation failed >> ");
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   error_log("create function >>");
       $usr = DB::table('Customers')->where('email',$data['email'])->first();
       if($usr && $usr->activated == 0){

            $obj_user = User::find($usr->customer_id);
            $obj_user->password = Hash::make($data['password']);;
            $obj_user->activated = 1;
            $obj_user->save(); 

            return User::find($usr->customer_id);
       }
            else return User::create([
            
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
