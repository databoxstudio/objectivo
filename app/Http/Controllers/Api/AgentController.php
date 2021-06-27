<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use DB;

use Storage;

class AgentController extends Controller

{



    /***Annotation For Update Basic Details ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-basic-details",

     *     operationId="/delivery/public/api/update-basic-details",

     *      tags={"Update Profile"},

     *      summary= "Update Basic Details",

     *      description = "Basic Details",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="multipart/form-data",

     *           @OA\Schema(

     *              @OA\Property(

     *                   property="profile_image",

     *                   type="string",

     *                   example="",     

     *               ),

     *               @OA\Property(

     *                   property="first_name",

     *                   type="string",

     *					 example="",     

     *               ),

     *               @OA\Property(

     *                   property="last_name",

     *                   type="string",

     *					 example="",     

     *               ),

     *               @OA\Property(

     *                   property="fathers_name",

     *                   type="string",

     *					 example="",     

     *               ),

     *               

     *              @OA\Property(

     *                   property="dob",

     *                   type="string",

     *					 example="yyyy-mm-dd",     

     *               ),

     *              

     *              @OA\Property(

     *                   property="blood_group",

     *                   type="string",

     *					 example="",     

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

    protected function updateBasicDetails(Request $request)

    {

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

            'first_name' => 'required',

            'fathers_name' => 'required',

            'dob' => 'required',

            'blood_group' => 'required',

           // 'profile_image' => 'required|mimes:jpeg,jpg|max:20000',

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }

        \Log::Info(json_encode($request->all()));
        $user_data = $request->except('profile_image');

        $profile_image="";
        try{

         /*upload profile_image docs*/

             if(!empty($request->profile_image) && $request->profile_image->getClientOriginalExtension()!='name'){

                $profile_image = $auth_user->id."/".time()."_profile_image.".$request->profile_image->getClientOriginalExtension();

                $image = $request->file('profile_image');

                $t = Storage::disk('uploads')->put($profile_image, file_get_contents($image), 'public');

                $profile_image = '/uploads/'.$profile_image;

                $user_data['profile_image'] = $profile_image;

            }

            /*upload profile_image docs*/   

        /**Save user**/

        $user = User::find($auth_user->id);

         if(!empty($profile_image)){
            $user_data['profile_image']=$profile_image;
         }
        
        
        
        $user_data['basic_details_updated']=true;
        

        

        User::where('id',$user->id)->update($user_data);

       

            

