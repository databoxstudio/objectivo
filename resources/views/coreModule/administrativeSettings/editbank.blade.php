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
                <h6 class="card-title">Update Department/Category</h6>
                <form class="forms-sample" action="{{route('coreModule.administrativeSettings.updatebank')}}" method="post">
                {{ csrf_field() }}

                    <div class="row">
                    <input type="hidden" class="form-control" id="bank_id" name="bank_id" value="{{$banks->id}}" >

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Bank Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Bank Name" value="{{$banks->name}}">
                                                </div>
                                            </div>

                                           

                                           
                                            
                                        </div><!-- Row -->



               
                 <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.banks')}}"> <span class="">Back</span></a>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>

                </form>
              </div>
            </div>
                    </div>
                
                </div>
</div>
@endsection
