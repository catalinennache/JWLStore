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

    function PayPalPay(Request $req){

    }

    function MastercardPay(Request $req){

    }

    function RambursPay(Request $req){

    }

    private function GenerateInvoice(Invoice $invoice_model){

    }

}