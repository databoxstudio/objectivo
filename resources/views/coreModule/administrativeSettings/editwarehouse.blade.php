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
                <h6 class="card-title">Update Warehouse</h6>
                <form class="forms-sample" action="{{route('coreModule.administrativeSettings.updatewarehouse')}}" method="post">
                {{ csrf_field() }}

                    <div class="row">
                    <input type="hidden" class="form-control" id="warehouse_id" name="warehouse_id" value="{{$warehouses->id}}" >

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Warehouse Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Warehouse Name" value="{{$warehouses->name}}">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Warehouse Address</label>
                                                    <input type="text" class="form-control" id="warehouse_address"  name="address" placeholder="Warehouse Address"   autocomplete="off" value="{{$warehouses->address}}" >
                                                </div>
                                            </div><!-- Col -->

                                          <div class="col-sm-4">
                           <div class="form-group">
                                        <label>State</label>
                                        <div class="input-group col-xs-12">
                       <select class="js-example-basic-single"  name="state_id" id="employeFilter">
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
                                                    <label for="exampleInputUsername1">City</label>
                                                  

                                                    <select class="js-example-basic-single"  name="city_id" id="employeFilter">
                        <?php foreach($cities as $city) { ?>
                        <option value="{{$city->id}}">{{$city->name}}</option>
                       <?php } ?>
                   </select>


                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Zipcode</label>
                        <input type="text" class="form-control" id="zipcode"  name="zipcode" placeholder="Zipcode" onkeypress="return isNumberKey(event)"  autocomplete="off" value="{{$warehouses->zipcode}}" >
                                                </div>
                                            </div><!-- Col -->

                                       
                                        </div><!-- Row -->
                    



                 <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.warehouses')}}"> <span class="">Back</span></a>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>

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