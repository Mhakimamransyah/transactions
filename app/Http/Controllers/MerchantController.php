<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Merchant;
use App\Model\Outlet;
use App\Model\Transactions;
use DateTime;
use DB;

class MerchantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function omzet($id_merchants,$id_outlets=null,Request $request){
        $user = auth()->user();
       
        $from = ($request->get('from') == null)? date('Y-m-d') : $request->get('from');
        $to = ($request->get('to') == null)? date("Y-m-d",strtotime('first day of +1 month',strtotime($from)))  :$request->get('to');

        $limit  = ($request->get('per_page') == null)? 100 : $request->get('per_page');
        $offset = ($request->get('page') == null)? 0 : $request->get('page');
        $page   = ($offset * $limit) - $limit;
        
        $merchant = Merchant::where("id",$id_merchants)->first();
        $outlet = ($id_outlets != null)? Outlet::where("id",$id_outlets)->first() : null;
    
        $begin = new DateTime($from);
        $end = new DateTime($to);
        

        $data = [];
        $count_index = 1;
        $count_limit = 1;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            
            if($count_index > $page){
               if($count_limit <= $limit){
                    $tmp = [];
                    
                    if($id_outlets == null){
                       $res = DB::select( DB::raw("select SUM(bill_total) as omzet from `transactions` where `transactions`.`merchant_id` = ".$id_merchants." and date(`transactions`.`created_at`) LIKE '".$i->format("Y-m-d")."%'"));
                    }else{
                       $res = DB::select( DB::raw("select SUM(bill_total) as omzet from `transactions` where `transactions`.`merchant_id` = ".$id_merchants." and outlet_id=".$id_outlets." and date(`transactions`.`created_at`) LIKE '".$i->format("Y-m-d")."%'"));
                    }
                  
                    $omzet = ($res[0]->omzet == null)? 0 : $res[0]->omzet;
                    $tmp = [
                      "merchant_id"=>$id_merchants,
                      "nama_merchant" => $merchant->merchant_name,
                      "omzet"=>$omzet,
                      "tanggal"=>$i->format("Y-m-d")
                    ];

                    if($outlet != null){
                        $tmp["id_outlets"]=$outlet->id;
                        $tmp["nama_outlet"]=$outlet->outlet_name;
                    }

                    array_push($data, $tmp);
                    $count_limit++;  
               }else{
                 break;
               }
            } 
            $count_index++;         
        }

        $query = [
           "id_merchants" => $id_merchants,
           "from" => $from,
           "to" => $to,
           "per_page" => $limit,
           "page" => $offset
        ];

        if($id_outlets != null){
           $query["id_outlets"] = $id_outlets;
        }

         return response()->json([
                    'status' => 'success',
                    "messages" => "Data berhasil didapatkan",
                    "rows" => sizeof($data),
                    "query" => $query,
                    'data' => $data,
                    "code" => 200
          ], 200);
    }




    //
}
