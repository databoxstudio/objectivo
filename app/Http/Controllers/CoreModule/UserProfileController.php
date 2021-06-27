<?php

namespace App\Http\Controllers\CoreModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function index(){
		return view('coreModule.userProfile.index');    	
    }

    public function create(){
		return view('coreModule.userProfile.create');    	
    }
}
