<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth;
class ShopController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    function __construct(){
       // $this->middleware('auth');
    }

    public function index(Request $req){
        $products = DB::table('Products')->get();
        return view('originalhome')->with(['products'=>$products]);
    }

    public function shop(Request $req)
    {
        return view('shop');
    }

    public function cart(Request $req)
    {
        return view('cart');
    }

    public function shops(Request $req)
    {
        return view('shop-single');
    }

    public function checkout(Request $req)
    {
        return view('checkout');
    }

    public function about(Request $req)
    {
        return view('about');
    }

    public function thank(Request $req)
    {
        return view('thankyou');
    }

    public function login(Request $req){
        if(!Auth::user())
            return view("login");
            else
            return redirect()->intended('');
    }

    public function register(Request $req){
       
        return view("register");
    }

    public function login_post(Request $req){
        $arr = array();
        $arr["email"]=$req->email;
        $arr["password"]=$req->password;
        $pass = $req->pass;
        if(Auth::attempt($arr)){
            
            return response()->json(['success'=> !!Auth::user()]);
        } else{
            return response()->json(['success'=> !!Auth::user(),'err' => ' user not found ']);
        }

        
    }
    public function delete_user(Request $req){
        Auth::user()->delete();
        //Auth::logout();
        return redirect()->intended('');
    }
    public function register_post(Request $req){
        $arr = array();
        $arr["email"]=$req->email;
        $arr["name"]=$req->name;
        $pass = $req->pass;
        $cpass = $req->cpass;
        if($pass === $cpass){
            $arr["password"] = $pass;
            $customer = Customer::create($arr);
            if(Auth::attempt($customer)){
                return redirect()->intended('');
            }
        }
    }

    public function logout(Request $req){
        Auth::logout();
        return redirect()->intended('');
    }
    private function create_session_schema(){
        Schema::create('sessions', function ($table) {
            $table->string('id')->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity');
        });
    }
}
