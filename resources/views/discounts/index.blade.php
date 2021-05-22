@extends('layouts.app');
@php
    $i = 1;
@endphp
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
        <form class="col border py-3 border-success rounded bg-light" action="{{route('discounts.store')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label>Coupon Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Coupon Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-5">
                    <label>Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Code">
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-2 pt-4">
                    <button type="submit" class="btn btn-success w-100 mt-2">Create Coupon</button>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Limit</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" placeholder="##Limit">
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>Start Date</label>
                    <input type="text" class="form-control @error('started') is-invalid @enderror" name="started" placeholder="Start Date" id="start_date">
                    @error('started')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>End Date</label>
                    <input type="text" class="form-control @error('expired') is-invalid @enderror" name="expired" placeholder="End Date" id="end_date">
                    @error('expired')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>Discount Percentage</label>
                    <input type="number" class="form-control @error('value') is-invalid @enderror" name="value" placeholder="Discount Percentage">
                    @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        @if (count($discounts) > 0)
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Value</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Limit</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts  as $dis)
                <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$dis->name}}</td>
                    <td>{{$dis->code}}</td>
                    <td>{{$dis->value}}</td>
                    <td>{{$dis->started_at}}</td>
                    <td>{{$dis->expired_at}}</td>
                    <td>{{$dis->amount}}</td>
                    <td>{{$dis->status}}</td>
                    <td>
                        <a href="#" class="text-success pr-2"><i class="fas fa-eye fa-lg"></i></a>
                        <a href="{{route('discounts.edit', $dis->id)}}" class="text-primary pr-2"><i class="fas fa-edit fa-lg"></i></a>
                        <a href="{{route('discounts.destroy', $dis->id)}}" class="text-danger"><i class="fas fa-trash-alt fa-lg"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $discounts->links() !!}
        </div>
        @else
            <div class="alert alert-danger col" role="alert">
                Sorry for bothering you do not have coupons!!
            </div>
        @endif
    </div>
</div>


<script>
    const start_date = flatpickr('#start_date');
    const end_date = flatpickr('#end_date');
</script>
@endsection
