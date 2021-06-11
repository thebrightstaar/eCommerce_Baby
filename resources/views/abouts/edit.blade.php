@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="col-12 text-success mt-5 font-weight-bold mb-2">Edit About Us</h3>
        <div class="col-md-12">
            <form action="{{route('about.update', $about->id)}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="facebook">Facebook Url</label>
                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" placeholder="Facebook Url [Optional]" name="facebook" value="{{$about->facebook}}">
                    @error('facebook')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="instagram">Instagram Url</label>
                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" placeholder="Instagram Url [Optional]" name="instagram" value="{{$about->instagram}}">
                    @error('instagram')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{$about->email}}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address [Optional]" name="address" value="{{$about->address}}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="whatsapp">Whatsapp Number</label>
                    <input type="number" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" placeholder="Whatsapp Number [Optional]" name="whatsapp" value="{{$about->whatsapp}}">
                    @error('whatsapp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="About Us" cols="30" rows="10">{!!$about->description!!}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">Edit About Us</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
