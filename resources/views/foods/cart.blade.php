@extends('layouts.app')
@section('content')
<div class="container-xxl py-5 bg-dark hero-header mb-5" style="margin-top: -25px;">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Cart</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Cart</a></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Service Start -->
            <div class="container">
                
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if ($cartItems->count()>0)
                          @foreach ($cartItems as $food)
                            <tr>
                                <th><img width="60" height="60" src="{{ asset('assets/img/'.$food->image) }}"></th>
                                <td>{{ $food->name }}</td>
                                <td>$ {{ $food->price }}</td>
                                <td><a class="btn btn-danger text-white" href="{{ route('food.delete.cart', $food->id) }}">Delete</a></td>
                            </tr>
                          @endforeach
                        @else
                            <h3 class="alert alert-success">You have no items in cart yet</h3>
                        @endif

                          
                        </tbody>
                      </table>
                      <div class="position-relative mx-auto" style="max-width: 400px; padding-left: 679px;">
                        <p style="margin-left: -7px;" class="w-19 py-3 ps-4 pe-5" type="text"> Total: {{ $price }}</p>
                        @if($price == 0)
                            <p style="width:250px;" class="alert alert-success">you cannot checkout when you have no items in cart</p>
                        @else
                            <form action="{{ route('prepare.checkout') }}" method="POST">
                                @csrf    
                                <input type="hidden" value="{{ $price }}" name="price" >    
                                <button type="submit" name="submit" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">Checkout</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        <!-- Service End -->
@endsection