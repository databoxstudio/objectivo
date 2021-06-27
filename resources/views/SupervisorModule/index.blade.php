@extends('layouts.app')







@section('content')

<div class="page-content">

    

    

        <div class="col-lg-12 col-xl-12 stretch-card">

        <div class="card">

            <div class="card-body">

                <form action="">

                                      

                    <div class="row">

                        <div class="col-sm-3">

                            <div class="form-group">

                                <label class="control-label">Search Text</label>

                                <input type="text" class="form-control" name="search_text" value="<?php echo ((isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : "")); ?>" placeholder="Search Text">

                            </div>

                        </div>

                       

                        <div class="col-sm-3">

                            <div class="form-group">

                                <label for="location">Warehouse</label>

                                <select class="form-control" id="warehouse_id" name="warehouse_id">

                                   

                                    <option selected="" disabled="">Select Warehouse</option>

                                      @foreach($warehouses as $warehouse)

                                          <option value="{{$warehouse->id}}" <?php if(isset($_REQUEST['warehouse_id']) == $warehouse->id ){ echo "selected"; } ?> >{{$warehouse->name}}</option>



                                                        @endforeach

                                  

                                </select>

                            </div>

                        </div>



                        <div class="col-sm-2">

                            <div class="form-group">

                                <label for="location">&nbsp;</label>

                                   <button class="btn btn-success">Filter Profiles</button>

                            </div>

                        </div>



                         <div class="col-sm-2">

                            <div class="form-group">

                                <label for="location">&nbsp;</label>

                                  <a href="{{route('supervisorsModule.supervisors')}}" class="btn btn-success">Reset Filter</a>

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

                  <h6 class="card-title mb-0">Supervisors</h6>

                  <div class="dropdown mb-2">

                      <a class="btn btn-success" href="{{route('supervisorsModule.exportSupervisor')}}"> <span class="">Export Supervisor</span></a>


                    <a class="btn btn-success" href="{{route('supervisorsModule.create')}}"> <span class="">Add New Supervisor</span></a>

                  </div>

                </div>

                <div class="table-responsive">

                  <table class="table table-hover mb-0">

                    <thead>

                      <tr>

                         <th class="pt-0">ID</th> 

                        <th class="pt-0">Supervisor Name</th>

                        <th class="pt-0">Mobile Number</th>

                        <th class="pt-0">Local Address</th>

                        <th class="pt-0">Permanent Address</th>

                        <th class="pt-0">Action</th>

                        

                    </thead>

                    <tbody>

                     @foreach($users as $user)

                      <tr>

                         <td>{{$user->id}}</td>

                        <td>{{$user->first_name}} {{$user->last_name}}</td>

                        <td>{{$user->wareHouse->name}}</td>

                        <td>{{$user->local_address_line_1}} {{$user->local_address_line_2}}

                            {{$user->localState->name}} {{$user->localCity->name}}

                            {{$user->local_address_pincode}}

                        </td>

                        <td>{{$user->permanent_address_line_1}} {{$user->permanent_address_line_2}}

                            {{$user->permanentState->name}} {{$user->permanentCity->name}}

                            {{$user->permanent_address_pincode}}</td>

                        <td><a href="{{route('supervisorsModule.view',$user->id)}}" class="view_client" ids="{{$user->id}}"><i class="icon-sm mr-2" data-feather="eye"></i></a> | <a href="{{route('supervisorsModule.edit',$user->id)}}"><i data-feather="edit-3" class="icon-sm mr-2"></i></a> | <a href="{{route('supervisorsModule.delete',$user->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i></i></a></td> 

           



                      </tr>

                      @endforeach

                     

                    </tbody>

                  </table>

                  <div class="pagination">

                        <?php echo $users->render();?>



                    </div>

                </div>

              </div> 

            </div>

          </div>



</div>

@endsection

