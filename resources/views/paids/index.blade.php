@extends('layouts.app')
@php
    $i = 1;
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if (session('message'))
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        </div>
                </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            @if (count($paids) > 0)
            <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Orders</th>
                <th scope="col">Coupon</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paids as $paid)
                <tr>
                <th scope="row">{{$i++}}</th>
                <td>{{$paid->name}}</td>
                <td>{{$paid->address}}</td>
                <td>{{count($paid->orders)}}</td>
                <td>@if ($paid->discount)
                    {{$paid->discount->code}}
                @else
                    Nothing
                @endif
                </td>
                <td>{{$paid->price}}</td>
                <td>
                    <a href="{{route('paids.show', $paid->id)}}" class="btn btn-success">Show</a>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            @else
                <div class="alert alert-secondary col" role="alert">
                Sorry you do not have selles!
                </div>
            @endif
        </div>
    </div>
@endsection
