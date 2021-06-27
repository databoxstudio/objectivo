<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Storage;
use App\TblUserLoginLog;

class AgentLogsController extends Controller
{

    /***Annotation For Start Day ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/start-day",
     *     operationId="/delivery/public/api/start-day",
     *      tags={"Agent Login"},
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
     *                   example="Dropdown",     
     *               ),
     *               @OA\Property(
     *                   property="delivery_type_id",
     *                   type="string",
     *                   example="dropdown",     
     *               ),
     *               @OA\Property(
     *                   property="collected_package",
     *                   type="string",
     *                   example="",     
     *               ),
     *               
     *              @OA\Property(
     *                   property="c_returned_package",
     *                   type="string",
     *                   example="",     
     *               ),
     *              
     *              @OA\Property(
     *                   property="login_latitude",
     *                   type="string",
     *                   example="Current Location latitude",     
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
    /*** End of Annotation For Update Basic Details ***/
    protected function startDay(Request $request)
    {
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'warehouse_id' => 'required',
            'supervisor_id' => 'required',
            'delivery_type_id' => 'required',
            'collected_package' => 'required',
            'c_returned_package' => 'required',
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
            print_r($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

    /***Annotation For End Day ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/end-day",
     *     operationId="/delivery/public/api/end-day",
     *      tags={"Agent Login"},
     *      summary= "End Day",
     *      description = "End Day",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *              
     *               @OA\Property(
     *                   property="delivered_package",
     *                   type="string",
     *                   example="",     
     *               ),
     *              @OA\Property(
     *                   property="c_returned_package_collected",
     *                   type="string",
     *                   example="",     
     *               ),
     *               
     *              
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
    /*** End of Annotation For Agent login ***/
    protected function endDay(Request $request)
    {
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'delivered_package' => 'required',
            'c_returned_package_collected' => 'required',
            'logout_latitude' => 'required',
            'logout_longitude' => 'required'
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            
        }
        try{
        /**Save data**/
        $user_id = $auth_user->id;
       // $user_log_obj = TblUserLoginLog::where('user_id',$user_id)->whereNull('logout_date')->orderBy('id','DESC')->first();
         $user_log_obj =  TblUserLoginLog::where('user_id',$user_id)->where('login_date',date('d-m-Y'))->whereNull('logout_date')->orderBy('id','DESC')->first();

        $user_log_obj->logout_latitude = $request->logout_latitude;
        $user_log_obj->logout_longitude = $request->logout_longitude;
        $user_log_obj->logout_date = date('d-m-Y');
        $user_log_obj->logout_time = date('h:i:s A');
        $user_log_obj->delivered_package = $request->delivered_package;
        $user_log_obj->c_returned_package_collected = $request->c_returned_package_collected;
            
        $user_log_obj->save();
        $request->user()->token()->revoke();      
        $response['success'] = true;     $response['message'] = 'Logged-out and Day ended successfully'; $response['data'] = "";     $code = 200; 
        }catch(\Exception $ex){
            print_r($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

     function updatePackets(Request $request)
    {
        
        $auth_user = $request->user();
        $validator = \Validator::make($request->all(),[
            'collected_package' => 'required',
            'c_returned_package' => 'required'
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
           
        }
        try{
        /**Save data**/
            $user_id = $auth_user->id;
            
            //$log =  TblUserLoginLog::where('user_id',$user_id)->where('login_date',date('d-m-Y'))->orderBy(DB::Raw('DATE(login_date)'),'DESC')->first();
             $log =  TblUserLoginLog::where('user_id',$user_id)->where('login_date',date('d-m-Y'))->orderBy('id','DESC')->first();
            if(!empty($log)){
                $log->collected_package = $request->collected_package;
                $log->c_returned_package = $request->c_returned_package;
                $log->save();
                $response['success'] = true;     $response['message'] = 'Packages successfully'; $response['data'] = "";     $code = 200; 
            }else{
                $response['success'] = true;     $response['message'] = 'Record not found'; $response['data'] = "";     $code = 400; 
            }
       

        
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

    protected function downloadIdCard(Request $request)
    {        
        $file_name = $request->file;
        
        try{
        /**doenload file **/
        
        
        $file= public_path(). $file_name;

        $headers = array(
              'Content-Type: application/pdf',
            );

        return response()->download($file, 'id_card.pdf', $headers);

        
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
             $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }
    protected function returnIdCardUrl(Request $request)
    {        
        $auth_user = $request->user();
        try{
        /**doenload file **/
        if(!empty($auth_user->id_card_doc)){
            
            $download_url = route("agent_idcard_url",['file'=>"$auth_user->id_card_doc"]);

            $response['success'] = true;     $response['data']['agent_idcard_url'] = $download_url;     $code = 200; 

           
        }else{
            $response['success'] = false;     $response['message'] = 'Your profile is under review. Please try after sometime';     $code = 400; 
        }
        

        
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
             $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 
        }   
        return response()->json($response, $code);
    }

}
