@extends('layouts.master')



@section('title')
   Send message for user
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Send message for user</h1>
                 </div>
                 <div class="card-body">
                    <form action="" method="POST">
                         {{ csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="form-group" >
                              <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="text" name="email" value="{{$users->email}}" class="form-control" >
                              </div>
                              <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Please write the messagea</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                              </div>
                        </div>
                        <button type="submit" class="btn btn-success"> send </button>
                        <button type="submit" class="btn btn-danger"> Cancel</button>
                  </form>
                  </div>
              </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection
