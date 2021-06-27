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
                                <label class="control-label">Select Date</label>
                             <input type="date" value="{{old('login_date')}}" name="login_date" class="form-control mb-4 mb-md-0" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy/mm/dd" im-insert="false">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="location">&nbsp;</label>
                                   <button class="btn btn-success">Submit</button>
                            </div>
                        </div>
                            <div class="col-sm-2">
                            <div class="form-group">
                                <label for="location">&nbsp;</label>
                                   <a href="{{route('reportsModule.dailydeliveryreport')}}" class="btn btn-success">Reset</a>
                            </div>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
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
                  <h6 class="card-title mb-0"><u>Daily Delivery Report</u></h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0">Agent Name</th>
                        <th class="pt-0">Fathers Name</th>
                        <th class="pt-0">Date</th>
                        <th class="pt-0">Action</th>
                    </thead>
                    <tbody>

                      @foreach($dailyreports as $dailyreport)
                      <tr>
                        <td>{{$dailyreport->userDetail->first_name}} {{$dailyreport->userDetail->last_name}} ({{$dailyreport->userDetail->id}})</td>
                        <td>{{$dailyreport->userDetail->fathers_name}}</td>
                        <td>{{$dailyreport->login_date}}</td>
                        </td>
                        <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$dailyreport->user_id}}">View Delivery Detail</button>
 <div class="modal fade" id="exampleModal{{$dailyreport->user_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delivery Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
         <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0"> </th>
                        <th class="pt-0">Login Date/Time</th>
                        <th class="pt-0">Logout Date/Time</th>
                         <th class="pt-0">LoggedIn Time</th>
                        <th class="pt-0">Collected Package</th>
                        <th class="pt-0">Delivered Package</th>
                        <th class="pt-0">C-Returned Package</th>
                        <th class="pt-0">C-Returned Collected</th>
                        <th class="pt-0">Warehouse</th>
                        <th class="pt-0">Supervisor Name</th>
                      </tr>
                    </thead>
                    <tbody>
        <?php 
         $sumofcollpackage = 0;
         $sumofdelpackage = 0;
         $sumofcreturn = 0;
         $sumofcreturncoll = 0;
         $i=1;
        foreach($dailyreport['dailyreportdetail'] as $dailyrepo){ 
                    $sumofcollpackage += $dailyrepo->collected_package;
                    $sumofdelpackage += $dailyrepo->delivered_package;
                    $sumofcreturn += $dailyrepo->c_returned_package;
                    $sumofcreturncoll += $dailyrepo->c_returned_package_collected;
         ?>

          <tr>
            <td>Trip {{$i}}</td>
            <td>{{$dailyrepo->login_date}} {{$dailyrepo->login_time}}</td>
            <td>{{$dailyrepo->logout_date}} {{$dailyrepo->logout_time}}</td>
            <td><?php 
            $timediff = strtotime($dailyrepo->logout_date.' '.$dailyrepo->logout_time) - strtotime($dailyrepo->login_date.' '.$dailyrepo->login_time);
            echo date('H:i',$timediff);
            ?></td>
            <td>{{$dailyrepo->collected_package}}</td>
            <td>{{$dailyrepo->delivered_package}}</td>
            <td>{{$dailyrepo->c_returned_package}}</td>
            <td>{{$dailyrepo->c_returned_package_collected}}</td>
            <td>{{$dailyrepo->warehouseDetail->name}}</td>
            <td>{{@$dailyrepo->supervisorDetail->first_name}} {{@$dailyrepo->supervisorDetail->last_name}}</td>
          </tr>
        <?php $i++; } ?>
         <tr>
            <td></td>
            <td><strong>Total</strong></td>
             <td><strong></strong></td>
            <td><strong>{{$sumofcollpackage}}</strong></td>
            <td><strong>{{$sumofdelpackage}}</strong></td>
            <td><strong>{{$sumofcreturn}}</strong></td>
            <td><strong>{{$sumofcreturncoll}}</strong></td>
            <td></td>
            <td></td>
          </tr>
      </tbody> </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Close</button>
      </div>
    </div>
  </div>
</div>
                        </td> 
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="pagination">
                        <?php echo $dailyreports->render();?>
                    </div>
                </div>
              </div> 
            </div>
          </div>
</div>



























@endsection