        $response['success'] = true;     $response['message'] = 'Basic details updated successfully'; $response['data'] = "";     $code = 200; 

        }catch(\Exception $ex){

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }



    /***Annotation For Update Local Address Details ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-local-address",

     *     operationId="/delivery/public/api/update-local-address",

     *      tags={"Update Profile"},

     *      summary= "Update Local Addreess Details",

     *      description = "Update Local Addreess Details",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="application/json",

     *           @OA\Schema(

     *              

     *                

     *              @OA\Property(

     *                   property="local_address_line_1",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="local_address_line_2",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="local_address_city",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="local_address_state",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="local_address_country",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="local_address_pincode",

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

    /*** End of Annotation For Update Local address Details ***/

    protected function updateLocalAddressDetails(Request $request)

    {

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

            'local_address_line_1' => 'required',

            'local_address_city' => 'required',

            'local_address_state' => 'required',

            'local_address_pincode' => 'required'

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }

        try{

        /**Save user**/

        $user = User::find($auth_user->id);

        

        $user_data = $request->all();

        $user_data['local_address_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

       

            

        $response['success'] = true;     $response['message'] = 'Profile updated successfully'; $response['data'] = "";     $code = 200; 

        }catch(\Exception $ex){

            print_r($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }



        /***Annotation For Update Permanent Address Details ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-permanent-address",

     *     operationId="/delivery/public/api/update-permanent-address",

     *      tags={"Update Profile"},

     *      summary= "Update permanent Addreess Details",

     *      description = "Update permanent Addreess Details",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="application/json",

     *           @OA\Schema(

     *              

     *                

     *              @OA\Property(

     *                   property="permanent_address_line_1",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="permanent_address_line_2",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="permanent_address_city",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="permanent_address_state",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="permanent_address_country",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="permanent_address_pincode",

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

    /*** End of Annotation For Update permanent address Details ***/

    protected function updatePermanentAddressDetails(Request $request)

    {

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

            'permanent_address_line_1' => 'required',

            'permanent_address_city' => 'required',

            'permanent_address_state' => 'required',

            'permanent_address_pincode' => 'required'

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }

        try{

        /**Save user**/

        $user = User::find($auth_user->id);

        

        $user_data = $request->all();

        $user_data['permanent_address_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

       

            

        $response['success'] = true;     $response['message'] = 'Permanent address updated successfully'; $response['data'] = "";     $code = 200; 

        }catch(\Exception $ex){

            print_r($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }





     /***Annotation For Update KYC Aadhar ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-kyc-aadhar",

     *     operationId="/delivery/public/api/update-kyc-aadhar",

     *      tags={"Update Profile"},

     *      summary= "Update Update KYC Aadhar",

     *      description = "Update KYC Aadhar",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="multipart/form-data",

     *           @OA\Schema(

     *               @OA\Property(

     *                   property="aadhar_number",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="name_on_aadhar_card",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="aadhar_front_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

     *               ),@OA\Property(

     *                   property="aadhar_back_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

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

    /*** End of Annotation For Update KYC Aadhar ***/

    function updateKycAadhar(Request $request){

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

            //'aadhar_back_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

            //'aadhar_front_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

            'aadhar_number' => 'required',

            'name_on_aadhar_card' => 'required',

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }



        

        try{

            $user_data = $request->except('aadhar_front_snap','aadhar_back_snap');

             /*upload aadhar_front_snap docs*/

             if(!empty($request->aadhar_front_snap)  && $request->aadhar_front_snap->getClientOriginalExtension()!='name'){

                $aadhar_front_snap = $auth_user->id."/".time()."_aadhar_front_snap.".$request->aadhar_front_snap->getClientOriginalExtension();

                $image = $request->file('aadhar_front_snap');

                $t = Storage::disk('uploads')->put($aadhar_front_snap, file_get_contents($image), 'public');

                $aadhar_front_snap = '/uploads/'.$aadhar_front_snap;

                $user_data['aadhar_front_snap'] = $aadhar_front_snap;

            }

            /*upload aadhar_front_snap docs*/

            

            /*upload aadhar_back_snap docs*/

             if(!empty($request->aadhar_back_snap) && $request->aadhar_back_snap->getClientOriginalExtension()!='name'){

                $aadhar_back_snap = $auth_user->id."/".time()."_aadhar_back_snap.".$request->aadhar_back_snap->getClientOriginalExtension();

                $image = $request->file('aadhar_back_snap');

                $t = Storage::disk('uploads')->put($aadhar_back_snap, file_get_contents($image), 'public');

                $aadhar_back_snap = '/uploads/'.$aadhar_back_snap;

                $user_data['aadhar_back_snap'] = $aadhar_back_snap;

            }

            /*upload aadhar_back_snap docs*/

        $user = User::find($auth_user->id);

        

        $user_data['kyc_aadhar_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

            

            $response['success'] = true;     $response['message'] = 'Aadhar KYC updated successfully'; $response['data'] = [];     $code = 200; 

        }catch(\Exception $ex){

            \Log::Info($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }



  /***Annotation For Update KYC Driving Licence ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-kyc-driving-licence",

     *     operationId="/delivery/public/api/update-kyc-driving-licence",

     *      tags={"Update Profile"},

     *      summary= "Update Driving Licence",

     *      description = "Update KYC Driving Licence",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="multipart/form-data",

     *           @OA\Schema(

     *               @OA\Property(

     *                   property="driving_licence_number",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="name_as_on_dl",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="dob_dl",

     *                   type="string",

     *                   example="yyyy-mm-dd", 

     *               ),@OA\Property(

     *                   property="dl_issue_date",

     *                   type="string",

     *                   example="yyyy-mm-dd", 

     *               ),@OA\Property(

     *                   property="dl_expiry_date",

     *                   type="string",

     *                   example="yyyy-mm-dd", 

     *               ),@OA\Property(

     *                   property="issued_state",

     *                   type="string",

     *                   example="", 

     *               ),@OA\Property(

     *                   property="dl_front_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

     *               ),@OA\Property(

     *                   property="dl_back_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

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

    /*** End of Annotation For Update KYC Driving Licence ***/

    function updateKycDrivingLicence(Request $request){

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

           // 'dl_back_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

           // 'dl_front_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

            'driving_licence_number' => 'required',

            'dl_expiry_date' => 'required',

            'dl_issue_date' => 'required',

            'dob_dl' => 'required',

            'name_as_on_dl' => 'required',

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }



        

        try{

            $user_data = $request->except('dl_front_snap','dl_back_snap');

             /*upload dl_front_snap docs*/

             if(!empty($request->dl_front_snap) && $request->dl_front_snap->getClientOriginalExtension()!='name'){

                $dl_front_snap = $auth_user->id."/".time()."_dl_front_snap.".$request->dl_front_snap->getClientOriginalExtension();

                $image = $request->file('dl_front_snap');

                $t = Storage::disk('uploads')->put($dl_front_snap, file_get_contents($image), 'public');

                $dl_front_snap = '/uploads/'.$dl_front_snap;

                $user_data['dl_front_snap'] = $dl_front_snap;

            }

            /*upload dl_front_snap docs*/

            

            /*upload dl_back_snap docs*/

             if(!empty($request->dl_back_snap) && $request->dl_back_snap->getClientOriginalExtension()!='name'){

                $dl_back_snap = $auth_user->id."/".time()."_dl_back_snap.".$request->dl_back_snap->getClientOriginalExtension();

                $image = $request->file('dl_back_snap');

                $t = Storage::disk('uploads')->put($dl_back_snap, file_get_contents($image), 'public');

                $dl_back_snap = '/uploads/'.$dl_back_snap;

                $user_data['dl_back_snap'] = $dl_back_snap;

            }

            /*upload dl_back_snap docs*/

        $user = User::find($auth_user->id);

        

        $user_data['kyc_driving_licence_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

            

            $response['success'] = true;     $response['message'] = 'Driving Licence KYC updated successfully'; $response['data'] = [];     $code = 200; 

        }catch(\Exception $ex){

            \Log::Info($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }









  /***Annotation For Update KYC PAN ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-kyc-pan",

     *     operationId="/delivery/public/api/update-kyc-pan",

     *      tags={"Update Profile"},

     *      summary= "Update PAN",

     *      description = "Update KYC PAN",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="multipart/form-data",

     *           @OA\Schema(

     *               @OA\Property(

     *                   property="pan_number",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="name_as_on_pancard",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="pan_front_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

     *               ),@OA\Property(

     *                   property="pan_back_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

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

    /*** End of Annotation For Update KYC PAN ***/

    function updateKycPan(Request $request){

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

            //'pan_front_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

           // 'pan_back_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

            'pan_number' => 'required',

            'name_as_on_pancard' => 'required',

         ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }



        

        try{

            $user_data = $request->except('pan_front_snap','pan_back_snap');

             /*upload pan_front_snap docs*/

             if(!empty($request->pan_front_snap) && $request->pan_front_snap->getClientOriginalExtension()!='name'){

                $pan_front_snap = $auth_user->id."/".time()."_pan_front_snap.".$request->pan_front_snap->getClientOriginalExtension();

                $image = $request->file('pan_front_snap');

                $t = Storage::disk('uploads')->put($pan_front_snap, file_get_contents($image), 'public');

                $pan_front_snap = '/uploads/'.$pan_front_snap;

                $user_data['pan_front_snap'] = $pan_front_snap;

            }

            /*upload pan_front_snap docs*/

            

            /*upload pan_back_snap docs*/

             if(!empty($request->pan_back_snap) && $request->pan_back_snap->getClientOriginalExtension()!='name'){

                $pan_back_snap = $auth_user->id."/".time()."_pan_back_snap.".$request->pan_back_snap->getClientOriginalExtension();

                $image = $request->file('pan_back_snap');

                $t = Storage::disk('uploads')->put($pan_back_snap, file_get_contents($image), 'public');

                $pan_back_snap = '/uploads/'.$pan_back_snap;

                $user_data['pan_back_snap'] = $pan_back_snap;

            }

            /*upload pan_back_snap docs*/

        $user = User::find($auth_user->id);

        

        $user_data['kyc_pan_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

            

            $response['success'] = true;     $response['message'] = 'PAN KYC updated successfully'; $response['data'] = [];     $code = 200; 

        }catch(\Exception $ex){

            \Log::Info($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }



      /***Annotation For Update Bank Account ***/

    /**

     * @OA\Post(

     *     path="/delivery/public/api/update-bank-account",

     *     operationId="/delivery/public/api/update-bank-account",

     *      tags={"Update Profile"},

     *      summary= "Update Bank Account Details",

     *      description = "Update Bank Details",

     *    @OA\RequestBody(

     *      @OA\MediaType(

     *          mediaType="multipart/form-data",

     *           @OA\Schema(

     *               @OA\Property(

     *                   property="bank_ac_number",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="account_holder_name",

     *                   type="string",

     *                   example="",     

     *               ),@OA\Property(

     *                   property="bank_name",

     *                   type="string",

     *                   example="", 

     *               ),@OA\Property(

     *                   property="ifsc_code",

     *                   type="string",

     *                   example="", 

     *               ),@OA\Property(

     *                   property="branch_name",

     *                   type="string",

     *                   example="", 

     *               ),@OA\Property(

     *                   property="cancel_cheque_snap",

     *                   type="string",

     *                   example="", 

     *                   format="binary",

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

    /*** End of Annotation For Update Bank Account ***/

    function updateBankAccount(Request $request){

        $auth_user = $request->user();

        $validator = \Validator::make($request->all(),[

           // 'cancel_cheque_snap' => 'required|mimes:jpeg,jpg,pdf|max:20000',

            'bank_ac_number' => 'required',

            'account_holder_name' => 'required',

            'bank_name' => 'required',

            'ifsc_code' => 'required',

            'branch_name' => 'required',

        ]);



        if ($validator->fails()) { 

            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);

            return response()->json($response, $code);

        }



        

        try{

            $user_data = $request->except('cancel_cheque_snap');

             /*upload cancel_cheque_snap docs*/

             if(!empty($request->cancel_cheque_snap) && $request->cancel_cheque_snap->getClientOriginalExtension()!='name'){

                $cancel_cheque_snap = $auth_user->id."/".time()."_cancel_cheque_snap.".$request->cancel_cheque_snap->getClientOriginalExtension();

                $image = $request->file('cancel_cheque_snap');

                $t = Storage::disk('uploads')->put($cancel_cheque_snap, file_get_contents($image), 'public');

                $cancel_cheque_snap = '/uploads/'.$cancel_cheque_snap;

                $user_data['cancel_cheque_snap'] = $cancel_cheque_snap;

            }

            /*upload cancel_cheque_snap docs*/

            

        $user = User::find($auth_user->id);

        

        $user_data['bank_account_updated']=true;

        

        User::where('id',$user->id)->update($user_data);

            

            $response['success'] = true;     $response['message'] = 'Bank Account updated successfully'; $response['data'] = [];     $code = 200; 

        }catch(\Exception $ex){

            print_r($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        }   

        return response()->json($response, $code);

    }



    /***Annotation For Get Profile status ***/

    /**

     * @OA\Get(

     *     path="/delivery/public/api/get-profile-updated-status",

     *     operationId="/delivery/public/api/get-profile-updated-status",

     *      tags={"Update Profile"},

     *      summary= "Get Profile status",

     *      description = "Get Profile status",

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

    /*** End of Annotation For Update Bank Account ***/

    function getProfileUpdatedStatus(Request $request){

        $auth_user = $request->user();

            

        $user = User::find($auth_user->id);

        try{

        $data['profile_status'] =  User::select('basic_details_updated','local_address_updated','permanent_address_updated','kyc_aadhar_updated','kyc_driving_licence_updated','kyc_pan_updated','bank_account_updated')->where('id',$user->id)->get()->toArray();

            

            $response['success'] = true;     $response['message'] = ''; $response['data'] = $data;     $code = 200; 

        }catch(\Exception $ex){

            \Log::Info($ex->getMessage());

            $response['success'] = false;     $response['message'] = 'Something went wrong';     $code = 400; 

        } 

        return response()->json($response, $code);

    }

}

