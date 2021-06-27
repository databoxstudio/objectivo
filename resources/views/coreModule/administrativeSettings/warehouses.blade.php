@extends('layouts.app')



@section('content')
<div class="page-content">
    
    
        <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="">
                                        <input type="hidden" name="status" value="<?php echo isset($_GET['status']) ? $_GET['status'] : '' ;?>">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Search Text</label>
                                <input type="text" class="form-control" name="search_text" value="<?php echo ((isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : "")); ?>" placeholder="Search Text">
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location">State</label>
                                <select class="form-control" id="location" name="state_id">
                                    <option selected="" disabled="">Select State</option>
                                  
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location">City</label>
                                <select class="form-control" id="location" name="city_id">
                                    <option selected="" disabled="">Select City</option>
                                  
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location">&nbsp;</label>
                                   <button class="btn btn-success">Filter Profiles</button>
                            </div>
                        </div>

                    </div>
                 
                </form>
            </div>
        </div>
    </div>


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
                  <h6 class="card-title mb-0">Warehouses</h6>
              
                  <div class="dropdown mb-2">
                   
                    <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.addwarehouse')}}"> <span class="">Add New Warehouse</span></a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0">Warehouse ID</th>
                        <th class="pt-0">Warehouse Name</th>
                        <th class="pt-0">Warehouse Address</th>
                        <th class="pt-0">State / City</th>
                        <th class="pt-0">Action</th>
                        
                    </thead>
                    <tbody>
                    @foreach($warehouses as $warehouse)
                      <tr>
                      
                        <td><span class="badge badge-danger">{{$warehouse->id}}</span></td>
                        <td>{{$warehouse->name}}</td>
                        <td>{{$warehouse->address}}</td>
                        <td>{{$warehouse->State->name}} / {{$warehouse->City->name}}</td>
                        <td><a href="{{URL::to('/')}}/coreModule/editwarehouse/{{$warehouse->id}}"><i data-feather="edit-3" class="icon-sm mr-2"></i></a> | <a href="{{route('coreModule.administrativeSettings.deletewarehouse',$warehouse->id)}}" onclick="if (!confirm('Are you sure to delete this record?')) { return false }"><i data-feather="trash" class="icon-sm mr-2"></i></i></a></td> 
                         

                      </tr>
                    @endforeach
                    </tbody>
                  </table>

                  <div class="pagination">
                  <?php //echo $category->render(); ?>

                    </div>

                </div>
              </div> 
            </div>
          </div>

</div>
@endsection
