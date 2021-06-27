<?php



namespace App\Http\Controllers\AgentsModule;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;

use App\UserMeta;
use App\TblAgentSupervisorMapping;



class AgentController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $supervisor =  User::where('role','supervisor')->get();
        $query = User::query();
        $request = $_REQUEST;
        $query->where(array('role'=>'agent','is_blacklisted'=>0));

       if(isset($request) && !empty($request)){

        if (isset($request['search_text']) && $request['search_text'] != '' ) {
        $term = $request['search_text'];
          $query->where(function ($query) use ($term) {

              return $query->whereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(phone_number) like (?)', ["%{$term}%"])->orWhereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(concat(first_name,\' \',last_name)) like (?)', ["%{$term}%"])->orWhereRaw('id like (?)',["%{$term}%"]);

          });

        } 

        $users =  $query->with('wareHouse')->orderBy('id', 'DESC')->paginate(20)->appends(request()->query());

         

       } else {



        $users =  User::where(array('role'=>'agent','is_blacklisted'=>0))->paginate(20);

        

      }


      foreach($users as $user){
                $mappingdata = TblAgentSupervisorMapping::where('agent_id',$user->id)->first();
                $supervisordata = User::where('id',@$mappingdata->supervisor_id)->first();
                $user['supervisor'] = $supervisordata;
      }


      return view('AgentModule.index')->with(array('users'=>$users,'supervisors'=>$supervisor)); 

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

         $users =  User::all();

        return view('AgentModule.create')->with('users',$users); 

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

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

        return view('AgentModule.view')->with('users',$users); 

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

         $users =  User::all();

        return view('AgentModule.edit')->with('users',$users); 

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function delete($id)

    {

        

    }

    

    

    public function blacklist($id){

        $agent =  User::where('id',$id)->first();
        $agent->is_blacklisted=1;
        $agent->update();
        return redirect()->back()->with('message', 'Agent blacklisted successfully!');

    }



    public function enable($id){

        $agent =  User::where('id',$id)->first();
        $agent->is_blacklisted=0;
        $agent->update();
        return redirect()->back()->with('message', 'Agent Unblocked successfully!');

    }





    public function blacklistedDa()

    {

        $supervisor =  User::where('role','supervisor')->get();

         $blacklistedagent =  $users =  User::where('is_blacklisted','1')->paginate(10);

        return view('AgentModule.blacklistedagent')->with(array('users'=>$blacklistedagent,'supervisors'=>$supervisor)); 

    }

    
    public function exportAgents(Request $request)
    {

      
        $fileName = 'supervisor.csv';
        //$query = User::query();
        $request = $_REQUEST;
        //$query->where('role' ,'supervisor');

        $users =  User::where('role','agent')->get();
      

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

