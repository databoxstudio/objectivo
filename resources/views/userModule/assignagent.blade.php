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
                                <h6 class="card-title">Agent to Supervisor Mapping</h6>
                                    <form class="forms-sample" action="{{route('usersModule.assignagentaction')}}" method="post">
                {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Supervisor</label>

                                                    <select name="supervisor_id">
                                                        @foreach($supervisors as $supervisor)
                                                        <option value="{{$supervisor->id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                                                        @endforeach    
                                                    </select>


                                                  
                                                </div>
                                            </div><!-- Col -->
                                             <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Agent</label>
                                                   <select name="agent_id">
                                                          @foreach($agents as $agent)
                                                        <option value="{{$agent->id}}">{{$agent->first_name}} {{$agent->last_name}}</option>
                                                        @endforeach 

                                                    </select>
                                                </div>
                                            </div><!-- Col -->
                                         
                                      
                                       

                                    
                                     <button type="submit" class="btn btn-primary mr-2">Assign Agent to Supervisor</button>
                                       </form>
                            </div>
                        </div>
                    </div>
                </div>



</div>
@endsection
