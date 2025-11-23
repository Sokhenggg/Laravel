@extends('layouts.admin')
@section('content')

<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
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
                <h5 class="card-title mb-4 d-inline">Create New Food</h5>
                <a href="{{ route('foods.all') }}" class="btn btn-secondary mb-4 text-center float-right">Back to Foods</a>
                
                <form method="POST" action="{{ route('foods.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Food Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price ($)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="appetizer" {{ old('category') == 'appetizer' ? 'selected' : '' }}>Appetizer</option>
                            <option value="main_course" {{ old('category') == 'main_course' ? 'selected' : '' }}>Main Course</option>
                            <option value="dessert" {{ old('category') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                            <option value="beverage" {{ old('category') == 'beverage' ? 'selected' : '' }}>Beverage</option>
                            <option value="salad" {{ old('category') == 'salad' ? 'selected' : '' }}>Salad</option>
                            <option value="soup" {{ old('category') == 'soup' ? 'selected' : '' }}>Soup</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Food Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Upload an image for the food item (optional)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Food</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection