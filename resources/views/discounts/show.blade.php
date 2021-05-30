@extends('layouts.master')
@php
    $i = 1;
@endphp
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <h3 class="my-2">List User Take a Coupon <span class="text-success">{{$discount->name}}</span></h3>
            @if (count($paids) > 0)
            <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Take By</th>
                    <th scope="col">Take Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Orders</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paids  as $paid)
                <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$paid->user->name}}</td>
                    <td>{{$paid->created_at->diffForHumans()}}</td>
                    <td class="font-weight-bold @if ($paid->status == 'decline')
                        text-danger
                    @elseif ($paid->status == 'waiting')
                        text-primary
                    @else
                        text-success
                    @endif">{{$paid->status}}</td>
                    <td>{{count(json_decode($paid->orders))}}</td>
                    <td>{{$paid->price}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <div class="d-flex">
            {!! $paids->links() !!}
            </div>
            @else
            <div class="alert alert-danger col" role="alert">
                Sorry This Coupon Does Not Have Orders!!
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
