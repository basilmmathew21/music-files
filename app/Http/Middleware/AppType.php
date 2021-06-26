<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->segment('2') == 'driver') {
            //return response()->json([ 'data' => [], 'message' => 'Test middle', 'status_code'=>200]);
           $request['app_type'] = 'driver';
            return $next($request);
            //return response([ 'data' => [], 'message' => 'Test middle', 'status_code'=>200]);
        }elseif($request->segment('2') == 'customer'){
            $request['app_type'] = 'customer';
            return $next($request);
        }
        //return $next($request);
    }
}
