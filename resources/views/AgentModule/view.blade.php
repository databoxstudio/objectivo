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

                                <h6 class="card-title">Agent Detail</h6>

                                    <form class="forms-sample" action="{{route('agentsModule.save')}}" method="post">

                {{ csrf_field() }}

                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Agent First Name</label>

                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{$users->first_name}}" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Agent Last Name</label>

                                                    <input type="text" class="form-control" value="{{$users->last_name}}" name="last_name" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Father's Name</label>

                                                    <input type="text" class="form-control" value="{{$users->fathers_name}}" name="fathers_name" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->

                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Date of Birth</label>

                                                    <input type="text" class="form-control" value="{{$users->dob}}"  name="dob" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Blood Group</label>

                                                    <input type="text" class="form-control" value="{{$users->blood_group}}"  name="blood_group" disabled="disabled">

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

                                                   <input type="text" class="form-control" value="{{$users->local_address_line_1}}"  name="local_address_line_1" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 2</label>

                                                    <input type="text" class="form-control" value="{{$users->local_address_line_2}}"  name="local_address_line_2" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">State</label>

                                                     <input type="text" class="form-control" value="{{$users->localState->name}}"  name="local_address_state" disabled="disabled">



                                                    

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">City</label>

                                                    <input type="text" class="form-control" value="{{$users->localCity->name}}"  name="local_address_city" disabled="disabled">



                                                   

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Pincode</label>

                                                    <input type="text" class="form-control" value="{{$users->local_address_pincode}}"  name="local_address_pincode" disabled="disabled">

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

                                                   <input type="text" class="form-control" value="{{$users->permanent_address_line_1}}"  name="permanent_address_line_1" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Address Line 2</label>

                                                    <input type="text" class="form-control" value="{{$users->permanent_address_line_2}}"  name="permanent_address_line_2" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">State</label>

                                                    <input type="text" class="form-control" value="{{$users->permanentState->name}}"  name="permanent_address_state" disabled="disabled">



                                                    

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">City</label>

                                                     <input type="text" class="form-control" value="{{$users->permanentCity->name}}"  name="local_address_city" disabled="disabled">



                                                     

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Pincode</label>

                                                    <input type="text" class="form-control" value="{{$users->permanent_address_pincode}}" name="permanent_address_pincode" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->

                                    



                                        <div class="row">

                                            <h6 class="card-title">AADHAR DETAIL</h6>

                                                </div>

                                         <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Aadhar Number</label>

                                                    <input type="email" class="form-control" value="{{$users->aadhar_number}}" name="aadhar_number" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Name on Aadhar Card</label>

                                                    <input type="text" class="form-control" value="{{$users->name_on_aadhar_card}}"  name="name_on_aadhar_card" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Aadhar Card front pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->aadhar_front_snap}}"><a href="http://objectivo.in/public{{$users->aadhar_front_snap}}" target="_blank">Download</a>

                                                    <!--<input type="text" class="form-control" value="{{$users->aadhar_front_snap}}" name="aadhar_front_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Aadhar Card Back pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->aadhar_back_snap}}"><a href="http://objectivo.in/public{{$users->aadhar_back_snap}}" target="_blank">Download</a>

                                                   <!-- <input type="text" class="form-control" value="{{$users->aadhar_back_snap}}"  name="aadhar_back_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->





                                         <div class="row">

                                            <h6 class="card-title">DRIVING LICENCE DETAIL</h6>

                                                </div>

                                             <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Number</label>

                                                    <input type="text" class="form-control" value="{{$users->driving_licence_number}}"  name="driving_licence_number" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Name As on DL</label>

                                                    <input type="text" class="form-control" value="{{$users->name_as_on_dl}}"  name="name_as_on_dl" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DOB as on DL</label>

                                                    <input type="text" class="form-control" value="{{$users->dob_dl}}"  name="dob_dl" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                        </div>

                                       <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Issue Date</label>

                                                    <input type="text" class="form-control" value="{{$users->dl_issue_date}}" name="dl_issue_date" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Expiry Date</label>

                                                    <input type="text" class="form-control" value="{{$users->dl_expiry_date}}"  name="dl_expiry_date" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                               <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Issued State</label>

                                                     

                                                    <input type="text" class="form-control" value="{{$users->dl_expiry_date}}"  name="dl_expiry_date" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                           

                                        </div><!-- Row -->

                                         <div class="row">

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Front Pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->dl_front_snap}}"><a href="http://objectivo.in/public{{$users->dl_front_snap}}" target="_blank">Download</a>

                                                    <!--<input type="text" class="form-control" value="{{$users->dl_front_snap}}"   name="dl_front_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">DL Back Pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->dl_back_snap}}"><a href="http://objectivo.in/public{{$users->dl_back_snap}}" target="_blank">Download</a>





                                                   <!--  <input type="text" class="form-control" value="{{$users->dl_back_snap}}"   name="dl_back_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                            

                                        </div><!-- Row -->







                                            <div class="row">

                                            <h6 class="card-title">PAN CARD DETAIL</h6>

                                                </div>

                                         <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">PAN Number</label>

                                                    <input type="text" class="form-control" value="{{$users->pan_number}}"  name="pan_number" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Name as on PAN</label>

                                                    <input type="text" class="form-control" value="{{$users->name_as_on_pancard}}"  name="name_as_on_pancard" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                              <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">PAN Front Pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->pan_front_snap}}"><a href="http://objectivo.in/public{{$users->pan_front_snap}}" target="_blank">Download</a>



                                                    <!--<input type="text" class="form-control" value="{{$users->pan_front_snap}}"  name="pan_front_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                              <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">PAN Back Pic</label>

                                                    <img style="height:90px;" src="http://objectivo.in/public{{$users->pan_back_snap}}"><a href="http://objectivo.in/public{{$users->pan_back_snap}}" target="_blank">Download</a>



                                                  <!-- <input type="text" class="form-control" value="{{$users->pan_back_snap}}"  name="pan_back_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->





                                            <div class="row">

                                            <h6 class="card-title">BANK ACCOUNT DETAIL</h6>

                                                </div>

                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Bank Account Number</label>

                                                    <input type="text" class="form-control" value="{{$users->bank_ac_number}}" name="bank_ac_number" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">A/C Holder Name</label>

                                                    <input type="text" class="form-control" value="{{$users->account_holder_name}}"  name="account_holder_name" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                              <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Bank Name</label>

                                                    <input type="text" class="form-control" value="{{$users->bankName->name}}"  name="bank_name" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                        </div>

                                        <div class="row">

                                              <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Bank Branck</label>

                                                    <input type="text" class="form-control" value="{{$users->branch_name}}"  name="branch_name" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">IFSC Code</label>

                                                    <input type="text" class="form-control" value="{{$users->ifsc_code}}"  name="ifsc_code" disabled="disabled">

                                                </div>

                                            </div><!-- Col -->

                                             <div class="col-sm-4">

                                                <div class="form-group">

                                                    <label class="control-label">Cancel Cheque Pic</label>



                                                     <img style="height:90px;" src="http://objectivo.in/public{{$users->cancel_cheque_snap}}"><a href="http://objectivo.in/public{{$users->cancel_cheque_snap}}" target="_blank">Download</a>



                                                  <!-- <input type="text" class="form-control" value="{{$users->cancel_cheque_snap}}"  name="cancel_cheque_snap" disabled="disabled">-->

                                                </div>

                                            </div><!-- Col -->

                                        </div><!-- Row -->





                                       



                                 

                                       </form>

                            </div>

                        </div>

                    </div>

                </div>







</div>

@endsection

