@extends('layouts.app')



@section('content')
<div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <!-- <h4 class="mb-3 mb-md-0">Roles page.</h4> -->
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
                  <h6 class="card-title mb-0">Delivery Type</h6>
              
                  <div class="dropdown mb-2">
                   
                    <a class="btn btn-success" href="{{route('coreModule.administrativeSettings.addbank')}}"> <span class="">Add New Bank</span></a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0">Bank ID</th>
                        <th class="pt-0">Bank Name</th>
                        <th class="pt-0">Action</th>
                        
                    </thead>
                    <tbody>
                    @foreach($banks as $bank)
                      <tr>
                      
                        <td><span class="badge badge-danger">{{$bank->id}}</span></td>
                        <td>{{$bank->name}}</td>
                        <td><a href="{{URL::to('/')}}/coreModule/editbank/{{$bank->id}}"><i data-feather="edit-3" class="icon-sm mr-2"></i></a> | <a href="{{route('coreModule.administrativeSettings.deletebank',$bank->id)}}" onclick="if (!confirm('Are you sure to delete this record?')) { return false }"><i data-feather="trash" class="icon-sm mr-2"></i></i></a></td> 
                        
                         

                      </tr>
                    @endforeach
                    </tbody>
                  </table>

                  <div class="pagination">
                  <?php //echo $category->render(); ?>

                    </div>

                </div>
              </div> 
            </div>
          </div>

</div>
@endsection
