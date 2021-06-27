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
                <h6 class="card-title">Add Bank</h6>
                <form class="forms-sample" action="{{route('coreModule.administrativeSettings.createbank')}}" method="post">
                {{ csrf_field() }}

                    <div class="row">

                    	 <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name"  name="name" placeholder="Bank Name"   autocomplete="off" required>
                            </div>
                        </div><!-- Col -->
                                            
                       

                       
                    </div><!-- Row -->


                    
                 <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.banks')}}"> <span class="">Back</span></a>
                    <button type="submit" class="btn btn-primary mr-2">Create</button>

                </form>
              </div>
            </div>
                    </div>
                
                </div>
			</div>
			@endsection
