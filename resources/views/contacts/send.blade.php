@extends('layouts.master')



@section('title')
   Send message for user
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Send message for user</h1>
                 </div>
                 <div class="card-body">
                    <form action="{{route('contact.send', $user->id)}}" method="POST">
                         @csrf
                        <div class="form-group" >
                              <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" placeholder="Subject" class="form-control" >
                              </div>
                              <div class="mb-3">
                                <label for="mesId" class="form-label">Please write the message here</label>
                                <textarea class="form-control" id="mesId" rows="3" placeholder="Message" name="message"></textarea>
                              </div>
                        </div>
                        <button type="submit" class="btn btn-success"> Send Message </button>
                  </form>
                  </div>
              </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection
