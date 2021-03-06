@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-center mt-2">
            <h3 class="mt-4 mb-2 font-weight-bold text-warning col">Create Method Payment</h3>
            <form action="{{route('payments.store')}}" method="POST" class="col-md-12" enctype="multipart/form-data">
                @csrf
            <div class="form-group">
                <label for="title">Title Payment</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title" name="title">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address" name="address">
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Name Account</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Optional" name="name">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="number">Number</label>
                <input type="number" class="form-control @error('number') is-invalid @enderror" id="number" placeholder="Number" name="number">
                @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="logo">Logo Payment</label>
                <input type="file" class="form-control-file @error('logo') is-invalid @enderror" id="logo" name="logo" style="opacity: 1; position: relative">
                @error('logo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Payment</button>
            </div>
            </form>
        </div>
    </div>

@endsection
