<?php

namespace App\Http\Controllers;

use DB;
use App\TransactionModel;
use App\TransactionDetailModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function addTransaction(Request $request){

        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'total_price'   => 'required',
            'data_product'  => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            do
            {
                $orderNumber =  str_random(10);
                $transaction = TransactionModel::where('order_number', $orderNumber)->first();
            }
            while(!empty($transaction));

            $id = DB::table('transaction')->insertGetId(
                [
                    'order_number'  => $orderNumber,
                    'total_price'   => $request->total_price,
                    'created_at'    => $now->toDateTimeString(),
                    'updated_at'    => $now->toDateTimeString()
                ]
            );

            $detailTransaction = array();

            foreach($request->data_product as $data){
                array_push($detailTransaction,array("id_transaction"    => $id,
                                                    "id_product"        => $data['id_product'],
                                                    "price"             => $data['price'],
                                                    "qty"               => $data['qty'],
                                                    "created_at"        => $now->toDateTimeString(),
                                                    "updated_at"        => $now->toDateTimeString()
                                                ));
            }

            Log::debug($detailTransaction);           

            TransactionDetailModel::insert($detailTransaction);

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

    public function getTransaction(Request $request){
        try{    
            Log::debug($request->All());

            $queryWhere = "";

            if($request->order_number != null){
                $queryWhere = "where order_number = '".$request->order_number."'";
            }            

            $query = "select id_transaction, order_number, total_price from transaction ".$queryWhere."";
            $transaction = DB::select($query);

            $dataTransaction = array();

            foreach($transaction as $data){
                $query = "select 
                                td.id_transaction_detail, td.id_product, p.name, p.series, td.qty, td.price
                            from
                                transaction_detail td
                            join 
                                product p on td.id_product= p.id_product
                            where 
                                td.id_transaction = ".$data->id_transaction."
                            order by 
                                td.created_at desc
                            ";

                $detailTransaction = DB::select($query);
                
                $tempDetail = array();
                foreach($detailTransaction as $detail){
                    array_push($tempDetail,array("id_transaction_detail"    => $detail->id_transaction_detail,
                                                 "id_product"               => $detail->id_product,
                                                 "name"                     => $detail->name,
                                                 "series"                   => $detail->series,
                                                 "qty"                      => $detail->qty,
                                                 "price"                    => $detail->price,
                                                ));
                }

                array_push($dataTransaction,array("order_number"    => $data->order_number,
                                                  "total_price"     => $data->total_price,
                                                  "detail product"  => $tempDetail
                                                ));
            }

            Log::debug($query);
                        
            $transaction = DB::select($query);

            $res = array(
                'status'    => true,
                'message'   => "succes",
                'data'      => $dataTransaction 
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
