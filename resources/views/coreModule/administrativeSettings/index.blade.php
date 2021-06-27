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
                                <h6 class="card-title">Administrative Settings</h6>
                                    <form class="forms-sample" action="{{route('clientModule.contract.save')}}" method="post">
                {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Contract Name</label>
                                                    <input type="text" class="form-control" id="mobile_number"  name="mobile_number" autocomplete="off" placeholder="Contract Name">
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Contract Start Date</label>
                                                    <input type="text" class="form-control" id="account_manager"  name="account_manager" autocomplete="off" placeholder="Contract Start Date">
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Contract End Date</label>
                                                    <input type="text" class="form-control" id="am_mobile_number"  name="am_mobile_number" autocomplete="off" placeholder="Contract End Date">
                                                </div>
                                            </div><!-- Col -->
                                        </div><!-- Row -->

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Number of Sites</label>
                                                    <input type="text" class="form-control" id="mobile_number"  name="mobile_number" autocomplete="off" placeholder="Number of Sites">
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Primary Contact Person</label>
                                                    <input type="text" class="form-control" id="account_manager"  name="account_manager" autocomplete="off" placeholder="Primary Contact Person">
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Secondry Contact Person</label>
                                                    <input type="text" class="form-control" id="am_mobile_number"  name="am_mobile_number" autocomplete="off" placeholder="Secondry Contact Person">
                                                </div>
                                            </div><!-- Col -->
                                        </div><!-- Row -->


                                         <button class="btn btn-light">Back</button>
                                     <button type="submit" class="btn btn-primary mr-2">Create Contract</button>
                                       </form>
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection
