<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Invoice;

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

    function ProcessOrder(Request $req){



    }

    function ProcessCheckout(Request $req){

        $billing = self::Extract($req,'billing','company','address_sec');
        $shipping = self::Extract($req,'shipping','company','address_sec','email');
        if(!$billing || !$shipping){
            return view('checkout')->with(['error'=>'Validation failed for checkout details. Please review them and try again.']);
        }

        if($req->c_create_account && $billing->email){
            $arr["email"] = $billing->email;
            $arr["password"] = $req->c_account_password;
            $customer = Customer::create($arr);
        }

        switch(strtolower($req->trigger_type)) {
            case 'card':{
               return MastercardPay($req,$billing,$shipping);
            }break;
            case 'ramburs':{
               return RambursPay($req,$billing,$shipping);
            }break;
            case 'paypal':{
                return PayPalPay($req,$billing,$shipping);
            }break;
            default:{
                return view('checkout')->with(['error'=>'Validation failed for some checkout details. Please review and try again.']);
            }
        }

    }
    //c_create_account c_account_password
//
    function PayPalPay(Request $req){

    }

    function MastercardPay(Request $req){

    }

    function RambursPay(Request $req){

    }

    private function GenerateInvoice(Invoice $invoice_model){

    }

    private function Extract($req,$model,...$null_allowed_fields){

        switch (strtolower($model)){
            case 'billing':{
                $billing = new Object();
                $billing->first_name = $req->c_fname;
                $billing->last_name = $req->c_lname;
                $billing->company = $req->c_companyname;
                $billing->address = $req->c_address;
                $billing->address_sec = $req->c_address_sec;
                $billing->state = $req->c_state_country;
                $billing->zip = $req->c_postal_zip;
                $billing->email = $req->c_email_address;
                $billing->phone_number = $req->c_phone;
                
                $product_ids = session('cart_products');
                $billing->ordered_prods = DB::table('Products')->where('product_id','in',$product_ids)->get();
                
                if(count($billing->ordered_prods) != count($product_ids))
                    return false;
                foreach($billing as $key=>$prop){
                    if(!array_search($key,$null_allowed_fields) && !$prop ){
                     
                        return false;
                    }
                }

                return $billing;
                
            }break;

            case 'shipping':{
                
                if(!$req->c_ship_different_address){
                    return self::Extract($req,'billing','address_sec','email','company');
                }else{
                    $shipping = new Object();
                    $shipping->first_name = $req->c_diff_fname;
                    $shipping->last_name = $req->c_diff_lname;
                    $shipping->company = $req->c_diff_companyname;
                    $shipping->address = $req->c_diff_address;
                    $shipping->address_sec = $req->c_diff_address_sec;
                    $shipping->state = $req->c_diff_state_country;
                    $shipping->zip = $req->c_diff_postal_zip;
                    $shipping->phone_number = $req->c_diff_phone;
                    
                    $product_ids = session('cart_products');
                    $shipping->ordered_prods = DB::table('Products')->where('product_id','in',$product_ids)->get();
                    
                    if(count($shipping->ordered_prods) != count($product_ids))
                        return false;
                    
                    foreach($shipping as $key=>$prop){
                        if(!array_search($key,$null_allowed_fields) && !$prop){
                           
                            return false;
                        }
                    }

                    return $shipping;
                }

            }break;
        }
       /*
c_fname
c_lname
c_companyname
c_address
c_address_sec
c_state_country
c_postal_zip
c_email_address
c_phone
_token
c_create_account
c_account_password
c_ship_different_address
c_diff_fname
c_diff_lname
c_diff_companyname
c_diff_address
c_diff_address_sec
c_diff_state_country
c_diff_postal_zip
c_diff_phone

       */
    }

}