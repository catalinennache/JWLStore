<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Invoice;
use FanCourier\fanCourier;
use FanCourier\Plugin\csv\csvItem;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Storage;
use Mail;

use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
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
    /*
  $billing->first_name = $req->c_fname;
                $billing->last_name = $req->c_lname;
                $billing->company = $req->c_companyname;
                $billing->address = $req->c_state_country.",".$req->c_city.",".$req->c_address;
                $billing->address_sec = $req->c_address_sec;
                $billing->state = $req->c_state_country;
                $billing->zip = $req->c_postal_zip;
                $billing->email = $req->c_email_address;
                $billing->phone_number = $req->c_phone;
                $billing->payment_type = $req->c_payment_method;

    */

    private function checkDataIntegrity($req){ $scs = true;
       try{
            $s_billing = self::Extract($req,'billing','company','address_sec','other_details','create_account','password');
            $s_shipping = self::Extract($req,'shipping','company','address_sec','email','other_details','create_account','password');
       
            

        $scs = $scs && (strlen($s_billing->first_name)>0);
        $scs = $scs && (strlen($s_billing->last_name)>0);
        $scs = $scs && (strlen($s_billing->address)>0);
        $scs = $scs && (strlen($s_shipping->address)>0);

        $judet_facturare = explode(',',$s_billing->address)[0];
        $localitate_facturare = explode(',',$s_billing->address)[1];
        $judet_livrare = explode(',',$s_shipping->address)[0];
        $localitate_livrare = explode(',',$s_shipping->address)[1];

        $scs = $scs && (strlen($judet_facturare)>0);
        $scs = $scs && (strlen($localitate_facturare)>0);

        $scs = $scs && (strlen($judet_livrare)>0);
        $scs = $scs && (strlen($localitate_livrare)>0);


        $scs = $scs && (is_numeric($s_billing->zip));
        $scs = $scs && (is_numeric($s_shipping->zip));
        $scs = $scs && (strlen($s_shipping->state)>0);
        $scs = $scs && (strlen($s_billing->state)>0);
        $scs = $scs && (strlen($s_billing->email)>0);
        $scs = $scs && ((substr($s_billing->phone_number,0,1) == "+" || is_numeric(substr($s_billing->phone_number,0,1))) && is_numeric(substr($s_billing->phone_number,1)));
        $scs = $scs && ((substr($s_shipping->phone_number,0,1) == "+" || is_numeric(substr($s_shipping->phone_number,0,1))) && is_numeric(substr($s_shipping->phone_number,1)));
     
        $scs = $scs && ($s_billing->payment_type > 0 && $s_billing->payment_type < 3);
        $scs = $scs && ($s_shipping->payment_type > 0 && $s_shipping->payment_type < 3);


       }
        catch(\Exception $e){ error_log($e); $scs = false;}
        
       
        return $scs;
    }

    function ProcessOrder(Request $req){
           
        $allowed_origin = '/billing';
        if(isset($_SERVER['HTTP_REFERER'])) {
            $origin = parse_url($_SERVER['HTTP_REFERER'])['path'];
            if(substr($origin, 0 - strlen($allowed_origin)) == $allowed_origin && session('cart_products')) {
               $ok = self::checkDataIntegrity($req);
                if(!$ok)
                    return redirect('/billing?error=1')->with(['error'=>'']);
             
                $billing = self::Extract($req,'billing','company','address_sec','other_details','create_account','password');
                $shipping = self::Extract($req,'shipping','company','address_sec','email','other_details','create_account','password');
                if(!$billing || !$shipping){
                    return redirect('/billing?error=1')->with(['error'=>'']);
                   // return response()->json(['error'=>" validation failed","billing"=>$billing,"shipping"=>$shipping]);
                    //return view('billing')->with(['error'=>'Validation failed for checkout details. Please review them and try again.']);
                }

               /* if($req->c_create_account && $billing->email){
                    $arr["email"] = $billing->email;
                    $arr["password"] = Hash::make($req->c_account_password);
                    $customer = Auth::create($arr);
                    Auth::attempt($customer);
                }*/
                $transport = DB::table('Couriers')->get()[0];
                if($transport){
                   $result = self::ComputeTransport($billing,$shipping);
                   if(!$result->error){
                        $shipping->shipping_price = $result->value;
                        $transport->price = $shipping->shipping_price;
                        $billing->transport = $transport;
                        $billing->total += $transport->price;
                    }else{
                        return redirect('/billing?error='.$result->error);
                    }
                }else{
                   throw new \Exception("No active courier detected");
                }
                $req->session()->put('billing', $billing);
                $req->session()->put('shipping', $shipping);
                
                $cart = $req->session()->get('cart_products');
                        
                
            try{    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
                header("Pragma: no-cache"); // HTTP 1.0.
                header("Expires: 0"); }catch(Exception $e){}        
                return view('checkout')->with(['cart'=>$cart,'transport'=>$transport,'pm'=>$billing->payment_type]);
            }
        }
        return redirect()->intended('/');
    }



    function ProcessCheckout(Request $req){

        //$billing = session('billing');
     $billing =    $req->session()->get('billing', false);
     $shipping =    $req->session()->get('shipping', false);
    
     error_log("PAYMENT DETECTED ".$billing->total);
     if($billing && $shipping){

        switch(strtolower($req->trigger_type)) {
            
            case 'card':{
               
               // $billing->payment_type = 1;
                $shipping->payment_type = 1;
               return self::cardPay($req,$billing,$shipping);
            }break;
            case 'ramburs':{
               // $billing->payment_type = 2;
                $shipping->payment_type = 2;
               return self::RambursPay($req,$billing,$shipping);
            }break;
           
            default:{
                return response()->json(['error'=>'Validation failed for some checkout details. Please review and try again.']);
            }
        }
     }else {
        return response()->json(['error'=>'Validation failed for some checkout details. Please review and try again.']);
     }

    }


    public function PrePay(Request $req){
        $prefered_method = $req->method;
        if($prefered_method !== 'card' && $prefered_method !== 'ramburs'){
            return response()->json(['error'=>'preference not recognized']);
        }
    }
    //c_create_account c_account_password
