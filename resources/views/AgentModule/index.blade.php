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



                                <label for="location">Supervisor</label>



                                    



                                    



                                  <select class="form-control" id="supervisor_id" name="supervisor_id">



                                   



                                    <option selected="" disabled="">Select Supervisor</option>



                                      @foreach($supervisors as $supervisor)



                                          <option value="{{$supervisor->id}}" <?php //if(isset($_REQUEST['warehouse_id']) == $warehouse->id ){ echo "selected"; } ?> >{{$supervisor->first_name}} {{$supervisor->last_name}}</option>







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



                                   <a href="{{route('agentsModule.agents')}}" class="btn btn-success">Reset Filter</a>



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
                  <h6 class="card-title mb-0">Agents</h6>

                   <div class="dropdown mb-2">

                      <a class="btn btn-success" href="{{route('agentsModule.exportAgents')}}"> <span class="">Export Agents</span></a>

                  </div>

                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>



                      <tr>



                         <th class="pt-0">ID</th>



                        <th class="pt-0">Agent Name</th>



                        <th class="pt-0">Supervisor Name</th>



                        <th class="pt-0">Mobile Number</th>



                        <th class="pt-0">Local Address</th>



                        <th class="pt-0">Action</th>



                        



                    </thead>



                    <tbody>



                     



                      @foreach($users as $user)



                      <tr>



                         <td>{{$user->id}}</td>



                        <td>{{$user->first_name}} {{$user->last_name}}

                          @if($user->first_name == '' || $user->last_name == '')
                          <p style="color:red;"><strong>Incomplete Profile</strong></p>
                          @endif

                        </td>


                        @if(@$user->supervisor->first_name != '' || @$user->supervisor->last_name != '')
                        <td>{{@$user->supervisor->first_name}} {{@$user->supervisor->last_name}}</td>
                        @else
                        <td><a href="">Assign/Change Supervisor</a></td>
                        @endif



                        <td>{{$user->phone_number}}</td>



                        <td>{{$user->local_address_line_1}} {{$user->local_address_line_2}}



                            {{@$user->localState->name}} {{@$user->localCity->name}}



                            {{$user->local_address_pincode}}



                        </td>



                       



                        <td><a href="{{route('agentsModule.view',$user->id)}}" class="view_client" ids="{{$user->id}}"><i class="icon-sm mr-2" data-feather="eye"></i></a> | 



                       <!-- <a href=""><i data-feather="edit-3" class="icon-sm mr-2"></i></a> |--> <a href="{{route('agentsModule.delete',$user->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i></a> | 



                        



                            @if($user->is_blacklisted==0)







                                  <a style="color: green;" href="{{route('agentsModule.blacklist',$user->id)}}" class="enable_location" ids="{{$user->id}}"><i class="icon-sm mr-2" data-feather="unlock"></i></a>



                                   



                                 



                                    @else







                                 <a href="{{route('agentsModule.enable',$user->id)}}" class="disable_location" ids="{{$user->id}}"><i class="icon-sm mr-2" data-feather="lock"></i></a>



   







                                 @endif



                        



                        



                        </td> 



           







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



