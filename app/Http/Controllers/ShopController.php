<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;

class ShopController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function shop(Request $req)
    {
        return view('shop');
    }

    public function cart(Request $req)
    {
        return view('cart');
    }

    public function shops(Request $req)
    {
        return view('shop-single');
    }

    public function checkout(Request $req)
    {
        return view('checkout');
    }

    public function about(Request $req)
    {
        return view('about');
    }

    public function thank(Request $req)
    {
        return view('thankyou');
    }

    public function login(Request $req){
        
        return view("login");
    }

    public function register(Request $req){
        
        return view("register");
    }
}
