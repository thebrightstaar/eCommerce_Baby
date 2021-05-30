@extends('layouts.master')

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
        <h3 class="col-12 text-primary mt-5 font-weight-bold mb-2">About Us</h3>
        @if ($about)
        <div class="col-md-12">
            <h5 class="font-weight-bold">Description:</h5>
            <p>{{$about->description}}</p>
            <p>{!!$about->facebook ? '<span class="font-weight-bold">Facebook: </span>' . $about->facebook : NULL!!}</p>
            <p>{!!$about->instagram ? '<span class="font-weight-bold">Instagram:</span> ' . $about->instagram : NULL!!}</p>
            <p>{!!$about->email ? '<span class="font-weight-bold">Email: </span>' . $about->email : NULL!!}</p>
            <p>{!!$about->address ? '<span class="font-weight-bold">Address: </span>' . $about->address : NULL!!}</p>
            <p>{!!$about->whatsapp ? '<span class="font-weight-bold">WhatsApp Number: </span>' . $about->whatsapp : NULL!!}</p>
            <a href="{{route('about.edit', $about->id)}}" class="btn btn-success">Edit About</a>
            <a href="{{route('about.destroy', $about->id)}}" class="btn btn-danger">Delete About</a>
        </div>
        @else
        <div class="col-md-12">
            <form action="{{route('about.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="facebook">Facebook Url</label>
                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" placeholder="Facebook Url [Optional]" name="facebook">
                    @error('facebook')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="instagram">Instagram Url</label>
                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" placeholder="Instagram Url [Optional]" name="instagram">
                    @error('instagram')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address [Optional]" name="address">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="whatsapp">Whatsapp Number</label>
                    <input type="number" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" placeholder="Whatsapp Number [Optional]" name="whatsapp">
                    @error('whatsapp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="About Us" cols="30" rows="10"></textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create About Us</button>
                </div>
            </form>
        </div>
        @endif

    </div>
</div>
@endsection
