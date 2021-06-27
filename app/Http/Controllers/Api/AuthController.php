<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Socialite;
use DB;

class AuthController extends Controller
{
    private $twilio='';
    private $twilio_verify_sid = "";
    
    public function __construct() {
        /**
         * @OA\Info(title="Delivery API", version="" )
         */
        /* Get credentials from .env */
       $token = getenv("TWILIO_AUTH_TOKEN");
       $twilio_sid = getenv("TWILIO_SID");
       $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
       $this->twilio = new Client($twilio_sid, $token);
    }

    

    /***Annotation For Resend OTP ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/resend-otp",
     *     operationId="/delivery/public/api/resend-otp",
     *     tags={"Login with OTP"},
     *      summary= "Resend OTP",
     *      description = "Resend OTP sent to phone number while login",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Resend OTP ***/
    protected function resendOTP(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'phone_number' => ['required', 'string'],
        ]);
        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
       
        try{
            $v = $this->twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create($data['phone_number'], "sms");
            $response['success'] = true;     $response['message'] = 'OTP sent to your phone';     $response['data'] =  "";     $code = 200;    
        }catch(\Exception $ex){
        	\Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something1 went wrong';     $response['data'] =  "";     $code = 400;
        }
        
        return response()->json($response, $code);
    }


    /***Annotation For Verify OTP ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/verify-otp",
     *     operationId="/delivery/public/api/verify-otp",
     *     tags={"Login with OTP"},
     *      summary= "Verify OTP",
     *      description = "Verify OTP sent to phone number while login",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               ),   
     *               @OA\Property(
     *                   property="verification_code",
     *                   type="string",
     *					 example="",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Verify OTP ***/
    protected function verifyOTP(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
       
       try{
        
             $verification = $this->twilio->verify->v2->services($this->twilio_verify_sid)
                             ->verificationChecks
                             ->create($data['verification_code'], array('to' => $data['phone_number']));
                         
             if ($verification->valid) {
                User::where('phone_number', $data['phone_number'])->update(['isVerified' => true]);
                $user = User::where('phone_number', $data['phone_number'])->first();
                /* Authenticate user */
                $accessToken = $user->createToken('authToken')->accessToken;
                
                $result_data['access_token'] = $accessToken;
                $result_data['user_type'] = $user->role;
                $response['success'] = true;     $response['message'] = 'OTP verified successfully';     $response['data'] =  $result_data;     $code = 200;
             }else{
                 $response['success'] = false;     $response['message'] = 'Verfication failed';     $response['data'] =  "";     $code = 400;
             }
       }catch(\Exception $ex){ 
           \Log::Info($ex->getMessage());
        $response['success'] = false;     $response['message'] = 'Something went wrong';     $response['data'] =  "";     $code = 400;
       }
        
        return response()->json($response, $code);
    }

    /***Annotation For Login with phone and password ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/login",
     *     operationId="/delivery/public/api/login",
     *     tags={"Login"},
     *      summary= "Login",
     *      description = "Login with phone number and password",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               ),   
     *               @OA\Property(
     *                   property="password",
     *                   type="string",
     *					 example="",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Login with phone and password ***/
    protected function login(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'phone_number' => 'string|required',
            'password' => 'required|string',
            'user_type' => 'required|string',
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
       
        $credentials = request(['phone_number', 'password']);
       
               
       if(!Auth::attempt($credentials)){
        $response['success'] = false;     $response['message'] = "Phone and password do not match";
            return response()->json($response, 401); 
        
        }

        $user = $request->user();
        if($user->role != $request->user_type){
            $response['success'] = false;     
            $response['message'] = "Invalid access";
            return response()->json($response, 401);   
        }

        if($user->role==User::AGENT && !$user->isVerified){
            $response['success'] = false;     
            $response['message'] = "Verification is pending";
            return response()->json($response, 400);   
        }

        
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1); 
        }
        $token->save();

        $result_data = [
                        'access_token' => $tokenResult->accessToken,
                        'user_type'=>$user->role
                    ];

        $response['success'] = true;     $response['message'] = "Logged In successfully" ;    $response['data'] =  $result_data;     $code = 422;
        return response()->json($response, 200); 
    }


   /***Annotation For Login with OTP ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/login-with-otp",
     *     operationId="/delivery/public/api/login-with-otp",
     *     tags={"Login with OTP"},
     *      summary= "Login with OTP",
     *      description = "Login sending otp on phone number",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               ),
     *              @OA\Property(
     *                   property="user_type",
     *                   type="string",
     *                   example="agent/supervisor",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Login with OTP ***/
    protected function loginWithOTP(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'phone_number' => ['required'],
            'user_type' => ['required'],
        ]);

        \Log::Info(json_encode($request->all()));
        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();     $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
        }
       
        try{
            //Check if user with phone number exists
            if($request->user_type==User::AGENT){
                $exists = User::where('phone_number',$request->phone_number)->exists();
        
                if(!$exists){
                    $user_data = ['phone_number'=>$request->phone_number,'role'=>$request->user_type];

                    User::create($user_data);
                }
            }elseif($request->user_type==User::SUPERVISOR){
                $exists = User::where('phone_number',$request->phone_number)->where('role',$request->user_type)->exists();
        
                if(!$exists){
                    $response['success'] = false;     $response['message'] = "Supervisor user with this phone number does not exists";     $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
                }
            }
            

            $v = $this->twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create($data['phone_number'], "sms");
                $response['success'] = true;     $response['message'] = 'OTP sent to your phone';     $response['data'] =  "";     $code = 200;    
        }catch(\Exception $ex){
            \Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = $ex->getMessage();     $response['data'] =  "";     $code = 400;
        }

       
        
        return response()->json($response, $code);
    }

    /*** Annotation For Logout ***/
    /**
     * @OA\Get(
     *     path="/delivery/public/api/logout",
     *     operationId="/delivery/public/api/logout",
     *     tags={"Logout"},
     *     summary= "Logout user",
     *     description = "Logout",
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     *    security={ {"bearer": {}} },
     * ) 
     */
    protected function logout(Request $request)
    {
        $request->user()->token()->revoke();      
        $response['success'] = true;     $response['message'] = 'Successfully logged out';     $code = 200; 
        return response()->json($response, $code);

    }

   /***Annotation For Send Forgot Password OTP ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/send-forgot-password-otp",
     *     operationId="/delivery/public/api/send-forgot-password-otp",
     *     tags={"Forgot Password OTP"},
     *      summary= "Resend OTP",
     *      description = "Send OTP sent to phone number for forgot password",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Resend OTP ***/
    protected function SendForgotPasswordOTP(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'phone_number' => ['required', 'string','exists:users,phone_number'],
        ]);
        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
       
        try{
            $v = $this->twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create($data['phone_number'], "sms");
            $response['success'] = true;     $response['message'] = 'OTP sent to your phone';     $response['data'] =  "";     $code = 200;    
        }catch(\Exception $ex){
        	\Log::Info($ex->getMessage());
            $response['success'] = false;     $response['message'] = 'Something went wrong';     $response['data'] =  "";     $code = 400;
        }
        
        return response()->json($response, $code);
    }

