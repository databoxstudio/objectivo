<?php



namespace App\Http\Controllers\ReportsModule;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;



use App\User;

use App\TblUserLoginLog;
use App\TblAgentSupervisorMapping;


class ReportController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function dailydeliveryreport(Request $request)
    {
            if(!empty($_REQUEST['login_date'])){
                 $logindate = date('d-m-Y',strtotime($_REQUEST['login_date']));
            } else {
                $logindate =  date('d-m-Y',time());
            }

            $dailyreports = TblUserLoginLog::whereDate('login_date', '=', $logindate)
            ->select('user_id','login_date')
            ->distinct()->paginate(20);
            $x=0;


            

            foreach($dailyreports as $dailyreport){
                //echo $dailyreport->user_id;

                $dailyreportdetail = TblUserLoginLog::whereDate('login_date', '=', $logindate)
                ->where('user_id',$dailyreport->user_id)
                ->get();

              //  dd($dailyreportdetail);


                $dailyreports[$x]['dailyreportdetail'] = $dailyreportdetail;
                $x++;
            }

          //  dd($dailyreports);

        return view('ReportModule.dailydeliveryreport')->with('dailyreports',$dailyreports); 

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function weeklydeliveryreport()

    {

            //$weekrange = $this->weekgenerator();
            $agents = User::where('role', '=', 'agent')
                        ->where('first_name','!=','')
                        //->where('first_name',0)
                      ->where('is_blacklisted',0)
                        ->get();

            if(!empty($_REQUEST['from_date'])){
                $from = date('d-m-Y',strtotime($_REQUEST['from_date']));
               
            }
            if(!empty($_REQUEST['to_date'])){
                $to = date('d-m-Y',strtotime($_REQUEST['to_date']));
                
            }
            if(!empty($_REQUEST['agent'])){
                 $agent_id = $_REQUEST['agent'];
            }  



             $dadetail = User::where('id', '=', @$agent_id)
                ->first();
          

            $weeklyreports = TblUserLoginLog::whereBetween('login_date', [@$from, @$to])
                                ->where('user_id',@$agent_id)
                                ->get();


            $x=0;

            foreach($weeklyreports as $weeklyreport){

                $userdetail = User::where('id', '=', $weeklyreport->user_id)
                ->get();

                $weeklyreports[$x]['userdetail'] = $userdetail;

                $x++;

            }



            return view('ReportModule.weeklydeliveryreport')->with(array('weeklyreports'=>$weeklyreports,'agents'=>$agents,'dadetail'=>$dadetail));  

    }





    public function exportweeklyReport(Request $request)
    {

       if(!empty($_REQUEST['from_date'])){
            $from = date('d-m-Y',strtotime($_REQUEST['from_date']));
           
        }
        if(!empty($_REQUEST['to_date'])){
            $to = date('d-m-Y',strtotime($_REQUEST['to_date']));
            
        }
        if(!empty($_REQUEST['agent'])){
             $agent_id = $_REQUEST['agent'];
        }  


         $fileName = 'weeklyreport.csv';
         

          $weeklyreports = TblUserLoginLog::whereBetween('login_date', [@$from, @$to])
                           ->where('user_id',@$agent_id)
                           ->get();

            $x=0;
            foreach($weeklyreports as $weeklyreport){
                $userdetail = User::where('id', '=', $weeklyreport->user_id)
                ->get();
                $weeklyreports[$x]['userdetail'] = $userdetail;
                $x++;
            }

         print_r($tasks);

         exit;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Title', 'Assign', 'Description', 'Start Date', 'Due Date');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
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



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function cosolreportofda(Request $request)

    {

        $agents = User::where('role', '=', 'agent')
                        ->where('first_name','!=','')
                      ->where('is_blacklisted',0)
                        ->get();

                     if(!empty($_REQUEST['agent'])){
                 $agent_id = $_REQUEST['agent'];
            }                  

              $dadetail = User::where('id', '=', @$agent_id)
                ->first();   




            if(@$_REQUEST['dateoption']=='daterange'){
                    if(!empty($_REQUEST['from_date'])){
                         $from = date('d-m-Y',strtotime($_REQUEST['from_date']));
                    }
                    if(!empty($_REQUEST['to_date'])){
                         $to = date('d-m-Y',strtotime($_REQUEST['to_date']));
                    }

                     $consolidatedreports = TblUserLoginLog::whereBetween('login_date', [@$from, @$to])
                                ->where('user_id',@$agent_id)
                                ->paginate(15);


            } else {

             if(!empty($_REQUEST['month'])){
                     $month = $_REQUEST['month'];
                }                   
                if(!empty($_REQUEST['year'])){
                     $year = $_REQUEST['year'];
                }   

                 $consolidatedreports = TblUserLoginLog::whereYear('login_date', '=' , @$year)
                                    ->whereMonth('login_date', '=' , @$month)
                                ->where('user_id',@$agent_id)
                                ->paginate(15);


            }

      
          

           


            $x=0;

            foreach($consolidatedreports as $consolidatedreport){

                $userdetail = User::where('id', '=', $consolidatedreport->user_id)
                ->get();

                $consolidatedreports[$x]['userdetail'] = $userdetail;

                $x++;

            }


        

        return view('ReportModule.cosolreportofda')->with(array('consolidatedreports'=>$consolidatedreports,'agents'=>$agents,'dadetail'=>$dadetail)); 

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function dawiseloginhr()

    {

        

          if(!empty($_REQUEST['login_date'])){

                 $logindate = $_REQUEST['login_date'];

            } else {

                $logindate =  date('yy-m-d',time());

            }

            

        $agents =  User::where('role','agent')
                        ->where('is_blacklisted',0)
                        ->where('first_name','!=','')
                        ->get();

        $supervisor =  User::where('role','supervisor')->get();
        $query = User::query();
        $request = $_REQUEST;
        $query->where(array('role'=>'agent','is_blacklisted'=>0))
                ->where('first_name','!=','');



       if(isset($request) && !empty($request)){

        if (isset($request['search_text']) && $request['search_text'] != '' ) {
        $term = $request['search_text'];
          $query->where(function ($query) use ($term) {

              return $query->whereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(phone_number) like (?)', ["%{$term}%"])->orWhereRaw('lower(email) like (?)', ["%{$term}%"])->orWhereRaw('lower(concat(first_name,\' \',last_name)) like (?)', ["%{$term}%"])->orWhereRaw('id like (?)',["%{$term}%"]);

          });

        } 

        $users =  $query->with('wareHouse')->orderBy('id', 'DESC')->paginate(10)->appends(request()->query());

         

       } else {



        $users =  User::where(array('role'=>'agent','is_blacklisted'=>0))->paginate(10);

        

      }

    

        return view('ReportModule.dawiseloginhr')->with(array('users'=>$users,'supervisors'=>$supervisor,'agents'=>$agents)); 

    }







           /* public function weekgenerator(){
                    $weeks          = array();
                    $dayOfWeek      = date('w');
                    $monday       = 1;
                    $diff           = $monday - $dayOfWeek;
                    $minus_weeks    = 4; // past 1 months

                    // create week range that starts with Thursday and ends with Wednesday for the past 3 months
                    for ($i = 0; $i <= $minus_weeks; $i++) {

                        $k = $i - 1;

                        $from_formula   = strtotime("-$i week $diff day");
                        $to_formula     = strtotime("-$k week " . ($diff - 1) . " day");
                        $ymd_week_range = date('Y-m-d', $from_formula) . ' To ' . date('Y-m-d', $to_formula);

                        $day_from   = date('j', $from_formula);
                        $day_to     = date('j', $to_formula);

                        $month_from = date('M', $from_formula);
                        $month_to   = date('M', $to_formula);

                        $year_from  = date('Y', $from_formula);
                        $year_to    = date('Y', $to_formula);

                        $weeks[] =  $ymd_week_range; //"$month_from $day_from - $month_to $day_to";

                        
                    }
                    return $weeks;
            } */










}

