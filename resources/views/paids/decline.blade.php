@extends('layouts.master')
@php
    $i = 1;
@endphp
@section('content')
<div class="container">
    <div class="row">
        <h4 class="col-12 py-2">Orders Declined</h4>
        @if (count($paids) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Orders</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paids as $paid)
                <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$paid->user->name}}</td>
                    <td>{{$paid->user->email}}</td>
                    <td>{{$paid->address}}</td>
                    <td>{{count(json_decode($paid->orders))}}</td>
                    <td>{{$paid->price}}</td>
                    <td class="text-danger font-weight-bold">{{$paid->status}}</td>
                    <td>
                        <a href="{{route('paids.show', $paid->id)}}" class="btn btn-success"><i class="fas fa-eye fa-lg"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $paids->links() !!}
        </div>
        @else
        <div class="alert alert-danger col" role="alert">
            Sorry you do not have orders for delivering
        </div>
        @endif
    </div>
</div>
@endsection
