@extends('layouts.admin')
@section('content')

<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
</div>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Foods</h5>
              <a href="{{ route('foods.create') }}" class="btn btn-primary mb-4 text-center float-right">Create New Food</a>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($allFoods as $food)
                    <tr>
                        <th scope="row">{{ $food->id }}</th>
                        <td>
                            @if($food->image)
                                <img src="{{ asset('assets/' . $food->image) }}" alt="{{ $food->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 5px;">
                                    <small class="text-white">No Image</small>
                                </div>
                            @endif
                        </td>
                        <td>{{ $food->name }}</td>
                        <td>${{ number_format($food->price, 2) }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($food->category) }}</span>
                        </td>
                        <td>{{ Str::limit($food->description, 50) }}</td>
                        <td>
                            <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('foods.delete', $food->id) }}" onsubmit="return confirm('Are you sure you want to delete this food item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>

@endsection