<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\TblWarehouse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $agent = User::where('role','agent')->get();
        $agentcount = $agent->count();
        
        $supervisor = User::where('role','supervisor')->get();
        $supervisorcount = $supervisor->count();
        
        $warehouse = TblWarehouse::where('status','1')->get();
        $warehousecount = $warehouse->count();
        
        return view('home')->with(array('agentcount'=>$agentcount,'supervisorcount'=>$supervisorcount,'warehousecount'=>$warehousecount));
    }
}
