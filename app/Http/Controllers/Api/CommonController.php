<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Storage;
use App\TblState;
use App\TblBank;
use App\TblCity;
use App\TblDeliveryType;
use App\TblWarehouse;

class CommonController extends Controller
{
    
    /*** Annotation For Get Dropdowns ***/
    /**
     * @OA\Get(
     *     path="/delivery/public/api/get-dropdowns",
     *     operationId="/delivery/public/api/get-dropdowns",
     *     tags={"Get Dropdowns"},
     *     summary= "Get Dropdowns",
     *     description = "Get Dropdowns",
     *     
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     *  security={ {"bearer": {}} },
     * ) 
     */
           
    /*** End of Annotation For Get Dropdowns***/

     public function getDropdowns(){
        $dropdowns = [];

        $dropdowns['states']   = TblState::where("status",1)->select(DB::Raw("id as value,name as title"))->get()->toArray();
        $dropdowns['banks'] = TblBank::where("status",1)->select(DB::Raw("id as value,name as title"))->get()->toArray();
        $dropdowns['cities'] = TblCity::where("status",1)->select(DB::Raw("id as value,name as title,state_id"))->get()->toArray();
        $dropdowns['delivery_type'] = TblDeliveryType::where("status",1)->select(DB::Raw("id as value,name as title"))->get()->toArray();
        $dropdowns['warehouses'] = TblWarehouse::where("status",1)->select(DB::Raw("id as value,name as title"))->get()->toArray();
        $dropdowns['supervisors'] = User::join('tbl_warehouses','users.warehouse_id','tbl_warehouses.id')
                                    ->where("tbl_warehouses.status",1)
                                    ->where('users.role',User::SUPERVISOR)
                                    ->select(DB::Raw("users.id as value,users.name as title, users.warehouse_id as warehouse_id"))
                                    ->get()->toArray();
        
        $response['success'] = true;     $response['message'] = '';     $response['data'] =  $dropdowns;     $code = 200;
        return response()->json($response);
    }

    
}
