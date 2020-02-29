<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // public function getAllProduct(){
    //     try{
    //         $product = DB::select('select * from product');

    //         return response()->json($product,200);
    //     }catch(\Exception $ex){
    //         return $ex->getMessage();
    //     }
    // }

    public function search(Request $request){
        try{
            $tempWhere = array();

            if ($request->get('name') != null){
                array_push($tempWhere,"p.name = '".addslashes($request->get('name'))."'");
            }
    
            if ($request->get('price') != null){
                array_push($tempWhere,"p.price = ".$request->get('price'));
            }
    
            if ($request->get('category') != null){
                array_push($tempWhere,"c.name = '".$request->get('category')."'");
            }
    
            if ($request->get('series') != null){
                array_push($tempWhere,"p.series = ".$request->get('series'));
            }
    
            $queryWhere = "";

            if(count($tempWhere) > 1){
                $queryWhere = join(" or ",$tempWhere)." and p.deleted_at is null";
            }else if (count($tempWhere) == 1){
                $queryWhere = "(".join(" ",$tempWhere).") and p.deleted_at is null";
            }else{
                $queryWhere = " p.deleted_at is null";
            }
            
            $query = "select 
                            p.id_product, p.name, p.series,c.id_category, pr.price, group_concat( c.name) as category_name 
                        from 
                            product_category pc
                        join 
                            product p on pc.id_product = p.id_product
                        join 
                            category c on pc.id_category = c.id_category 
                        join 
                        	price pr on p.id_product=pr.id_product
                        where
                            ".$queryWhere."
                        group by 
                            p.id_product";
    
            $product = DB::select($query);

            $res = array(
                'status'    => true,
                'message'   => "succes",
                'data'      => $product
            );
        
            return response()->json($res,200);    
        }catch(\Exception $ex){
            $res = array(
                'status'    => false,
                'message'   => $ex->getMessage(),
            );
            return response()->json($res, 500);

        }
    }
}
