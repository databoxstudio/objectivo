@extends('layouts.app')



@section('content')
<div class="page-content">
@if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                 @endif
<div class="row">

                    <div class="col-md-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                            
                                <h6 class="card-title">Create Doctor Profile</h6>
                                @foreach($emailSetting as $settings)
                                @if($settings->function_id == 'Doctor Profile')
                               
                                    <form class="forms-sample" action="{{route('coreModule.administrativeSettings.updateemailmanagement')}}" method="post">
                                          {{ csrf_field() }}
                                          <input type="hidden" class="form-control" id="id"  name="id" autocomplete="off"  value="{{$settings->id}}">

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Function ID</label>
                                                    <input type="text" class="form-control" id="function_id"  name="function_id" autocomplete="off" placeholder="Function ID" value="{{$settings->function_id}}" disabled>
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email Subject</label>
                                                    <input type="text" class="form-control" id="email_subject"  name="email_subject" autocomplete="off" placeholder="Email Subject" value="{{$settings->email_subject}}">
                                                </div>
                                            </div><!-- Col -->
                                             <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email To</label>
                                                    <input type="text" class="form-control" id="email_to"  name="email_to" autocomplete="off" placeholder="Email To" value="{{$settings->email_to}}">
                                                </div>
                                            </div><!-- Col -->
                                           
                                        </div><!-- Row -->

                                        <div class="row">
                                           
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email CC</label>
                                                    <input type="text" class="form-control" id="email_cc"  name="email_cc" autocomplete="off" placeholder="Email CC" value="{{$settings->email_cc}}">
                                                </div>
                                            </div><!-- Col -->
                                             <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label class="control-label">Email Body</label>
                                                    <textarea class="form-control" name="tinymce" id="simpleMde1" rows="4">{{$settings->email_cc}}</textarea>
                                                </div>
                                            </div><!-- Col -->
                                           
                                        </div><!-- Row -->


                                         <button class="btn btn-light">Back</button>
                                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                                 </form>
                                 @endif
                                 @endforeach
                            </div>
                        </div>
                    </div>
                </div>

<br>
                <!-- Second form -->
                <div class="row">

                    <div class="col-md-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                            
                                <h6 class="card-title">Create Patient Profile</h6>
                                @foreach($emailSetting as $settings)
                                @if($settings->function_id == 'Patient Profile')
                               
                                    <form class="forms-sample" action="{{route('coreModule.administrativeSettings.updateemailmanagement')}}" method="post">
                                          {{ csrf_field() }}
                                          <input type="hidden" class="form-control" id="id"  name="id" autocomplete="off"  value="{{$settings->id}}">

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Function ID</label>
                                                    <input type="text" class="form-control" id="function_id"  name="function_id" autocomplete="off" placeholder="Function ID" value="{{$settings->function_id}}" disabled>
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email Subject</label>
                                                    <input type="text" class="form-control" id="email_subject"  name="email_subject" autocomplete="off" placeholder="Email Subject" value="{{$settings->email_subject}}">
                                                </div>
                                            </div><!-- Col -->
                                             <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email To</label>
                                                    <input type="text" class="form-control" id="email_to"  name="email_to" autocomplete="off" placeholder="Email To" value="{{$settings->email_to}}">
                                                </div>
                                            </div><!-- Col -->
                                           
                                        </div><!-- Row -->

                                        <div class="row">
                                           
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Email CC</label>
                                                    <input type="text" class="form-control" id="email_cc"  name="email_cc" autocomplete="off" placeholder="Email CC" value="{{$settings->email_cc}}">
                                                </div>
                                            </div><!-- Col -->
                                             <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label class="control-label">Email Body</label>
                                                    <textarea class="form-control" name="tinymce" id="simpleMde2" rows="4">{{$settings->email_cc}}</textarea>
                                                </div>
                                            </div><!-- Col -->
                                           
                                        </div><!-- Row -->


                                         <button class="btn btn-light">Back</button>
                                     <button type="submit" class="btn btn-primary mr-2">Save</button>
                                 </form>
                                 @endif
                                 @endforeach
                            </div>
                        </div>
                    </div>
                </div>
<br>
                <!-- End Second form -->
</div>
@endsection
