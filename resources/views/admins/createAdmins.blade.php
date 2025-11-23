@extends('layouts.admin')
@section('content')

<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="{{ route('admins.store') }}" enctype="multipart/form-data">
                 @csrf
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" value="{{ old('email') }}" />
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="name" id="form2Example2" class="form-control" placeholder="name" value="{{ old('name') }}" />
                </div>
                
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example3" class="form-control" placeholder="password" />
                </div>

                <div class="form-outline mb-4">
                  <input type="password" name="password_confirmation" id="form2Example4" class="form-control" placeholder="confirm password" />
                </div>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">create</button>
              </form>

            </div>
          </div>
        </div>
      </div>

@endsection