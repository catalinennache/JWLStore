<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Closure;

class CategoryReceiver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {  
        $categories = DB::table('Products')->select('product_type_code')->groupby('product_type_code')->get();
        
        $cat0 = array();
        foreach($categories as $ct){
        $cat0[] = DB::table('Ref_Product_Types')->where('product_type_code',$ct->product_type_code)->first();
        
        }
        $cats = array();
        //var_dump($cat0);
        foreach($cat0 as $category){
           $cats[$category->product_type_code] = $category->product_type_category;
        }
        $GLOBALS['header_cats'] = $cats;
        return $next($request);
    }
}
