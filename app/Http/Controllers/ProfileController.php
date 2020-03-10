<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
//use SeniorProgramming\FanCourier\Facades\FanCourier;
use FanCourier\fanCourier;
use FanCourier\Plugin\csv\csvItem;

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
        $user->strnr = $req->c_address_nr;
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
           try{ $active->total += DB::table('Shipments')->where('order_id',$active->order_id)->first()->shipping_price;
           }catch(\Exception $e){
            
           }
        }
        $delivered_orders = DB::table('Orders')->where(['customer_id'=>$user->customer_id,'order_status_code'=>2])->get(); //delivered orders
        foreach($delivered_orders as $delivered){
            $delivered->total =  isset($delivered->total)?$delivered->total:0;
            $order_items =  DB::table('Order_Items')->where(['order_id'=>$delivered->order_id,'order_item_status_code'=>2])->pluck('order_item_price');
            for($i = 0; $i<count($order_items); $i++){
                $delivered->total = $delivered->total + $order_items[$i];
            }
         try{    $delivered->total += DB::table('Shipments')->where('order_id',$delivered->order_id)->first()->shipping_price;
         }catch(\Exception $e){}
        }

        

        return view('profile')->with(['active_orders'=>$active_orders,'delivered_orders'=>$delivered_orders]);
    }


    function ShowOrder(Request $req){
        $user = Auth::user();
        $order_awb = $req->id;
        $order = DB::table('Orders')->where('AWB',strtoupper($order_awb))->first();
        if($order !== null && $user->customer_id === $order->customer_id){
            // Set up the order details
            if($order->order_status_code >= 3)
                return abort(404,'Page not found.');
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

        return abort(404,'Page not found.');
        
    }


    
    function FANTest(Request $req){
       
      /* print_r(FanCourier::order([
        'nr_colete' => 1, // or 'nr_plicuri' => 1
        'pers_contact' => 'Test',
        'tel' => 123456789,
        'email' => 'example@example.com',
        'greutate' => 1,
        'inaltime' => 10,
        'lungime' => 10,
        'latime' => 10,
        'ora_ridicare' => '18:00',
        'observatii' => '',
        'client_exp' => 'Test',
        'strada' => 'Test',
        'nr' => 1,
        'bloc' => 2,
        'scara' => 3,
        'etaj' => 7,
        'ap' => 78,
        'localitate' => 'Constanta',
        'judet' => 'Constanta',
    ]));
        print_r( FanCourier::generateAwb(['fisier' => [
            [
                'tip_serviciu' => 'standard', 
                'banca' => '',
                'iban' =>  '',
                'nr_plicuri' => 1,
                'nr_colete' => 0,
                'greutate' => 1,
                'plata_expeditie' => 'ramburs',
                'ramburs_bani' => 100,
                'plata_ramburs_la' => 'destinatar',
                'valoare_declarata' => 400,
                'persoana_contact_expeditor' => 'Test User',
                'observatii' => 'Lorem ipsum',
                'continut' => '',
                'nume_destinar' => 'Test',
                'persoana_contact' => 'Test',
                'telefon' => '123456789',
                'fax' => '123456789',
                'email' => 'example@example.com',
                'judet' => 'Galati',
                'localitate' => 'Tecuci',
                'strada' => 'Lorem',
                'nr' => '2',
                'cod_postal' => '123456',
                'bl' => '',
                'scara' => '',
                'etaj'  => '',
                'apartament' => '',
                'inaltime_pachet' => '',
                'lungime_pachet' => '',
                'restituire' => '',
                'centru_cost' => '',
                'optiuni' => '',
                'packing' => '',
                'date_personale' => ''
            ]]]));
*/

try {

    $params = [
      'username' => 'clienttest',
      'user_pass' => 'testing',
      'client_id' => '7032158',
    ];
  
    $fc = new fanCourier();
    $endpoint = $fc->getEndpoint('awbGenerator');
    $endpoint->createFile();
  
    $item1 = csvItem::newItem();
    $item1->setItem('tip', 'standard');
    $item1->setItems(['localitate' => 'Targu Mures', 'judet' => 'Mures', 'strada' => 'Aleea Carpati', 'nr' => '1']);
    $item1->setItems(['telefon' => '0758099432',]);
    $item1->setItems(['nume_destinatar' => 'Name 1', 'plata_expeditii' => 'destinatar']);
    $item1->setItems(['greutate' => '1', 'nr_colet' => 1]);
    $endpoint->addNewItem($item1);
  
  
    //print_r($endpoint->csvToText());
  
    $params['fisier'] = $endpoint->getFile();
    $endpoint->setParams($params);
  
    $result = $endpoint->getResult();
    foreach ($result as $key => $value) {
      print_r(str_getcsv($value));
    }
  }
  catch (Exception $exc) {
    echo $exc->getMessage();
  }
  
    }


}