/***Annotation For Verify Forgot Password OTP ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/verify-forgot-password-otp",
     *     operationId="/delivery/public/api/verify-forgot-password-otp",
     *     tags={"Forgot Password OTP"},
     *      summary= "Verify OTP",
     *      description = "Verify OTP sent to phone number while fotgot password",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               ),   
     *               @OA\Property(
     *                   property="verification_code",
     *                   type="string",
     *					 example="",     
     *               )
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Verify OTP ***/
    protected function verifyForgotPasswordOTP(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = getFirstErrorMessage($validator->errors());    $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
            return response()->json($response, $code);
        }
       
       try{
        
             $verification = $this->twilio->verify->v2->services($this->twilio_verify_sid)
                             ->verificationChecks
                             ->create($data['verification_code'], array('to' => $data['phone_number']));
                         
             if ($verification->valid) {
               
                $response['success'] = true;     $response['message'] = 'OTP verified successfully';     $response['data'] =  [];     $code = 200;
             }else{
                 $response['success'] = false;     $response['message'] = 'Verfication failed';     $response['data'] =  "";     $code = 400;
             }
       }catch(\Exception $ex){ 
          \Log::Info($ex->getMessage());
        $response['success'] = false;     $response['message'] = 'Something went wrong';     $response['data'] =  "";     $code = 400;
       }
        
        return response()->json($response, $code);
    }


  /***Annotation For Reset Password ***/
    /**
     * @OA\Post(
     *     path="/delivery/public/api/reset-password",
     *     operationId="/delivery/public/api/reset-password",
     *     tags={"Forgot Password OTP"},
     *      summary= "Reset Password",
     *      description = "Reset password",
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="phone_number",
     *                   type="string",
     *					 example="+91XXXXXXXXXX",     
     *               ),
     *              @OA\Property(
     *                   property="password",
     *                   type="string",
     *					 example="",     
     *               ),
     *              @OA\Property(
     *                   property="password_confirmation",
     *                   type="string",
     *					 example="",     
     *               ),
     *           ),
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
     * ) 
     */
    /*** End of Annotation For Reset Password ***/
    protected function resetPassword(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($request->all(),[
            'phone_number' => 'string|required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) { 
            $response['success'] = false;     $response['message'] = $validator->errors();     $response['data'] =  "";     $code = 422;     return response()->json($response, $code);
        }
       
        $user = User::where('phone_number',$request->phone_number)->first();
        $user->password = bcrypt($request->password);
	    $user->save();
        $response['success'] = true;     $response['message'] = 'Password reset successfully';     $code = 200; 
        return response()->json($response, $code);
    }


    protected function getUser(Request $request)
    {
        
       
        $user = Auth::user();
        
        $response['success'] = true;     $response['data'] = $user;     $code = 200; 
        return response()->json($response, $code);
    }
   
}
