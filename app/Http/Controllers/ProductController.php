<?php

namespace App\Http\Controllers;

use DB;
use App\PriceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function addProduct(Request $request){

        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'name'          => 'required',
            'series'        => 'required',
            'stock'         => 'required',
            'data_price'    => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $id = DB::table('product')->insertGetId(
                [
                    'name'      => $request->name,
                    'series'    => $request->series,
                    'stock'     => $request->stock,
                    'created_at'=> $now->toDateTimeString(),
                    'updated_at'=> $now->toDateTimeString()
                ]
            );

            $price = array();

            foreach($request->data_price as $data){
                array_push($price,array("id_product"    => $id,
                                        "price"         => $data['price'],
                                        "qty"           => $data['qty'],
                                        "created_at"    => $now->toDateTimeString(),
                                        "updated_at"    => $now->toDateTimeString()
                                    ));
            }

            Log::debug($price);           

            PriceModel::insert($price);

            $res = array(
                'status'    => true,
                'message'   => "succes",
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

    public function editProduct(Request $request){
        
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_product'    => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "update product set 
                            name = '".$request->name."',
                            series ='".$request->series."',
                            stock ='".$request->stock."',
                            updated_at='".$now->toDateTimeString()."'
                        where 
                            id_product ='".$request->id_product."'";
        
            Log::debug($query);
                        
            DB::select($query);

            $res = array(
                'status'    => true,
                'message'   => "succes",
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

    public function editPrice(Request $request){
        
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_price'    => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "update price set 
                            price = '".$request->price."',
                            qty ='".$request->qty."',
                            updated_at='".$now->toDateTimeString()."'
                        where 
                            id_price ='".$request->id_price."'";
        
            Log::debug($query);
                        
            DB::select($query);

            $res = array(
                'status'    => true,
                'message'   => "succes",
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

    public function deleteProduct(Request $request){
        
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_product'    => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "update product set 
                            deleted_at='".$now->toDateTimeString()."'
                        where 
                            id_product ='".$request->id_product."'";
        
            Log::debug($query);
                        
            DB::select($query);

            $res = array(
                'status'    => true,
                'message'   => "succes",
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
