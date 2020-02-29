<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
       
class CategoryController extends Controller
{
    public function addCategory(Request $request){      

        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            // 'id_parent_category'  => 'required',
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "insert into category
                        (id_parent_category, name, created_at, updated_at)
                    values(
                        '".$request->id_parent_category."',
                        '".$request->name."',
                        '".$now->toDateTimeString()."',
                        '".$now->toDateTimeString()."')";
    
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

    public function editCategory(Request $request){
        
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_category'   => 'required',
            // 'id_parent_category'  => 'required',
            // 'name'          => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "update category set 
                            id_parent_category= '".$request->id_parent_category."',
                            name='".$request->name."',
                            updated_at='".$now->toDateTimeString()."'
                        where 
                            id_category='".$request->id_category."'";
        
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

    public function deleteCategory(Request $request){
        Log::debug($request->All());

        $validator  = Validator::make($request->all(), [
            'id_category'   => 'required',
        ]);

        if ($validator->fails()) {
            $validator_message = $validator->messages()->first();
            Log::debug($validator_message);
            return $validator_message;
        }
        
        try{    
            $now = Carbon::now();

            $query = "update category set 
                            deleted_at='".$now->toDateTimeString()."'
                        where 
                            id_category='".$request->id_category."'";
        
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

    public function getCategory(Request $request){        
        try{    
            $now = Carbon::now();

            $query = "select p.id_category, p.name as parent_name, c.id_category, c.name as child_name from category p join category c on p.id_category=c.id_parent_category order by p.id_category asc";
        
            Log::debug($query);
                        
            $res = DB::select($query);
        
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
