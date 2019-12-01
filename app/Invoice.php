<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Invoice
{   
    protected $invoice_number = 0;
    protected $payment_date;
    protected $payment_id;
    protected $payment_amount;
    protected $pdf_path = '';

    function __construct(){
            
    }

    function isEmpty(){
        return $invoice_id == 0 ||  strlen($pdf_path) == 0; 
    }

    function init($date,$amount,$order_id){
        $invoice_number = rand(5,11);

    }

}
