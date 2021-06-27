<?php

namespace App\Http\Controllers\PagesModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TblPage;

class PagesModuleController extends Controller
{
    public function index(){
    	$pages =  TblPage::all();
		return view('PagesModule.index')->with('pages',$pages);   	
    }

        public function create(){
         return view('PagesModule.create');
    }

            public function add(Request $request){
                 $this->validate($request,[
            'title' => 'required|unique:tbl_pages,title',
            'content' => 'required|unique:tbl_pages,content'
         ]);
        TblPage::create($request->all());
        return redirect()->back()->with('message', 'Page Created successfully!');
    }





    public function edit(){
         return view('PagesModule.edit');
    }



}
