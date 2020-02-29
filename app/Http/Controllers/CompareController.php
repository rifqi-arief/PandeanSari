<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CompareController extends Controller
{
    public function compare(Request $request){
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_product'  => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $queryWhere = join(", ",$request->id_product);

            $query = "select 
                            p.id_product, p.name, p.series, pr.price, pr.qty                        
                        from 
                            product_category pc
                        join 
                            product p on pc.id_product = p.id_product
                        join 
                            price pr on p.id_product=pr.id_product
                        where 
                            pc.id_product in (".$queryWhere.")
                        and 
                            p.deleted_at is null";

            Log::debug($query);
                        
            $product = DB::select($query);

            $seriesProduct = array();
            $priceProduct = array();
            $qtyProduct = array();

            array_push($seriesProduct,array($product[0]->name =>$product[0]->series));
            for($i=1;$i<count($product);$i++){
                if($product[$i]->name != $product[$i-1]->name){
                    array_push($seriesProduct,array($product[$i]->name =>$product[$i]->series));
                }
            }

            foreach($product as $data){
                array_push($qtyProduct,array($data->name => $data->qty));
            }

            foreach($product as $data){
                array_push($priceProduct,array($data->name => $data->price));
            }

            $compareProduct = array(
                'series'    => $seriesProduct,
                'qty'       => $qtyProduct,
                'price'     => $priceProduct,
            );

            $res = array(
                'status'    => true,
                'message'   => "succes",
                'data'      => $compareProduct 
            );
        
            Log::debug($res);
            return response()->json($res,200);    
        }catch(\Exception $ex){
            Log::error($ex->getMessage());

            $res = array(
                'status'    => false,
                'message'   => $ex->getMessage(),
            );
            return response()->json($res, 500);
        }
    }
}
