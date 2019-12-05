<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    function __construct(){
        $this->middleware('auth');
    }


    function saveProfile(Request $req){
        
       if( Auth::user()){
        $user = Auth::user();
        $user->name = $req->c_nickname;
        $user->first_name = $req->c_fname;
        $user->last_name = $req->c_lname;
        $user->zip = $req->c_postal_zip;
        $user->state = $req->c_state_country;
        $user->address = $req->c_address;
        $user->address_sec = $req->c_address_sec;
        $user->phone_number = $req->c_phone;
        $user->save();
        return response()->json(['scs'=> true]);
    
        }


    }


    public function profile(Request $req){
        $user = Auth::user();
        $active_orders = DB::table('Orders')->where(['customer_id'=>$user->customer_id,'order_status_code'=>1])->get(); //active orders
        
        foreach($active_orders as $active){
           
            $active->total =  isset($active->total)?$active->total:0;
            $order_items =  DB::table('Order_Items')->where(['order_id'=>$active->order_id,'order_item_status_code'=>1])->pluck('order_item_price');
            for($i = 0; $i<count($order_items); $i++){
                $active->total = $active->total + $order_items[$i];
            }
        }
        $delivered_orders = DB::table('Orders')->where(['customer_id'=>$user->customer_id,'order_status_code'=>2])->get(); //delivered orders
        foreach($delivered_orders as $delivered){
            $delivered->total =  isset($delivered->total)?$delivered->total:0;
            $order_items =  DB::table('Order_Items')->where(['order_id'=>$delivered->order_id,'order_item_status_code'=>2])->pluck('order_item_price');
            for($i = 0; $i<count($order_items); $i++){
                $delivered->total = $delivered->total + $order_items[$i];
            }
        }

        

        return view('profile')->with(['active_orders'=>$active_orders,'delivered_orders'=>$delivered_orders]);
    }


    function ShowOrder(Request $req){
        $user = Auth::user();
        $order_awb = $req->id;
        $order = DB::table('Orders')->where('AWB',strtoupper($order_awb))->first();
        if($order !== null && $user->customer_id === $order->customer_id){
            // Set up the order details
            $order_items =  DB::table('Order_Items')->where(['order_id'=>$order->order_id,])->get();
            foreach($order_items as $key => $item){
               $product =  DB::table('Products')->where('product_id',$item->product_id)->first();
               $order_items[$key] = (object) array_merge( (array) $product, (array) $item); 
               
            }

            //Set up the billing details

            $invoice = DB::table('Invoices')->where('order_id',$order->order_id)->first();
            $shipment = DB::table('Shipments')->where('order_id',$invoice->order_id)->first();
        

            return view('order')->with(['ordered_items'=>$order_items,'order'=>$order,'invoice'=>$invoice,'shipment'=>$shipment]);
        } 

        return abort(404,'Page not found.');
        
    }

    


}
