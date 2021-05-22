@extends('layouts.master')



@section('title')
      Registered users
@endsection




@section('content')


<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Registered users </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th> ID </th>
                <th> Name </th>
                <th> Email </th>
              </thead>
              <tbody>
                  @foreach ($users as $item)
                <tr>
                  <td> {{$item->id}} </td>
                  <td> {{$item->name}} </td>
                  <td> {{$item->email}}  </td>
                  <td >
                      <a href="/edit_users/{{$item->id}} " class="btn btn-success"> message </a>
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

@endsection
