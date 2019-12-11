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
    {   $page = $req->page?$req->page:0;
        $products = DB::table('Products')->skip(9*$page)->take(9)->get();
        $pages = floor(DB::table('Products')->count()/9)+1;
        $categories = DB::table('Products')->select('product_type_code')->groupby('product_type_code')->get();
       
        $cat0 = array();
        foreach($categories as $ct){
        $cat0[] = DB::table('Ref_Product_Types')->where('product_type_code',$ct->product_type_code)->first();}

        $cats = array();

        foreach($cat0 as $category){
           $cats[$category->product_type_category] = DB::table('Products')->where('product_type_code',$category->product_type_code)->count();
        }
   
        return view('shop')->with(['products'=>$products,'pages'=>$pages,'active_tab'=>$page,'cats'=>$cats]);
    }

    public function cart(Request $req)
    {    $cart = session('cart_products');
        return view('cart')->with(['cart'=>$cart]);
    }

    public function shops(Request $req)
    {   
        $products = DB::table('Products')->get();
        $product_id = $req->id;
        $prod = DB::table('Products')->where('product_id',$product_id)->first();
        $prod_sizes = DB::table('Product_sizes')->join('Sizes','Product_sizes.size_id','=','Sizes.size_id')
                                                ->where('product_id',$product_id)->get();
     
        return view('shop-single')->with(['products'=>$products,'prod'=>$prod,'sizes'=>$prod_sizes]);
    }

    

    public function about(Request $req)
    {
        return view('about');
    }

    public function thank(Request $req)
    {
        return view('thankyou');
    }

    public function profile(Request $req){
        return view('profile');
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

    public function Order(Request $req){

        return view("order");
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

    public function checkout(Request $req)
    {  
        $allowed_origin = '/cart';
        if(isset($_SERVER['HTTP_REFERER'])) {
            $origin = parse_url($_SERVER['HTTP_REFERER'])['path'];
            if(substr($origin, 0 - strlen($allowed_origin)) == $allowed_origin) {

                
                $cart = $req->session()->get('cart_products');
                $transport = DB::table('Couriers')->get()[0];
            
                if($req->session()->has('cart_products') && count($cart)>0)
                    return view('checkout')->with(['cart'=>$cart,'transport'=>$transport]);
            }
        }

        return redirect()->intended('/');
            
        
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

    function addtocart(Request $req){
        $prod_id = $req->id;
        $pcs = $req->pcs;
        $size = $req->size;
        if($prod_id>0 && DB::table('Products')->where('product_id')->get() 
            && DB::table('Product_sizes')->where(['product_id'=>$prod_id,'size_id'=>$size])->first() 
            && DB::table('Product_sizes')->where(['product_id'=>$prod_id,'size_id'=>$size])->pluck('Quantity_AV')->first() > 0){
            $arr_cart_products = $req->session()->has('cart_products')?session('cart_products'):array();
            $arr_cart_products[$prod_id] = (isset($arr_cart_products[$prod_id])?$arr_cart_products[$prod_id]:array());
            $arr_cart_products[$prod_id][$size] = (isset($arr_cart_products[$prod_id][$size])?$arr_cart_products[$prod_id][$size]:0) + $pcs;
            
            $req->session()->put('cart_products', $arr_cart_products);
            return response()->json(['scs'=>true]);
        }

        return response()->json(['scs'=>false]);
    }

    function removeFromCart(Request $req){
        $id = $req->id;
        $size = $req->size;
        $cart_product = session('cart_products');
        unset($cart_product[$id][$size]);
        unset($cart_product[$id]);
        $req->session()->put('cart_products', $cart_product);
        return response()->json(['scs'=>true]);
    }

    function updateCart(Request $req){
        $prod_array = $req->data;
        $cart_product = session('cart_products');
        foreach($prod_array as $product){
            $cart_product[$product["id"]][$product["size"]] = $product["pcs"];
        }
        $req->session()->put('cart_products', $cart_product);
        return response()->json(['scs'=>true]);

    }
}
