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
                <h6 class="card-title">Add Warehouse</h6>
                <form class="forms-sample" action="{{route('coreModule.administrativeSettings.createwarehouse')}}" method="post">
                {{ csrf_field() }}

                    <div class="row">

                    	 <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Warehouse Name</label>
                                <input type="text" class="form-control" id="warehouse_name"  name="name" placeholder="Warehouse Name"   autocomplete="off" required>
                            </div>
                        </div><!-- Col -->
                                            
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Warehouse Address</label>
                                <input type="text" class="form-control" id="address"  name="address" placeholder="Warehouse Address"   autocomplete="off" required>
                            </div>
                        </div><!-- Col -->
                                           

                        <div class="col-sm-4">
                           <div class="form-group">
										<label>State</label>
										<div class="input-group col-xs-12">
                       <select class="js-example-basic-single" name="state_id" id="state">
                        <?php foreach($states as $state) { ?>
                        <option value="{{$state->id}}">{{$state->name}}</option>
                       <?php } ?>
                      
                     </select>

												</div>
									</div>
                        </div><!-- Col -->
                    </div><!-- Row -->


                    <div class="row">
                        <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exampleInputPassword1">City</label>
                       
                         
                         <select class="js-example-basic-single" name="city_id" id="city">
                        <?php foreach($cities as $city) { ?>
                        <option value="{{$city->id}}">{{$city->name}}</option>
                       <?php } ?>
                     </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Zipcode</label>
                        <input type="text" class="form-control" id="zipcode"  name="zipcode" placeholder="Zipcode" onkeypress="return isNumberKey(event)"  autocomplete="off" required>
                    </div>
                </div>

			
                </div>
                 <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.warehouses')}}"> <span class="">Back</span></a>
                    <button type="submit" class="btn btn-primary mr-2">Create</button>

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

jQuery(document).ready(function () {
    jQuery('#state').on('change',function(){
    var stateID = jQuery(this).val();    
    if(stateID){
        jQuery.ajax({
           type:"GET",
           url:"{{url('/get-cities')}}?state_id="+stateID,
           success:function(res){               
            if(res){
                jQuery("#city").empty();
                jQuery.each(res,function(key,value){
                    jQuery("#city").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               jQuery("#city").empty();
            }
           }
        });
    }else{
        jQuery("#city").empty();
    }
        
   });
      });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

