@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-6">All Payments Method</h1>
            <a class="btn btn-primary" href="{{route('payments.create')}}" role="button">Create Payment</a>
        </div>
        <div class="row">
            @if (session('status'))
            <div class="col-md-8">
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
        @if ($payments->count() > 0)
        <div class="row justify-content-center">
            <ul class="list-unstyled col-md-8 col">
                @foreach ($payments as $item)
                {{-- <a href="{{route('payments.show', $item->id)}}" role="button"> --}}
                <li class="media w-100 shadow p-3 mb-4 bg-white rounded">
                    <img src="{{URL::asset($item->logo)}}" class="mr-3 rounded-circle" alt="{{$item->title}}">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">{{$item->title}}</h5>
                        <p>Number: {{$item->number}}</p>
                    </div>
                </li>
                </a>
                @endforeach
            </ul>
        </div>
        @else
            <div class="alert alert-danger" role="alert">
                You do not have method for payments
            </div>
        @endif
    </div>
@endsection