//
    function PayPalPay(Request $req){

    }

    function cardPay(Request $req,$billing_data,$shipping){
        $payload = $req->input('payload', false);
        $nonce = $payload['nonce'];

        $status = \Braintree_Transaction::sale([
        'amount' => $billing_data->total,
        'paymentMethodNonce' => $nonce,
        'options' => [
            'submitForSettlement' => True
        ]
        ]);

        if($status->success){
          
            $scs = true;
            $reason = '';
            try{
                error_log("entering internal db seq");
                $order = self::SetUpOrder($billing_data,$shipping);
                error_log("Order_ready");
                $invoice = self::SetUpInvoice($billing_data,$order);
                error_log("Invoice ready ");
                $payment = self::SetUpPayment($invoice,$order,$billing_data,$shipping);
                error_log("Payment_ready");
                $result = self::SetUpTransport($order,$shipping); 
                if($result[1]>0){
                    $order->AWB =$result[2];
                    self::updateOrder($order);
                }
                else{
                    $reason = $result[2];
                    $scs = false;
                }
                $shipment = self::SetUpShipment($order,$shipping);
                error_log("Shipment ready");
             
               
              /*  $req->session()->forget('billing');
                $req->session()->forget('shipping');
                $req->session()->forget('cart_products');*/

            }catch(Exception $e){ $scs = false;}
            if($scs){
                
                $data = array('token'=>base64_encode("$invoice->invoice_number,$invoice->email"),'email'=>$invoice->email);
                Mail::send('invoiceemail', $data, function ($message) use ($data) {
                    $message->from('john@johndoe.com', 'Silver Boutique');
                    $message->sender('silverboutiqe@gmail.ro');
                
                    $message->to($data['email'],'');
                
                
                

                
                    $message->subject('Thank you for purchasing from us!');
                
                   // $message->priority(3);
                
                  //  $message->attach('pathToFile');
                });
                
                foreach($billing_data->ordered_prods as $prod){
                    try{
                    $sz = DB::table('Product_sizes')->where(['product_id'=>$prod->product_id,'size_id'=>$prod->size])->first();
                    DB::table('Product_sizes')->where(['product_id'=>$prod->product_id,'size_id'=>$prod->size])->update(['Quantity_AV'=>$sz->Quantity_AV - $prod->cantitate]);
                    }catch(Exception $e){
                        error_log(">> exception in QT update");
                    }
                }
            }


        }
        return response()->json($status);
    }

    function testEmail(Request $req){
        $data = array('token'=>base64_encode("336445608,asdfg@gmail.com"));
        print_r($data);
        Mail::send('invoiceemail', $data, function ($message) {
            $message->from('john@johndoe.com', 'Silver Boutique');
            $message->sender('silverboutiqe@gmail.ro');
        
            $message->to('catalinenache03@gmail.com','');
        
        
        

        
            $message->subject('Thank you!');
        
           // $message->priority(3);
        
          //  $message->attach('pathToFile');
        });
        return view('invoiceemail')->with($data);
    }

    function inv(Request $req){
        $token = $req->token;

        $decoded_token = base64_decode($token);
        $csv = explode(',',$decoded_token);
        $order_number = $csv[0];
        $email = $csv[1];
        $req->session()->put('invoice_number', $order_number);
        $req->session()->put('email', $email);
        return redirect()->intended('/invoiceDownload');

    }


    function invoiceDownload(Request $req){
       
        try{ 
            $invoice_id = $req->session()->get('invoice_number', '-1');
         $email = $req->session()->get('email', '-');
         $invoice = DB::table('Invoices')->where('invoice_number',$invoice_id)->where('email',$email)->first();
         if($invoice !== null){
             // Set up the order details
             $order = DB::table('Orders')->where('order_id',$invoice->order_id)->first();
         
             $order_items =  DB::table('Order_Items')->where(['order_id'=>$order->order_id,])->get();
             foreach($order_items as $key => $item){
                $product =  DB::table('Products')->where('product_id',$item->product_id)->first();
                
                $order_items[$key] = (object) array_merge( (array) $product, (array) $item); 
                $order_items[$key]->size_desc = DB::table('Sizes')->where('size_id',$order_items[$key]->size)->pluck('size')->first();
             }
 
             //Set up the billing details
 
             $invoice = DB::table('Invoices')->where('order_id',$order->order_id)->first();
             $shipment = DB::table('Shipments')->where('order_id',$invoice->order_id)->first();
         
 
             return view('order')->with(['ordered_items'=>$order_items,'order'=>$order,'invoice'=>$invoice,'shipment'=>$shipment]);
         } 
     }catch(Exception $e){}
         return abort(404,'Page not found.');
     }

    
    function RambursPay(Request $req,$billing_data,$shipping){
        // $scs = true;
        // $reason = '';
        // try{
        //     $order = self::SetUpOrder($billing_data,$shipping);
        //     $invoice = self::SetUpInvoice($billing_data,$order);
        //     $payment = self::SetUpPayment($invoice,$order,$billing_data,$shipping);
        //     $shipment = self::SetUpShipment($order,$shipping);
        //     $result = self::SetUpTransport($order,$shipping); 
        //     if($result[1]>0){
                
        //         $order->AWB =$result[2];
        //         self::updateOrder($order);
        //     }else{
        //         $reason = $result[2];
        //         $scs = false;
        //     }
        // }catch(Exception $e){ $scs = false;}

       
        $scs = true;
        $reason = '';
        try{
            error_log("entering internal db seq");
            $order = self::SetUpOrder($billing_data,$shipping);
            error_log("Order_ready");
            $invoice = self::SetUpInvoice($billing_data,$order);
            error_log("Invoice ready ");
            $payment = self::SetUpPayment($invoice,$order,$billing_data,$shipping);
            error_log("Payment_ready");
            $result = self::SetUpTransport($order,$shipping); 
            if($result[1]>0){
                $order->AWB =$result[2];
                self::updateOrder($order);
            }
            else{
                $reason = $result[2];
                $scs = false;
            }
            $shipment = self::SetUpShipment($order,$shipping);
            error_log("Shipment ready");
         
           
          /*  $req->session()->forget('billing');
            $req->session()->forget('shipping');
            $req->session()->forget('cart_products');*/

        }catch(Exception $e){ $scs = false;}
        if($scs){
            
            $data = array('token'=>base64_encode("$invoice->invoice_number,$invoice->email"),'email'=>$invoice->email);
            Mail::send('invoiceemail', $data, function ($message) use ($data) {
                $message->from('john@johndoe.com', 'Silver Boutique');
                $message->sender('silverboutiqe@gmail.ro');
            
                $message->to($data['email'],'');
            
            
            

            
                $message->subject('Thank you for purchasing from us!');
            
               // $message->priority(3);
            
              //  $message->attach('pathToFile');
            });
        }
        return response()->json(['success'=> $scs,"reason"=>$reason]);

    }

    private function SetUpOrder($billing_data,$shipping){
        $order = new \stdClass();
       $user = DB::table('Customers')->where('email',$billing_data->email)->first();
       if(!$user && !Auth::user()){
           $password = $billing_data->create_account? $billing_data->password : uniqid();
           $user = User::create(['email'=>$billing_data->email,'password'=>Hash::make($password)]);
           $user->activated = $billing_data->create_account?1:0;
           $user->save();
           Auth::logout();
          // $user = Auth::attempt();
       }else if(!Auth::user()){
           $user = Auth::loginUsingId($user->customer_id);
       }else{
           $user = Auth::user();
       }

       $order->customer_id = $user->customer_id;
       $order->order_status_code = 1;
       $order->date_order_placed = Carbon::now();
       $order->AWB = uniqid(10);
       $order->order_id = self::saveOrder($order);
       $order->ordered_items = array();
       foreach($billing_data->ordered_prods as $prod){
            $order_item = array();
            $order_item[] = $prod->product_id;
            $order_item[] = $order->order_id;
            $order_item[] = 1; //order_item_status_code
            $order_item[] = $prod->product_new_price?$prod->product_new_price:$prod->product_price;
          for($j=0;$j<$prod->cantitate;$j++){  
           $id =  DB::table('Order_Items')->insertGetId([
                'product_id'=>$order_item[0],
                'size'=>$prod->size,
                'order_id'=>$order_item[1],
                'order_item_status_code'=>1,
                'order_item_price'=>$order_item[3]
            ]);
           if($id) $order->ordered_items[] = $id;
                else
                {// logging implementation 
                }
          }

       }
       $order->total = $billing_data->total;
       return $order;
    }

    private function SetUpInvoice($billing_data,$order){
         error_log("in invoice");
       $invoice = self::GenerateInvoice($billing_data,$order);
       error_log("past generation ");
       //error_log(($invoice));
       $save_attempts = 0;
       while($save_attempts < 10 && !self::saveInvoice($invoice)){
            error_log("save attempt failed");
            $invoice->init($order->order_id);
            $save_attempts++;
       }

       error_log("past while with attempts ".$save_attempts);
       if($save_attempts >= 10){
           $order->order_status_code = 4;
           self::updateOrder($order);
           self::logInvoiceFailure($invoice); //needs implementation
            return false;
       }else{
            return $invoice;
       }
    }

    private function ComputeTransport($billing,$shipping){
      $arr =  explode(",",$shipping->address);
     // $tip_serviciu = $billing->payment_type == 1?'cont colector':'standard';
      $plata_la = $billing->payment_type == 1? "expeditor":"destinatar";
       
        if($billing->payment_type != 1 && $billing->payment_type != 2)
            throw new \Exception("payment_type not recognized");

      $params = [
        'username' => 'clienttest',
        'user_pass' => 'testing',
        'client_id' => '7032158',
        'serviciu' => "standard"
      ];
    
      // For internal services
      $params += [
        'localitate_dest' => $arr[1],
        'judet_dest' => $arr[0],
        'plicuri' => 0,
        'colete' => 1,
        'greutate' => 1,
        'lungime' => 1,
        'latime' => 1,
        'inaltime' => 1,
        'val_decl' => $billing->total,
        'plata_ramburs' => $plata_la // destinatar or expeditor
      ];

   
  //    $params['plata_la'] = 'destinatar'; // Optional: destinatar or expeditor.
 
      $fc = new fanCourier();
      $endpoint = $fc->getEndpoint('Price');
      
      //$endpoint->setType('export');  FOR EXPORT
    
      $endpoint->setParams($params);
      $res = $endpoint->getResult();
      $result = new \stdClass();
      $result->error = is_numeric($res)?false:$res;
      $res = round(floatval($res),0,PHP_ROUND_HALF_UP)+1;
      $result->value = $res;
      return $result;
    }

 

    private function SetUpPayment($invoice,$order,$billing,$shipping){
        $payment = new \stdClass();
        
        $payment->invoice_id = $invoice->invoice_number;
        error_log("invoice ".$invoice->invoice_number." ".$payment->invoice_id);
        error_log("asdad");
        $payment->payment_date = Carbon::now();
        $payment->payment_amount = $billing->total;
        $payment->payment_id= DB::table('Payments')->insertGetId([
              'invoice_number'=>$payment->invoice_id,
              'payment_date'=>$payment->payment_date,
              'payment_amount'=>$billing->total]);
   
        return $payment;
    }

    private function SetUpShipment($order,$shipping_model){
        return DB::table('Shipments')->insertGetId([
            'order_id'=>$order->order_id,
            'shipment_tracking_number'=>$order->AWB,
            'first_name'=>$shipping_model->first_name,
            'last_name'=>$shipping_model->last_name,
            'address'=>$shipping_model->address,
            'address_sec'=>$shipping_model->address_sec?$shipping_model->address_sec:"",
            'state'=>$shipping_model->state,
            'phone_number'=>$shipping_model->phone_number,
            'zip'=>$shipping_model->zip,
            'courier'=>'FAN Courier',
            'shipping_price'=>$shipping_model->shipping_price,
            'shipment_details'=>$shipping_model->other_details
       ]);
    }

    private function SetUpTransport($order,$shipping){
        $params = [
            'username' => 'clienttest',
            'user_pass' => 'testing',
            'client_id' => '7032158',
          ];
        
          $fc = new fanCourier();
          $endpoint = $fc->getEndpoint('awbGenerator');
          $endpoint->createFile();
          $tip_serviciu = $shipping->payment_type === 1?'cont colector':'standard';
          $plata_la = $shipping->payment_type === 1?"expeditor":"destinatar";
          
          $judet = explode(",",$shipping->address)[0];
          $localitate = explode(",",$shipping->address)[1];
          $strada = explode(",",$shipping->address)[2];

          $item1 = csvItem::newItem();
          $item1->setItem('tip', "standard");
          $item1->setItems(['localitate' => "$localitate", 'judet' => "$judet", 'strada' => "$strada"]);
          $item1->setItems(['telefon' => $shipping->phone_number,]);
          $item1->setItems(['nume_destinatar' => $shipping->first_name." ".$shipping->last_name, 'plata_expeditii' => "$plata_la"]);
          $item1->setItems(['greutate' => '1', 'nr_colet' => 1]);
          $item1->setItems(['continut'=>'Ceva']);
          $endpoint->addNewItem($item1);        
          $params['fisier'] = $endpoint->getFile();
          $endpoint->setParams($params);
        
          $result = $endpoint->getResult();
          
         error_log("FAN API RESPONSE ".$result[0]);
         
         $result = str_getcsv($result[0]);
         return $result;
          
    }
    private function GenerateInvoice($invoice_model,$order){
        $invoice = new Invoice();
        $invoice->init($order->order_id);
        $invoice->from($invoice_model); //needs implementations
        return $invoice;
    }

    public function genPDF(){
       $test = new Invoice();
       return view('invoice');
        //echo Storage::get('invoice.html');
      // return response()->json(['test'=>$test->test()]);
    }

    private function Extract($req,$model,...$null_allowed_fields){

        switch (strtolower($model)){
            case 'billing':{
                error_log( 'billing extraction detected ');
                $billing = new \stdClass();
                $billing->first_name = $req->c_fname;
                $billing->last_name = $req->c_lname;
                $billing->company = $req->c_companyname;
                $billing->address = $req->c_state_country.",".$req->c_city.",".$req->c_address;
                $billing->address_sec = $req->c_address_sec;
                $billing->state = $req->c_state_country;
                $billing->zip = $req->c_postal_zip;
                $billing->email = $req->c_email_address;
                $billing->phone_number = $req->c_phone;
                $billing->payment_type = $req->c_payment_method;
                $billing->other_details = $req->c_order_notes;
                $billing->create_account = $req->c_create_account;
                $billing->password = $req->c_account_password;

                $product_ids_qt = session('cart_products');
                error_log(">> cart items types ".count($product_ids_qt));
                
               // print_r($product_ids);
                 $product_ids = array_keys($product_ids_qt);
                // print_r($product_ids);
                $billing->ordered_prods = array();// = DB::table('Products')->whereIn('product_id',$product_ids)->get();
                error_log(">> ordered_prods ".count($billing->ordered_prods));
                $billing->total = 0;
                foreach($product_ids as $prod){
                    $sizes = $product_ids_qt[$prod];
                   // var_dump($sizes);
                    foreach($sizes as $sz=>$ct){
                        $product = DB::table('Products')->where('product_id',$prod)->first();
                        //var_dump($product);
                        $product->size = $sz;
                        
                        $product->cantitate = $ct;
                      
                        $billing->total += ($product->product_new_price?$product->product_new_price:$product->product_price*$product_ids_qt[$product->product_id][$sz]) ;
                        $billing->ordered_prods[] = $product;
                       
                    }
                   

                }
               error_log("before count check".count($billing->ordered_prods)." != ".count($product_ids));
               
                if(count($billing->ordered_prods) != count($product_ids))
                    return false;
          
                foreach($billing as $key=>$prop){
                
                    if(array_search($key,$null_allowed_fields) === false && !$prop ){
                       error_log($key." ".$prop);
                        return false;
                    }
                }

                return $billing;
                
            }break;

            case 'shipping':{
                
                if(!$req->c_ship_different_address){
                    return self::Extract($req,'billing','address_sec','email','company','other_details','create_account','password');
                }else{
                    $shipping = new \stdClass();
                    $shipping->first_name = $req->c_diff_fname;
                    $shipping->last_name = $req->c_diff_lname;
                    $shipping->company = $req->c_diff_companyname;
                    $shipping->address = $req->c_diff_state_country.",".$req->c_diff_city.",".$req->c_diff_address;
                    $shipping->address_sec = $req->c_diff_address_sec;
                    $shipping->state = $req->c_diff_state_country;
                    $shipping->zip = $req->c_diff_postal_zip;
                    $shipping->phone_number = $req->c_diff_phone;
                    $shipping->other_details = $req->c_order_notes;
             
                    $product_ids = session('cart_products');
                    $shipping->ordered_prods =  DB::table('Products')->whereIn('product_id',array_keys($product_ids))->get();;
                    
                    foreach($shipping->ordered_prods as $prod){
                        $prod->cantitate = $product_ids[$prod->product_id];
                    }

                 
                    if(count($shipping->ordered_prods) != count($product_ids))
                        return false;
                    
                    foreach($shipping as $key=>$prop){
                        if(array_search($key,$null_allowed_fields) === false && !$prop ){
                            error_log($key." ".$prop);
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

   

    public function fetchC(Request $req){
        $state = $req->state;

     if($state)  {
            $params = [
                'username' => 'clienttest',
                'user_pass' => 'testing',
                'client_id' => '7032158',
                'judet' => $state, // Optional
                'language' => 'ro' // Optional
            ];

            $fc = new fanCourier();
            $endpoint = $fc->getEndpoint('Localitati');
            $endpoint->setParams($params);
            $endpoint->noHeader();
            $result = $endpoint->getResult();
            
                        
            
            return response()->json(json_encode($result));
        }
    }


    public function fetchS(Request $req){
        $state = $req->state;
        $city = $req->city;

        if($city && $state)  {
              
                $params = [
                    'username' => 'clienttest',
                    'user_pass' => 'testing',
                    'client_id' => '7032158',
                    'judet' => "$state", // Optional
                    'localitate' => "$city", // Optional
                    'language' => 'ro', // Optional
                ];

                $fc = new fanCourier();
                $endpoint = $fc->getEndpoint('Strazi');
                $endpoint->setParams($params);
                $endpoint->noHeader();
                $raw_result = $endpoint->getResult();
                
                $result = json_encode(self::convert_from_latin1_to_utf8_recursively($raw_result));
               
                if(!$result){
                     var_dump($raw_result);
                    return response()->json($raw_result);
                } else{
                    return response()->json($result);
                }
           }
    }
    //Stack overflow trademark
    private static function convert_from_latin1_to_utf8_recursively($dat)
    {
       if (is_string($dat)) {
          return utf8_encode($dat);
       } elseif (is_array($dat)) {
          $ret = [];
          foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
 
          return $ret;
       } elseif (is_object($dat)) {
          foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
 
          return $dat;
       } else {
          return $dat;
       }
    }// -----
    private function saveOrder($order){
      return  DB::table('Orders')->insertGetId([
            'customer_id'=>$order->customer_id,
            'order_status_code'=>$order->order_status_code,
            'date_order_placed'=>$order->date_order_placed,
            'AWB'=>$order->AWB
        ]);

    }

    private function saveInvoice($invoice){
       try{ return  DB::table('Invoices')->insertGetId([
            'invoice_number'=>$invoice->invoice_number,
            'order_id'=>$invoice->order_id,
            'invoice_status_code'=>$invoice->invoice_status_code,
            'invoice_date'=>$invoice->invoice_date,
            'first_name'=>$invoice->first_name,
            'last_name'=>$invoice->last_name,
            'email'=>$invoice->email,
            'phone_number'=>$invoice->phone_number,
            'address'=>$invoice->address,
            'address_sec'=>$invoice->address_sec,
            'state'=>$invoice->state,
            'zip'=>$invoice->zip,
            'payment_method'=>$invoice->payment_method
        ]);
       }catch(\Exception $e){
           
           error_log(($e));
           return false;
       }
    }

    private function updateOrder($order){
        return  DB::table('Orders')->where('order_id',$order->order_id)->update([
              'customer_id'=>$order->customer_id,
              'order_status_code'=>$order->order_status_code,
              'date_order_placed'=>$order->date_order_placed,
              'AWB'=>$order->AWB
          ]);
  
      }

     private function logInvoiceFailure($invoice){
        DB::table('Invoices_fails')->insertGetId([
            'invoice_number'=>$invoice->invoice_number,
            'order_id'=>$invoice->order_id,
            'invoice_status_code'=>$invoice->invoice_status_code,
            'invoice_date'=>$invoice->invoice_date,
            'first_name'=>$invoice->first_name,
            'last_name'=>$invoice->last_name,
            'email'=>$invoice->email,
            'phone_number'=>$invoice->phone_number,
            'address'=>$invoice->address,
            'address_sec'=>$invoice->address_sec,
            'state'=>$invoice->state,
            'zip'=>$invoice->zip,
            'payment_method'=>$invoice->payment_method
        ]);
     } 


     

}