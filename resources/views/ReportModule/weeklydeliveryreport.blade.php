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
                            	 <label for="from">Devlivery Agent</label>
                            	 <select name="agent" class="js-example-basic-single w-100">
                            	 <option value="">Select Devlivery Agent</option>

                            	
                               @foreach($agents as $agent)
                                          <option value="{{@$agent->id}}" <?php if(@$agent->id==@$_REQUEST['agent']) { echo "selected=selected"; } ?> >{{@$agent->first_name}} {{@$agent->last_name}}</option>
                                                        @endforeach

                             </select>
                            </div>
                        </div>




                        <div class="col-sm-3">
                            <div class="form-group">
                               <label for="from">From Date</label>
                                <input type="text" autocomplete="off" readonly name="from_date" id="from_date" value="<?php echo @$_REQUEST['from_date']; ?>" class="form-control" placeholder="From Date" required />
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                               <label for="from">To Date</label>
                         	<input type="text" autocomplete="off" readonly name="to_date" id="to_date" value="<?php echo @$_REQUEST['to_date']; ?>" class="form-control" placeholder="To Date"/>
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
                                   <a href="{{route('reportsModule.weeklydeliveryreport')}}" class="btn btn-success">Reset</a>
                            </div>
                        </div>


                         <div class="col-sm-2">
                            <div class="form-group">
                                <label for="location">&nbsp;</label>
                        <span data-href="{{route('reportsModule.exportweeklyReport')}}" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Export</span>
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

        @if(!empty($dadetail))

        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
              <div class="card-body">
              	 <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0"><u>Delivery Agent Detail</u></h6>
                </div>

                
                 <div class="row">
                    	<div class="col-sm-3">
                            <div class="form-group">
                            	 <label for="from">Delivery Agent</label>
                            	
                              {{@$dadetail->first_name}} {{@$dadetail->last_name}} ({{@$dadetail->id}})
                            </div>
                        </div>
                       
                        <div class="col-sm-3">
                            <div class="form-group">
                            	 <label for="from">DOB</label>
                            	
                              {{@$dadetail->dob}}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            	 <label for="from">Local Address</label>
                            	
                               {{@$dadetail->local_address_line_1}} {{@$dadetail->local_address_line_2}} {{@$dadetail->localCity->name}} <br/>
                               {{@$dadetail->localState->name}} {{@$dadetail->local_address_pincode}}
                            </div>
                        </div>
					</div>
              </div>
            </div>
        </div>
         <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
          </div>
        </div>
        @endif





  


        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
              <div class="card-body">
              @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0"><u>Weekly Delivery Report</u></h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                      	    <th class="pt-0">Warehouse</th>
                        <th class="pt-0">Sup. Name</th>
                        <th class="pt-0">Date</th>
                        <th class="pt-0">Login/Logout Time</th>
                        <th class="pt-0">Coll. Package</th>
                        <th class="pt-0">Del. Package</th>
                        <th class="pt-0">Pac. Returned</th>
                        <th class="pt-0">C-Ret. Package</th>
                        <th class="pt-0">C-Ret. Collected</th>
                    
                      </tr>
                    </thead>
					<tbody>
                      <?php 
                      $totalcollectpac = 0; 
                      $totaldelpac = 0;
                      $totalpacreturn =0;
                      $totalcretuned = 0;
                      $totalcreturendcollected = 0;
                      foreach($weeklyreports as $weeklyreport) {

                      $totalcollectpac = $totalcollectpac + $weeklyreport->collected_package;
                      $totaldelpac = $totaldelpac + $weeklyreport->delivered_package;
                      $totalpacreturn += $weeklyreport->collected_package - $weeklyreport->delivered_package;

                      $totalcretuned = $totalcretuned + $weeklyreport->c_returned_package;
                      $totalcreturendcollected = $totalcreturendcollected + $weeklyreport->c_returned_package_collected;

                      ?>
                      <tr>
                      	    <td><?php echo $weeklyreport->warehouseDetail->name; ?></td>
              							<td><?php echo $weeklyreport->supervisorDetail->first_name.' '. $weeklyreport->supervisorDetail->last_name; ?></td>
              							<td><?php echo $weeklyreport->login_date; ?> </td>
              							<td><?php echo $weeklyreport->login_time; ?>/ <?php echo $weeklyreport->logout_time; ?></td>
              							<td><?php echo $weeklyreport->collected_package; ?></td>
              							<td><?php echo $weeklyreport->delivered_package; ?></td>
              							<td><?php echo $weeklyreport->collected_package - $weeklyreport->delivered_package; ?></td>
              							<td><?php echo $weeklyreport->c_returned_package; ?></td>
              							<td><?php echo $weeklyreport->c_returned_package_collected; ?></td>
                      </tr>
                     <?php } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</td>
                            <td><strong><?php echo $totalcollectpac;?></strong></td>
                            <td><strong><?php echo $totaldelpac;?></strong></td>
                            <td><strong><?php echo $totalpacreturn;?></strong></td>
                            <td><strong><?php echo $totalcretuned;?></strong></td>
                            <td><strong><?php echo $totalcreturendcollected;?></strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="pagination">
                        <?php // echo $weeklyreport->render();?>
                    </div>
                </div>
              </div> 
            </div>
          </div>
</div>



    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
        $( function() {
            var dateFormat = "yy/mm/dd",
                from = $( "#from_date" )
                    .datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 1,
                        //minDate: 0,
                        beforeShowDay: function(date) {
                            return [date.getDay() == 1];
                          
                        },
                        onSelect: function (date) {
                            var date3 = $('#from_date').datepicker('getDate');
                            date3.setDate(date3.getDate() + 6);
                            //$('#to_date').datepicker('setDate', date3);
                            $('#to_date').val((date3.getMonth() + 1) + '/' + date3.getDate() + '/' +  date3.getFullYear());
                        }
                    })
                    .on( "change", function() {
                        to.datepicker( "option", "minDate", getDate( this ) );
                    });

            	function getDate( element ) {
                var date;
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }
                return date;
            }
        } );





   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }

    </script>









@endsection



