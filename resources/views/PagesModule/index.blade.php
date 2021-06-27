@extends('layouts.app')



@section('content')
<div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <!-- <h4 class="mb-3 mb-md-0">Roles page.</h4> -->
          </div>
        </div>
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
              <div class="card-body">
              @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Pages</h6>
              
                  <div class="dropdown mb-2">
                   
                    <a class="btn btn-success" href="{{route('pagesModule.create')}}"> <span class="">Add Page </span></a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <!-- <th class="pt-0">Id</th> -->
                        <th class="pt-0">ID</th>
                        <th class="pt-0">Page title</th>                      
                        <th class="pt-0">Content</th>                                          
                        <th class="pt-0">Action</th>
                        
                    </thead>
                    <tbody>
                     @foreach($pages as $page)
                      <tr>
                         <td>{{$page->id}}</td>
                        <td>{{$page->title}}</td>
                        <td>{{$page->content}}</td>
                        
                     
                        <td><a href="/PagesModule/managepages/edit"><i data-feather="edit-3" class="icon-sm mr-2"></i></a> | <a href=""><i data-feather="trash" class="icon-sm mr-2"></i></i></a></td>           

                      </tr>
                      @endforeach
                     
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>
          </div>

</div>
@endsection
