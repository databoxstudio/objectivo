<?php
namespace App\Http\Controllers\SupervisorsModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\User;
use App\UserMeta;
use App\TblWarehouse;
use App\TblState;
use App\TblCity;
use Hash;



class SupervisorController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $warehouses =  TblWarehouse::where('status','1')->get();

        

        $query = User::query();

        $request = $_REQUEST;

        

        $query->where('role' ,'supervisor');



       if(isset($request) && !empty($request)){

           

        if (isset($request['search_text']) && $request['search_text'] != '' ) {

        $term = $request['search_text'];

          $query->where(function ($query) use ($term) {

              return $query->whereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(phone_number) like (?)', ["%{$term}%"])->orWhereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(concat(first_name,\' \',last_name)) like (?)', ["%{$term}%"])->orWhereRaw('id like (?)',["%{$term}%"]);

          });

        } 



        if (isset($request['warehouse_id']) && $request['warehouse_id'] != '' ) {

            $query->where('warehouse_id', $request['warehouse_id']);

        }

         

        $users =  $query->with('wareHouse')->orderBy('id', 'DESC')->paginate(25)->appends(request()->query());

         

       } else {



        $users =  User::where('role','supervisor')->paginate(10);



        

      }

      

      $warehouses =  TblWarehouse::where('status','1')->get();

      return view('SupervisorModule.index')->with(array('users'=>$users,'warehouses'=>$warehouses)); 

      

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $users =  User::all();

        $warehouses =  TblWarehouse::all();

        $states =  TblState::all();

        $cities =  TblCity::all();

        return view('SupervisorModule.create')->with(array('users'=>$users,'warehouses'=>$warehouses,'states'=>$states,'cities'=>$cities)); 

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function save(Request $request)

    {

         $this->validate($request,[
            'warehouse_id' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'local_address_line_1' => 'required',
            'local_address_state' => 'required',
            'local_address_city' => 'required',
            'local_address_pincode' => 'required',
            'permanent_address_line_1' => 'required',
            'permanent_address_state' => 'required',
            'permanent_address_city' => 'required',

         ]);

           $user = new User();
           $user->role  = 'supervisor';
           $user->first_name  = $request->first_name;
           $user->last_name  = $request->last_name;
           $user->name  = $request->first_name.' '.$request->last_name;
           $user->fathers_name = $request->last_name;
           $user->dob = $request->dob;
           $user->warehouse_id  = $request->warehouse_id;
           $user->blood_group = $request->blood_group;
           $user->local_address_line_1 = $request->local_address_line_1;
           $user->local_address_line_2 = $request->local_address_line_2;
           $user->local_address_state = $request->local_address_state;
           $user->local_address_city = $request->local_address_city;
           $user->local_address_pincode = $request->local_address_pincode;
           $user->email  = $request->email;
           $user->password =  Hash::make($request->password);
           $user->phone_number  = $request->phone_number;
           $user->permanent_address_line_1 = $request->permanent_address_line_1;
           $user->permanent_address_line_2 = $request->permanent_address_line_2;
           $user->permanent_address_state = $request->permanent_address_state;
           $user->permanent_address_city = $request->permanent_address_city;
           $user->permanent_address_pincode = $request->permanent_address_pincode;
        $user->save();
        return redirect()->back()->with('message', 'Supervisor Account Created successfully!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function view($id)

    {

        $users =  User::find($id);

        return view('SupervisorModule.view')->with('users',$users); 

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $warehouses =  TblWarehouse::all();
        $users =  User::find($id);
        $states =  TblState::all();
        $cities =  TblCity::all();

        return view('SupervisorModule.edit')->with(array('users'=>$users,'warehouses'=>$warehouses,'states'=>$states,'cities'=>$cities)); 

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request)

    {
           $this->validate($request,[
            'warehouse_id' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'local_address_line_1' => 'required',
            'local_address_state' => 'required',
            'local_address_city' => 'required',
            'local_address_pincode' => 'required',
            'permanent_address_line_1' => 'required',
            'permanent_address_state' => 'required',
            'permanent_address_city' => 'required',

         ]);



           $user =  User::where('id',$request->user_id)->first();

          // $user->role  = 'supervisor';

           $user->first_name  = $request->first_name;
           $user->last_name  = $request->last_name;
           $user->name  = $request->first_name.' '.$request->last_name;
           $user->fathers_name = $request->last_name;
           $user->dob = $request->dob;
           $user->warehouse_id  = $request->warehouse_id;
           $user->blood_group = $request->blood_group;
           $user->local_address_line_1 = $request->local_address_line_1;
           $user->local_address_line_2 = $request->local_address_line_2;
           $user->local_address_state = $request->local_address_state;
           $user->local_address_city = $request->local_address_city;
           $user->local_address_pincode = $request->local_address_pincode;
           $user->email  = $request->email;
           //$user->password =  Hash::make($request->password);

           $user->phone_number  = $request->phone_number;
           $user->permanent_address_line_1 = $request->permanent_address_line_1;
           $user->permanent_address_line_2 = $request->permanent_address_line_2;
           $user->permanent_address_state = $request->permanent_address_state;
           $user->permanent_address_city = $request->permanent_address_city;
           $user->permanent_address_pincode = $request->permanent_address_pincode;

        $user->update();

        return redirect()->back()->with('message', 'Supervisor Account Updated successfully!');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function delete($id)

    {

           

        $supervisors =  User::where('id',$id)->first();

        $supervisors->delete();

        return redirect()->back()->with('message', 'supervisors deleted successfully!');

    

    }






    public function exportSupervisor(Request $request)
    {

      
        $fileName = 'supervisor.csv';
        //$query = User::query();
        $request = $_REQUEST;
        //$query->where('role' ,'supervisor');

        $users =  User::where('role','supervisor')->get();
      

      //dd($users);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Title', 'Assign', 'Description', 'Start Date', 'Due Date');

        $callback = function() use($users, $columns) {


          dd($users);

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $task) {
                $row['Title']  = $task->title;
                $row['Assign']    = $task->assign->name;
                $row['Description']    = $task->description;
                $row['Start Date']  = $task->start_at;
                $row['Due Date']  = $task->end_at;

                fputcsv($file, array($row['Title'], $row['Assign'], $row['Description'], $row['Start Date'], $row['Due Date']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }















}

