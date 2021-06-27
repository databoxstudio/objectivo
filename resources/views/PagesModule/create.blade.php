@extends('layouts.app')
@section('content')
<div class="page-content">
<div class="row">
    

                    <div class="col-md-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                                <h6 class="card-title">Add Page</h6>
                                    <form class="forms-sample" action="{{route('pagesModule.add')}}" method="post">
                {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Page Title</label>
                                                    <input type="text" class="form-control" id="page_title" name="title" autocomplete="off" placeholder="Page Title">
                                                </div>
                                            </div><!-- Col -->
                                              
                                            <!--<div class="col-sm-6">

                                                <div class="form-group">
                                                    <label class="control-label">Page Slug</label>
                                                    <input type="text" class="form-control" id="page_slug" name="page_slug" autocomplete="off" placeholder="Page Slug">
                                                </div>
                                                
                                            </div> -->
                                           
                                        </div><!-- Row -->


                                          <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Seo Title</label>
                                                    <input type="text" class="form-control" id="page_seotitle" name="page_seotitle" autocomplete="off" placeholder="Page Title">
                                                </div>
                                            </div>
                                              
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label class="control-label">Seo keyword</label>
                                                    <input type="text" class="form-control" id="page_seokeyword" name="page_seokeyword" autocomplete="off" placeholder="Page Slug">
                                                </div>
                                                
                                            </div>
                                          
                                        </div> -->
                                          <div class="row">
                                          <!--	 <div class="col-sm-6">
                                                  <div class="form-group">
                                                    <label class="control-label">Seo Description</label>
                                                    <textarea class="simpletextarea" name="page_seodescription" id="page_seodescription" col="10" rows="6"    ></textarea>
                                                </div> 
                                             </div>-->
                                          <div class="col-sm-12">
                                                  <div class="form-group">
                                                    <label class="control-label">Content</label>
                                                    <textarea class="form-control" name="content" id="page_content" rows="10"    ></textarea>
                                                </div> 
                                             </div>

                                             
                                               </div><!-- Row -->

                                        <div class="row">
                                              
                                             <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <div class="form-check form-check-inline">
                                                 <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status" id="page_status" value="1">
                                                Active
                                            <i class="input-frame"></i><i class="input-frame"></i></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status" id="page_status" value="0">
                                                Inactive
                                            <i class="input-frame"></i><i class="input-frame"></i></label>
                                        </div>                                       
                                                </div>
                                            </div><!-- Col -->
 
                                             
                                        </div><!-- Row -->      
                                                
                                       
                                     <a href="/PagesModule/managepages" class="btn btn-light">Back</a>
                                     <button type="submit" class="btn btn-primary mr-2">Create Page</button>
                                       </form>
                            </div>
                        </div>
                    </div>
                </div>



</div>
@endsection
