<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Invoice
{   
    protected $invoice_number = 0;
    protected $order_id;
    protected $invoice_date;
    protected $pdf_path = '';
    protected $payment_method;
    protected $first_name;
    protected $email;
    protected $phone_number;
    protected $address;
    protected $address_sec;
    protected $state;
    protected $zip; 
    protected $invoice_details;
 
    function __construct(){
            
    }

    function isInit(){
        return !($invoice_id == 0 ||  strlen($pdf_path) == 0); 
    }

    function init($order_id){
        $this->$order_id = $order_id;
        $invoice_number = rand(5,11);

    }

    function from($invoice_model){

    }

}
