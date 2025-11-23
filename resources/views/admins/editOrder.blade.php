@extends('layouts.admin')
@section('content')

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Food Items</h5>
              <p>Status is {{ $order->status }}</p>
          <form method="POST" action="{{ route('orders.edit', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    
               
                <div class="form-outline mb-4 mt-4">

                  <select name="status" class="form-select  form-control" aria-label="Default select example">
                    <option selected>Choose Meal</option>
                    <option value="1">Processing</option>
                    <option value="2">Completed</option>
                    <option value="3">Canceled</option>
                  </select>
                </div>

                <br>
              

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>

@endsection