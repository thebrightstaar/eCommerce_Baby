@extends('layouts.app')
@php
    $i = 1;
    $sumPrice = 0;
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{{$user->name}}</h2>
            </div>
            <div class="col-12">
                <img src="{{URL::asset($paid->image)}}"/>
            </div>
            <div class="col-12">
            <p class="h2 my-3">Orders</p>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$order->id}}</td>
                        <td>{{$order->product->title}}</td>
                        <td>{{$order->status}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        @php
                            $sumPrice += $order->price;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5"></td>
                        <td class="table-primary">Total Price:
                            <span class="font-weight-bold" @if ($paid->discount_id) style="text-decoration: line-through" @endif>{{$sumPrice}}</span>
                            @if ($paid->discount_id) <span>{{$paid->price}}</span> @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($paid->status === 'waiting')
            <a href="{{route('paids.accept', ['id' => $paid->id])}}" class="btn btn-success font-weight-bold">Accept Orders</a>
            <a href="{{route('paids.decline', ['id' => $paid->id])}}" class="btn btn-danger font-weight-bold">Reject Orders</a>
            @endif
        </div>

        </div>
    </div>
@endsection
