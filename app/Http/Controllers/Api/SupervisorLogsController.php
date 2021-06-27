<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Storage;
use App\TblUserLoginLog;
use App\TblAgentSupervisorMapping;
use App\TblDeliveryType;

class SupervisorLogsController extends Controller
{

    /***Annotation For Start Day ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/supervisor/start-day",
     *     operationId="/delivery/public/api/supervisor/start-day",
     *      tags={"Supervisor Login"},
     *      summary= "Start Day",
     *      description = "Start Day",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *              
     *               @OA\Property(
     *                   property="warehouse_id",
     *                   type="string",
     *					 example="Dropdown",     
     *               ),
     *               
     *              
     *              @OA\Property(
     *                   property="login_latitude",
     *                   type="string",
     *					 example="Current Location latitude",     
     *               ),
     *              @OA\Property(
     *                   property="login_longitude",
     *                   type="string",
     *                   example="Current location longitude",     
     *               ) 
     *              
     *            ),   
     *        ),
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For Start day ***/
    protected function startDay(Request $request)
    {
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'warehouse_id' => 'required',
            'login_latitude' => 'required',
            'login_longitude' => 'required'
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
        try{
        /**Save data**/
        $user_id = $auth_user->id;
        
        $save_data = $request->all();
        $save_data['user_id']=$user_id;
        $save_data['login_time']=date('h:i:s A');
        $save_data['login_date']=date('d-m-Y');
        TblUserLoginLog::create($save_data);
       
            
        $response['success'] = true;     $response['message'] = 'Login and Day started successfully'; $response['data'] = "";     $code = 200; 
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

    /***Annotation For End Day ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/supervisor/end-day",
     *     operationId="/delivery/public/api/supervisor/end-day",
     *      tags={"Supervisor Login"},
     *      summary= "End Day",
     *      description = "End Day",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(
     *                   property="logout_latitude",
     *                   type="string",
     *                   example="Current Location latitude",     
     *               ),
     *              @OA\Property(
     *                   property="logout_longitude",
     *                   type="string",
     *                   example="Current location longitude",     
     *               ) 
     *              
     *            ),   
     *        ),
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For Supervisor login ***/
    protected function endDay(Request $request)
    {
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'logout_latitude' => 'required',
            'logout_longitude' => 'required'
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
        try{
        /**Save data**/
        $user_id = $auth_user->id;
        $user_log_obj = TblUserLoginLog::where('user_id',$user_id)->whereNull('logout_date')->orderBy('id','DESC')->first();

        $user_log_obj->logout_latitude = $request->logout_latitude;
        $user_log_obj->logout_longitude = $request->logout_longitude;
        $user_log_obj->logout_date = date('d-m-Y');
        $user_log_obj->logout_time = date('h:i:s A');
        $user_log_obj->delivered_package = $request->delivered_package;
            
        $user_log_obj->save();
        $request->user()->token()->revoke();      
        $response['success'] = true;     $response['message'] = 'Logged-out and Day ended successfully'; $response['data'] = "";     $code = 200; 
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

/***Annotation For Get Agent List ***/
    /**
     * @OA\Get(
     *     path="/delivery/public/api/supervisor/get-agent-list",
     *     operationId="/delivery/public/api/supervisor/get-agent-list",
     *      tags={"Supervisor Login"},
     *      summary= "Agent List",
     *      description = "Agent List",
     *    @OA\RequestBody(
     * 
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For Agent List ***/
    protected function getAgentsList(Request $request)
    {
        $auth_user = $request->user();
        
        try{
        /**Get data**/
        $user_id = $auth_user->id;

        $assigned_agents = TblAgentSupervisorMapping::where('supervisor_id',$user_id)->pluck('agent_id')->toArray();

        $user_log_obj = TblUserLoginLog::join('users','users.id','tbl_user_login_logs.user_id')
                                        ->leftjoin('tbl_delivery_types','tbl_delivery_types.id','tbl_user_login_logs.delivery_type_id')
                                        ->whereIn('user_id',$assigned_agents)
                                        ->where('supervisor_id',$user_id)
                                        ->where('login_date', date('d-m-Y'))
                                        ->select(DB::Raw("CONCAT(users.first_name,' ',users.last_name) as agent_name,users.id as user_id, tbl_user_login_logs.id as id, tbl_delivery_types.name as delivery_type_name "))
                                        ->orderBy('tbl_user_login_logs.id', 'desc')
                                        ->get()->toArray();

        
        $response['success'] = true;     $response['message'] = ''; $response['data'] = $user_log_obj;     $code = 200; 
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

    /***Annotation For Get Agent View ***/
    /**
     * @OA\Get(
     *     path="/delivery/public/api/supervisor/agent-view",
     *     operationId="/delivery/public/api/supervisor/agent-view",
     *      tags={"Supervisor Login"},
     *      summary= "Agent View",
     *      description = "Agent View",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="",
     *         explode=true
     *     ),
     *    @OA\RequestBody(
     * 
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For Agent View ***/
    protected function viewAgentDetails(Request $request)
    {
        $id = $request->id;
        
        try{
        /**Get data**/
        $download_url = route("download_report_url",['file'=>""]);
        $user_log_obj = TblUserLoginLog::join('users','users.id','tbl_user_login_logs.user_id')
                                        ->leftjoin('tbl_delivery_types','tbl_delivery_types.id','tbl_user_login_logs.delivery_type_id')
                                        ->where('tbl_user_login_logs.id',$id)
                                        ->select(DB::Raw("CONCAT(users.first_name,' ',users.last_name) as agent_name,tbl_user_login_logs.id as id, tbl_delivery_types.name as delivery_type_name, collected_package,c_returned_package,delivered_package, CONCAT('$download_url',users.report_url) as download_report_url, login_time, logout_time "))
                                        ->get()->toArray();

        
        $response['success'] = true;     $response['message'] = ''; $response['data'] = $user_log_obj;     $code = 200; 
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }


    /***Annotation For Edit Delivery Type ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/supervisor/edit-delivery-type",
     *     operationId="/delivery/public/api/supervisor/edit-delivery-type",
     *      tags={"Supervisor Login"},
     *      summary= "edit Delivery Type",
     *      description = "edit Delivery Type",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="",
     *         explode=true
     *     ),
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="delivery_type_id",
     *                   type="string",
     *                   example="",     
     *               )
     *            ),   
     *        ),
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For editDeliveryTypet ***/
    function editDeliveryType(Request $request){
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'delivery_type_id' => 'required',
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }

        
        try{
            
        $agentLog = TblUserLoginLog::where('id',$request->id)->first();
        $agentLog->delivery_type_id = $request->delivery_type_id;
        $agentLog->save();

        $response['success'] = true;     $response['message'] = 'Delivery type changed successfully'; $response['data'] = [];     $code = 200; 
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

    /**
     * @OA\Get(
     *     path="/delivery/public/api/supervisor/download-profile-document",
     *     operationId="/delivery/public/api/supervisor/download-profile-document",
     *      tags={"Supervisor Login"},
     *      summary= "download Profile Document",
     *      description = "download Profile Document",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="",
     *         explode=true
     *     ),
     *    @OA\RequestBody(
     * 
     *    ),
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
     *      security={ {"bearer": {}} },
     * ) 
     */
    /*** End of Annotation For downloadProfileDocument ***/
    protected function downloadProfileDocument(Request $request)
    {
        $file_name = $request->file;
        
        try{
        /**doenload file **/
        
        
        $file= public_path(). $file_name;

        $headers = array(
              'Content-Type: application/pdf',
            );

        return response()->download($file, 'agent_report.pdf', $headers);

        
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
             $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }





    protected function deliverytypeselected(Request $request)
    {
            $user_id = $request->user_id;  ///agent_id

                $validator = \Validator::make($request->all(),[
                'user_id' => 'required',
            ]);

            if ($validator->fails()) { 
                $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
                return response()->json($response, $code);
            }

            
            try{
                
            $agentLog = TblUserLoginLog::where(array('id'=>$request->id,'user_id'=>$user_id))
                                                ->select('delivery_type_id')
                                                ->first();
                 $delivery_type_id = $agentLog->delivery_type_id;     
                 
                 $delivery_type = TblDeliveryType::where('id',$delivery_type_id)
                 ->select('id','name')
                 ->first();                  
            

            $response['success'] = true;     $response['message'] = 'success'; $response['data'] = $delivery_type;     $code = 200; 
            }catch(\Exception $ex){
                \Log::Info($ex->getMessage());
                $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
            }   
            return response()->json($response, $code);


    }

  
}
