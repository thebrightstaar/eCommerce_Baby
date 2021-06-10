@extends('layouts.master')
@php
    $i = 1;
@endphp
@section('content')
    <div class="container">
        <div class="row">
            @if (session('status'))
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
            </div>
            </div>
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-between">
                <h2 class="mb-0">Payments Method</h2>
                <a class="btn btn-primary" href="{{route('payments.create')}}" role="button">Create Payment</a>
            </div>
        </div>
        @if ($payments->count() > 0)
        <div class="row justify-content-center">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Payment Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Account Name</th>
                            <th scope="col">Account Number</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments  as $payment)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$payment->title}}</td>
                            <td>{{$payment->address}}</td>
                            <td>{{$payment->name}}</td>
                            <td>{{$payment->number}}</td>
                            <td>
                                <img src="{{URL::asset($payment->logo)}}" alt="{{$payment->title}}">
                            </td>
                            <td>
                                <a href="{{route('payments.destroy', $payment->id)}}" class="text-danger"><i class="fas fa-trash-alt fa-lg"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div class="alert alert-danger col" role="alert">
                You do not have methods for payments!!
            </div>
        @endif
    </div>
@endsection
