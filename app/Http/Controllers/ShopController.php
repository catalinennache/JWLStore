<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\PaymentController;

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

        $rw = isset($req->rw)?$req->rw:array();
        return view('originalhome')->with(['rws'=>$rw]);
    }

    public function shop(Request $req)
    {   $page = $req->page>0?$req->page-1:0;
        $filter = array();
        $filter_active = $req->cats || $req->prices || $req->tags || $req->sizes; 
       
        $filter["cats"] = explode(',',$req->cats);
        $filter["prices"] = explode(',',$req->prices);
        $filter["tags"] = explode(',',$req->tags);
        $filter["sizes"] = explode(',',$req->sizes);
        $filter["sort"] = $req->sort;
        //out_of_stock e de fapt in_stock !!!!
        $out_of_stock = array_unique((array) DB::table('Product_sizes')->join('Products','Product_sizes.product_id','=','Products.product_id')->where('Product_sizes.Quantity_AV','>',0)->select('Product_sizes.product_id')->groupby('Product_sizes.product_id')->get()->pluck('product_id'));
        $out_of_stock = (array)$out_of_stock[array_keys($out_of_stock)[0]];
     
        if($filter_active){
            $getProdID = function($elem){
                return $elem->product_id;
            };
            
            $products = DB::table('Product_sizes')->join('Products','Product_sizes.product_id','=','Products.product_id')->where('Product_sizes.Quantity_AV','>',0);
            if($req->cats){
                if(count($filter["cats"]) != 1){
                    $products = $products->whereIn('Products.product_type_code',$filter["cats"]);
                   
                }else {
                    $products = $products->where('Products.product_type_code','=',$filter["cats"][0]);
                }
            }

            if($req->sizes){
                $products = $products->whereIn('size_id',$filter["sizes"]);
            }
          
            if($req->prices){
               $products = $products->whereRaw(' ((Products.product_price > ? and Products.product_price < ?) or (Products.product_new_price > ? and Products.product_price < ?))',[$filter["prices"][0],$filter["prices"][1],$filter["prices"][0],$filter["prices"][1]]);
            
            }
            
            $products = $products->select('Product_sizes.product_id')->groupby('Product_sizes.product_id')->get()->pluck('product_id');
  
            $products = DB::table('Products')->whereIn('product_id',$products);
           
            if($req->tags){
                $products = DB::table('Products_tags')->select('Products.product_id')->whereIn('Products_tags.tag_id',$filter["tags"])->whereIn('Products_tags.product_id',array_map($getProdID,$products->get()->toArray()))->groupby('Products.product_id')
                ->join('Products','Products.product_id','=','Products_tags.product_id')->get();
              
                $products = DB::table('Products')->whereIn('product_id',array_map($getProdID,$products->toArray()));
            }
            //DB::select("select product_id from Product_sizes group by product_id having sum(Quantity_AV) = 0")[0];
        
             if(isset($filter["sort"])){
                if($filter["sort"] == 2)
                    $products = $products->orderByRaw('product_price ASC')->skip(9*$page)->take(9)->get();
                else if($filter["sort"] == 1)
                        $products = $products->whereIn('product_id', (array)$out_of_stock)->orderByRaw('product_price DESC')->skip(9*$page)->take(9)->get();
                    else
                        $products = $products->whereIn('product_id', (array)$out_of_stock)->skip(9*$page)->take(9)->get();

             }else{
              $products = $products->whereIn('product_id', (array)$out_of_stock)->skip(9*$page)->take(9)->get();
             }
              $pages = floor($products->count()/9);
              if(!$pages)
                $pages++;
        }else{
           
            //DB::select("select product_id from Product_sizes group by product_id having sum(Quantity_AV) = 0")[0];
          
             
            $products = DB::table('Products')->whereIn('product_id',$out_of_stock)->skip(9*$page)->take(9)->get();
            $pages = floor(count($products)/9);
            if(!$pages)
            $pages++;
        }
         
        $categories = DB::table('Products')->select('product_type_code')->groupby('product_type_code')->get();
        
        $cat0 = array();
        foreach($categories as $ct){
        $cat0[] = DB::table('Ref_Product_Types')->where('product_type_code',$ct->product_type_code)->first();
        
        }
        $cats = array();

        foreach($cat0 as $category){
          $prds = (DB::table('Products')->where('product_type_code',$category->product_type_code)->get());
          $prd_ids = array();
          $count = 0;
            foreach($prds as $prd)
                if( DB::table('Product_sizes')->where('product_id',$prd->product_id)->count()>0
                 && DB::select("select sum(Quantity_AV) as cnt from Product_sizes where product_id = '$prd->product_id' group by product_id")[0]->cnt >0)
                    $count++;
                
           $cats[$category->product_type_category] = ['count'=>$count,'id'=>$category->product_type_code];
        }
     
        $sizes = DB::table('Product_sizes')->select(DB::raw('count(*) as size_count, size_id'))->where('Quantity_AV','>',0)->groupby('size_id')->havingRaw('count(*) > 0')->get();
        foreach($sizes as $size){
            $size->description = DB::table('Sizes')->select('description')->where('size_id',$size->size_id)->first()->description;
            
        }
     
        $tags = DB::table('Products_tags')->select(DB::raw('count(*) as tag_count, tag_id'))->whereIn('product_id',$out_of_stock)->groupby('tag_id')->get();
        foreach($tags as $tag){
            $tag->name = DB::table('Tags')->select('name')->where('id',$tag->tag_id)->first()->name;
        }

        
   
        return view('shop')->with(['products'=>$products,'pages'=>$pages,'active_tab'=>$page,'cats'=>$cats,'sizes'=>$sizes,'tags'=>$tags,'filters'=>$filter]);
    }



    public function cart(Request $req)
    {    $cart = session('cart_products');
        return view('cart')->with(['cart'=>$cart]);
    }

    public function shops(Request $req)
    {   
        if(!isset($req->id)){
            return abort(404);
        }
        $products = DB::table('Products')->get();
        $product_id = $req->id;
        
        $prod = DB::table('Products')->where('product_id',$product_id)->first();
        $prod_sizes = DB::table('Product_sizes')->join('Sizes','Product_sizes.size_id','=','Sizes.size_id')
                                                ->where('product_id',$product_id)->get();
        $cat= DB::table('Ref_Product_Types')->where('product_type_code',$prod->product_type_code)->first();
        $arr = $req->session()->has('recently_viewed')?session('recently_viewed'):array();
        
        if(is_array($arr) && !array_search($product_id,$arr)){
            if(count($arr)>4) 
                array_pop($arr);
      
    
        }else {
            $arr2 = array();
            array_push($arr2,$arr);
            $arr = $arr2;
  
    
        }
        $arr[] = $product_id;
      
        $req->session()->put('recently_viewed', $arr);

        $rw = isset($req->rw)?$req->rw:array();
        return view('shop-single')->with(['products'=>$products,'prod'=>$prod,'sizes'=>$prod_sizes,'rws'=>$rw,'cat'=>$cat]);
    }

  

    public function about(Request $req)
    {
        return view('about');
    }

    public function thank(Request $req)
    {
        $allowed_origin = '/checkout';
        if(isset($_SERVER['HTTP_REFERER'])) {
            $origin = parse_url($_SERVER['HTTP_REFERER'])['path'];
            if(substr($origin, 0 - strlen($allowed_origin)) == $allowed_origin) {

            return view('thankyou');
            }
        }

        return redirect()->intended('');
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
        $req->session()->forget('SU');
        return redirect()->intended('');
    }

    public function billing(Request $req){

        $allowed_origins = ['/cart','/checkout','/billing','/billing?'];
        if(isset($_SERVER['HTTP_REFERER'])) {
            $origin = parse_url($_SERVER['HTTP_REFERER'])['path'];
        
            if(array_search($origin ,$allowed_origins) !== false ) {

                
                $cart = $req->session()->get('cart_products');
                $transport = DB::table('Couriers')->get()[0];
                
                if($req->session()->has('cart_products') && count($cart)>0){
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
                    header("Pragma: no-cache"); // HTTP 1.0.
                    header("Expires: 0");
                    return view('billing')->with(['cart'=>$cart,'transport'=>$transport]);
                }

            }else{
                error_log("invalid origin detected ".$origin);
            }
        }

        return redirect()->intended('/');
    }

    public function checkout(Request $req)
    {  
        
        $allowed_origin = '/billing';
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
            $arr_cart_products[$prod_id][$size] = (isset($arr_cart_products[$prod_id][$size])?0:0) + $pcs;
            
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
