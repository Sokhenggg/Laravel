@extends('layouts.app')
@section('content')




<div class="container-xxl py-5 bg-dark hero-header mb-5" style="margin-top: -25px;">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Payment Successful</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Success</a></li>
            </ol>
        </nav>
    </div>
</div>
<div>
    @if(session()->has('success'))
    <p class="alert {{ session()->get('alert-class','success') }}">{{ session()->get('success') }}</p>
    @endif
</div>
<div class="container">
    <div class="col-md-12">
        <h3 class="alert alert-success">Your payment was successful. Thank you for your purchase!</h3>
        <a href="{{ route('foods') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>


@endsection