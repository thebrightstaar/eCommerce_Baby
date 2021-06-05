@extends('layouts.master')



@section('title')
    Contact Users
@endsection




@section('content')
<div class="container">
    <div class="row">
        @if (session('message'))
        <div class="col">
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        </div>
        @endif
    </div>

    <div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Contact users </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th> ID </th>
                <th> Name </th>
                <th> Email </th>
                <th> Buy it </th>
              </thead>
              <tbody>
                  @foreach ($users as $user)
                <tr>
                  <td> {{$user->id}} </td>
                  <td> {{$user->name}} </td>
                  <td> {{$user->email}}  </td>
                  <td> {{count($user->orders->where('status', 'accept'))}}  </td>
                  <td >
                      <a href="{{route('contact.open',[$user->id])}}" class="btn btn-success"> message </a>
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
</div>
@endsection


@section('scripts')

@endsection
