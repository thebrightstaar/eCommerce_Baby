@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Create Category
                    <a href="{{ route('categories.create') }}" class="btn btn-primary float-right">Create category</a>
                </div>

                <div class="card-body">
                    
                    @include('partials.alerts')

                    <form action="{{ route('categories.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Category Name:</label>
                            <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="parent_category">Parent Category:</label>
                            <select class="form-control" name="parent_category">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('parent_category') }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection