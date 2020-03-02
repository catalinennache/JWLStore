<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class RecentlyViewed
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
      $arr = $request->session()->has('recently_viewed')?session('recently_viewed'):array();
      $request->rw = DB::table('Products')->whereIn('product_id',$arr)->get();

        return $next($request);
    }
}
