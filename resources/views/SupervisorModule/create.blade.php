@extends('layouts.app')







@section('content')

<div class="page-content">



<div class="row">

                    <div class="col-md-12 stretch-card">

                        <div class="card">

                            <div class="card-body">



                                      @if (count($errors) > 0)

         <div class = "alert alert-danger">

            <ul>

               @foreach ($errors->all() as $error)

                  <li>{{ $error }}</li>

               @endforeach

            </ul>

         </div>

      @endif



                                @if(session()->has('message'))

                <div class="alert alert-success">

                    {{ session()->get('message') }}

                </div>

                @endif

                                <h6 class="card-title">Add Supervisor</h6>

                                    <form class="forms-sample" action="{{route('supervisorsModule.save')}}" method="post">

                {{ csrf_field() }}



                                         <div class="row">

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Supervisor's Warehouse</label>

                                                    <select class="form-control" id="warehouse_id" name="warehouse_id">

                                                        <option value="">Select Warehouse</option>

                                                        @foreach($warehouses as $warehouse)
                                                        @if (old('warehouse_id') == $warehouse->id)
                                                            <option value="{{$warehouse->id}}" selected="selected">{{$warehouse->name}}</option>
                                                            @else
                                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                            @endif



                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4"



                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Supervisor Contact Number</label>

                                                    <input type="text" value="{{old('phone_number')}}" class="form-control" id="phone_number" name="phone_number" autocomplete="off" placeholder="Contact Number" onkeypress="return isNumberKey(event)">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Supervisor Email</label>

                                                    <input type="email" value="{{old('email')}}" class="form-control" id="email" name="email" autocomplete="off" placeholder="Supervisor Email">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Password</label>

                                                    <input type="text" class="form-control id="password" name="password" autocomplete="off" placeholder="Password">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->



                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Supervisor First Name</label>

                                                    <input type="text" value="{{old('first_name')}}" class="form-control" id="first_name" name="first_name" autocomplete="off" placeholder="Supervisor First Name">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Supervisor Last Name</label>

                                                    <input type="text" value="{{old('last_name')}}" class="form-control" id="last_name" name="last_name" autocomplete="off" placeholder="Supervisor Last Name">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Father's Name</label>

                                                    <input type="text" value="{{old('fathers_name')}}" class="form-control id="fathers_name" name="fathers_name" autocomplete="off" placeholder="Father's Name">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->

                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Date of Birth</label>

                                                    <input type="text" value="{{old('dob')}}" class="form-control" id="dob"  name="dob" autocomplete="off" placeholder="Date of Birth">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Blood Group</label>

                                                    <select name="blood_group" class="form-control" id="exampleFormControlSelect1">

                                                       <option selected="" disabled="">Select Blood Group</option>

                                                        <option value="A+">A+</option>

                                                        <option value="B+">B+</option>

                                                        <option value="O+">O+</option>

                                                        <option value="AB+">AB+</option>

                                                        <option value="A-">A-</option>

                                                        <option value="B-">B-</option>

                                                        <option value="O-">O-</option>

                                                        <option value="AB-">AB-</option>

                                                    </select>

                                                </div>

                                            </div><!-- Col -->

                                            

                                        </div><!-- Row -->









                                        <div class="row">

                                            <h6 class="card-title">Local Address</h6>

                                                </div>

                                        <div class="row">



                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 1</label>

                                                   <input type="text" value="{{old('local_address_line_1')}}" class="form-control" id="local_address_line_1"  name="local_address_line_1" autocomplete="off" placeholder="Address Line 1">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 2</label>

                                                    <input type="text" value="{{old('local_address_line_2')}}" class="form-control" id="local_address_line_2"  name="local_address_line_2" autocomplete="off" placeholder="Address Line 2">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">State</label>

                                                   

                                                      <select class="form-control" name="local_address_state" id="exampleFormControlSelect1">

                                                    <option selected="" disabled="">Select State</option>

                                                

                                                        @foreach($states as $state)
                                                        @if (old('local_address_state') == $state->id)
                                                            <option value="{{$state->id}}" selected="selected">{{$state->name}}</option>
                                                            @else 
                                                            <option value="{{$state->id}}")>{{$state->name}}</option>
                                                            @endif


                                                        @endforeach

                                                </select>

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">City</label>

                                                     <select class="form-control" name="local_address_city" id="exampleFormControlSelect1">

                                                    <option selected="" disabled="">Select City</option>

                                              

                                                        @foreach($cities as $city)
                                                            @if (old('local_address_city') == $city->id)
                                                            <option value="{{$city->id}}" selected="selected">{{$city->name}}</option>
                                                            @else 
                                                            <option value="{{$city->id}}")>{{$city->name}}</option>
                                                            @endif



                                                        @endforeach

                                                </select>

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Pincode</label>

                                                    <input type="text" value="{{old('local_address_pincode')}}" class="form-control" id="local_address_pincode"  name="local_address_pincode" autocomplete="off" placeholder="Pincode" onkeypress="return isNumberKey(event)">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->

                                    



                                        <div class="row">

                                            <h6 class="card-title">Permanent Address</h6>

                                                </div>

                                          <div class="row">

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 1</label>

                                                   <input type="text" value="{{old('permanent_address_line_1')}}" class="form-control" id="permanent_address_line_1"  name="permanent_address_line_1" autocomplete="off" placeholder="Address Line 1">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 2</label>

                                                    <input type="text" value="{{old('permanent_address_line_2')}}" class="form-control" id="permanent_address_line_2"  name="permanent_address_line_2" autocomplete="off" placeholder="Address Line 2">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">State</label>

                                                   

                                                      <select class="form-control" name="permanent_address_state" id="exampleFormControlSelect1">

                                                    <option selected="" disabled="">Select State</option>

                                                   <option>Select State</option>

                                                        @foreach($states as $state)
                                                        @if (old('permanent_address_state') == $state->id)
                                                            <option value="{{$state->id}}" selected="selected">{{$state->name}}</option>
                                                             @else 
                                                            <option value="{{$state->id}}")>{{$state->name}}</option>
                                                            @endif



                                                        @endforeach

                                                </select>

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">City</label>

                                                     <select class="form-control" name="permanent_address_city" id="exampleFormControlSelect1">

                                                    <option selected="" disabled="">Select City</option>

                                               

                                                        @foreach($cities as $city)
                                                         @if (old('permanent_address_city') == $city->id)
                                                            <option value="{{$city->id}}" selected="selected">{{$city->name}}</option>
                                                             @else 
                                                            <option value="{{$city->id}}")>{{$city->name}}</option>
                                                            @endif


                                                        @endforeach

                                                </select>

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Pincode</label>

                                                    <input type="text" value="{{old('permanent_address_pincode')}}" class="form-control" id="permanent_address_pincode"  name="permanent_address_pincode" autocomplete="off" placeholder="Pincode" onkeypress="return isNumberKey(event)">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->

                                    



                                         

                                      

                                       



                                       



                                     <button class="btn btn-light">Back</button>

                                     <button type="submit" class="btn btn-primary mr-2">Create Supservisor</button>

                                       </form>

                            </div>

                        </div>

                    </div>

                </div>







</div>

@endsection





      <script>

      function isNumberKey(evt){

    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}

</script>