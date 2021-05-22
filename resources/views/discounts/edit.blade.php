@extends('layouts.app');

@section('content')
<div class="container">
    <div class="row">
        <form class="col border py-3 border-success rounded bg-light" action="{{route('discounts.update', $discount->id)}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label>Coupon Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Coupon Name" value="{{$discount->name}}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-5">
                    <label>Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Code" value="{{$discount->code}}">
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-2 pt-4">
                    <button type="submit" class="btn btn-success w-100 mt-2">Update Coupon</button>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Limit</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" placeholder="##Limit" value="{{$discount->amount}}">
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>Start Date</label>
                    <input type="text" class="form-control @error('started') is-invalid @enderror" name="started" placeholder="Start Date" id="start_date" value="{{$discount->started_at}}">
                    @error('started')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>End Date</label>
                    <input type="text" class="form-control @error('expired') is-invalid @enderror" name="expired" placeholder="End Date" id="end_date" value="{{$discount->expired_at}}">
                    @error('expired')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label>Discount Percentage</label>
                    <input type="number" class="form-control @error('value') is-invalid @enderror" name="value" placeholder="Discount Percentage" value="{{$discount->value}}">
                    @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const start_date = flatpickr('#start_date');
    const end_date = flatpickr('#end_date');
</script>
@endsection
