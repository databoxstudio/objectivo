<?php



namespace App\Http\Controllers\CoreModule;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\TblWarehouse;

use App\TblDeliveryType;

use App\TblState;

use App\TblBank;

use App\TblCity;











class administrativeSettingsController extends Controller

{







    	public function index(){



    	return view('coreModule.administrativeSettings.index');

    }





    public function emailmanagement(){

        $emailSetting = EmailSetting::all();

        return view('coreModule.administrativeSettings.emailmanagement')->with('emailSetting',$emailSetting);

    }



    public function addemailmanagement(){

        return view('coreModule.administrativeSettings.addemailmanagement');

    }



    public function updateemailmanagement(Request $request){

            $emailSetting = EmailSetting::where('id',$request->id)->first();

            $emailSetting->email_subject = $request->email_subject;

            $emailSetting->email_to = $request->email_to;

            $emailSetting->email_cc = $request->email_cc;

            $emailSetting->email_body = $request->tinymce;

            $emailSetting->update();

        return redirect()->back()->with(array('message'=> 'Email settings updated successfully!','id'=>$request->id));

    }



/**********************************************************/

/*            Warehouse                                   */

/**********************************************************/



    public function warehouses(){ 

        

        $query = TblWarehouse::query();

        $request = $_REQUEST;

        $query->where('status',1);

      

       if(isset($request) && !empty($request)){

           

        if (isset($request['search_text']) && $request['search_text'] != '' ) {

        $term = $request['search_text'];

          $query->where(function ($query) use ($term) {

              return $query->whereRaw('lower(name) like (?)', ["%{$term}%"])->orWhereRaw('lower(address) like (?)', ["%{$term}%"]);

          });

        } 

        

        if (isset($request['state_id']) && $request['state_id'] != '' ) {

           $query->where('state_id', $request['state_id']);

        }

        

        if (isset($request['city_id']) && $request['city_id'] != '' ) {

           $query->where('city_id', $request['city_id']);

        }

         

        $warehouses =  $query->with('State','City')->orderBy('id', 'DESC')->paginate(20)->appends(request()->query());

         

       } else {



        $warehouses =  TblWarehouse::where('status',1)->paginate(20);

        

      }

      

        

        return view('coreModule.administrativeSettings.warehouses')->with('warehouses',$warehouses);



    }

    

    public function addwarehouse(){

        $states = TblState::where('status','1')->get();

        $cities = TblCity::where('status','1')->get();

    	return view('coreModule.administrativeSettings.addwarehouse')->with(array('states'=>$states,'cities'=>$cities));

    }



    public function createwarehouse(Request $request){



        $this->validate($request,[

            'name' => 'required|unique:tbl_warehouses,name'

         ]);

        TblWarehouse::create($request->all());

        return redirect()->back()->with('message', 'Warehouse Created successfully!');

    }



    public function editwarehouse($warehouse_id){

        $states = TblState::where('status','1')->get();

        $cities = TblCity::where('status','1')->get();

        $warehouses =  TblWarehouse::where('id',$warehouse_id)->first();

        return view('coreModule.administrativeSettings.editwarehouse', compact('states','cities','warehouses'));

    	

    }



    public function updatewarehouse(Request $request){

        

        $warehouse =  TblWarehouse::where('id',$request->warehouse_id)->first();



        $warehouse->name = $request->name;

        $warehouse->address = $request->address;

        $warehouse->state_id = $request->state_id;

        $warehouse->city_id = $request->city_id;

        $warehouse->zipcode = $request->zipcode;

        $warehouse->update();

        return redirect()->back()->with('message', 'Warehouse updated successfully!');

    }



    public function deletewarehouse($id){

        $warehouse =  TblWarehouse::where('id',$id)->first();

        $warehouse->delete();

        return redirect()->back()->with('message', 'Warehouse deleted successfully!');

    }







/**********************************************************/

/*           Delivery Types                               */

/**********************************************************/



    public function deliverytypes(){ 

        $deliverytypes =  TblDeliveryType::paginate(10);

        return view('coreModule.administrativeSettings.deliverytypes')->with('deliverytypes',$deliverytypes);



    }

    

    public function adddeliverytype(){

        $deliverytypes =  TblDeliveryType::all();

        return view('coreModule.administrativeSettings.adddeliverytype')->with('deliverytypes', $deliverytypes );

    }



    public function createdeliverytype(Request $request){



        $this->validate($request,[

            'name' => 'required|unique:tbl_delivery_types,name',
            'delivery_rate' => 'required'

         ]);

        TblDeliveryType::create($request->all());

        return redirect()->back()->with('message', 'Delivery Type Created successfully!');

    }



    public function editdeliverytype($deliverytype_id){



        $deliverytypes =  TblDeliveryType::where('id',$deliverytype_id)->first();

        return view('coreModule.administrativeSettings.editdeliverytype')->with('deliverytypes', $deliverytypes );

    }



      public function updatedeliverytype(Request $request){

        

        $deliverytype =  TblDeliveryType::where('id',$request->deliverytype_id)->first();



        $deliverytype->name = $request->name;
        $deliverytype->delivery_rate = $request->delivery_rate;

        $deliverytype->update();

        return redirect()->back()->with('message', 'Update successful!');

    }

    

    

    public function deletedeliverytype($id){

        $deliverytype =  TblDeliveryType::where('id',$id)->first();

        $deliverytype->delete();

        return redirect()->back()->with('message', 'Delivery Type deleted successfully!');

    }





/**********************************************************/

/*           Bank                                         */

/**********************************************************/



    public function banks(){ 

        $banks =  TblBank::paginate(50);

        return view('coreModule.administrativeSettings.banks')->with('banks',$banks);



    }

    

    public function addbank(){

        return view('coreModule.administrativeSettings.addbank');

    }



    public function createbank(Request $request){



        $this->validate($request,[

            'name' => 'required|unique:tbl_banks,name'

         ]);

        TblBank::create($request->all());

        return redirect()->back()->with('message', 'Bank Created successfully!');

    }



    public function editbank($bank_id){



        $banks =  TblBank::where('id',$bank_id)->first();

        return view('coreModule.administrativeSettings.editbank')->with('banks', $banks );

    }



    public function updatebank(Request $request){

        

        $banks =  TblBank::where('id',$request->bank_id)->first();



        $banks->name = $request->name;

        $banks->update();

        return redirect()->back()->with('message', 'Bank updated successfully!');

    }



    public function deletebank($id){

        $banks =  TblBank::where('id',$id)->first();

        $banks->delete();

        return redirect()->back()->with('message', 'Bank deleted successfully!');

    }






    public function getCityList(Request $request)
    {
        $cities = DB::table("tbl_cities")
                    ->where("state_id",$request->state_id)
                    ->lists("name","id");
        return response()->json($cities);
    }





}

