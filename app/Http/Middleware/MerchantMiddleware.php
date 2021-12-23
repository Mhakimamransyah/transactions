<?php

namespace App\Http\Middleware;
use App\Model\Merchant;
use App\Model\Outlet;
use Illuminate\Support\Facades\Auth;


use Closure;

class MerchantMiddleware
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
        $id_merchants = $request->route()[2]['id_merchants'];
        $user = auth()->user();
        $merchant = Merchant::where("id",$id_merchants)->first();
        if($merchant != null){
           
            if($merchant->user_id != $user->id){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Unauthorized acces, not your merchants',
                     "code" => 401
                ], 401);
            }

            if(isset($request->route()[2]['id_outlets'])){
               $outlet = Outlet::where("id",$request->route()[2]['id_outlets'])->first();
               $merchant_outlet = Merchant::where("id",$outlet->merchant_id)->first();
                if($merchant_outlet->user_id != $user->id){
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Unauthorized acces, not your outlets',
                        "code" => 401
                    ], 401);
                }
            }

            return $next($request);

        }else{
             return response()->json([
                    'message' => 'No merchants found',
             ], 400);
        }
    }
}
