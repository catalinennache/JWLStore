<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PDF;
use Storage;
use Carbon\Carbon;

class Invoice
{   
    public $invoice_number = 0;
    public $order_id;
    public $invoice_date;
    public $payment_method;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $state;
    public $zip; 
    public $invoice_details;
    public $invoice_status_code;
 
    function __construct(){
            
    }

    function isInit(){
        return !($invoice_id == 0 ||  strlen($pdf_path) == 0); 
    }

    function init($order_id){
        $this->order_id = $order_id;
        $this->invoice_number = rand(1,999999999);

    }

    function from($invoice_model){
        try{$this->payment_method = $invoice_model->payment_type;
        $this->invoice_date = Carbon::now();
        $this->first_name = $invoice_model->first_name;
        $this->last_name = $invoice_model->last_name;
        $this->email = $invoice_model->email;
        $this->phone_number = $invoice_model->phone_number;
        $this->address = $invoice_model->address;
        $this->address_sec = $invoice_model->address_sec?$invoice_model->address_sec:"";
        $this->state = $invoice_model->state;
        $this->zip = $invoice_model->zip;
        $this->invoice_status_code = 1;}
catch(\Exception $e){
    $this->invoice_status_code = 4;
}
        return $this;
    }
    function test(){
        /*
         <?invoice_number?>
         <?created_on?>
         <?first_name?>
         <?last_name?>
         <?email?>
         <?payment_type?>
         <?last_item?>
         <?price_last_item?>
         <?total?>


        */
       
        $pdf =  \App::make('dompdf.wrapper');
        $invoice_number = rand(10000,100000);
        print_r('invoice number '.$invoice_number);
        $template = Storage::get('invoice.html');
       $template= str_ireplace("<?invoice_number?>",$invoice_number,$template);
       $template=  str_ireplace("<?created_on?>","12 Feb 2020",$template);
       $template=  str_ireplace("<?first_name?>","Catalin",$template);
       $template= str_ireplace("<?last_name?>","Enache",$template);
       $template= str_ireplace("<?email?>","catalinenache03@gmail.com",$template);
       $template= str_ireplace("<?payment_type?>","Card",$template);
       $template= str_ireplace("<?last_item?>","FAN Transport",$template);
       $template= str_ireplace("<?price_last_item?>","25",$template);
       $template= str_ireplace("<?total?>","300",$template);
        echo $template;
        $file = $pdf->loadHTML($template)->stream();
        Storage::put('/'.$invoice_number.".pdf",$file);
       return $template;
  
    }

}
