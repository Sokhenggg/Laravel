<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Food;
use App\Models\Food\Cart;
use App\Models\Food\checkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Food\Booking;

class FoodsController extends Controller
{
    public function foodDetails($id)
    {
        // Get the food item
        $foodItem = Food::find($id);
        
        // Check if food item exists
        if (!$foodItem) {
            return redirect()->route('home')->with('error', 'Food item not found.');
        }
        
        if(Auth::check()){
            // User is authenticated
            //verify if user added item to cart
            $cartVerifying = Cart::where('food_id', $id)->
            where('user_id', Auth::user()->id)->count();
            return view('foods.food-details', compact('foodItem', 'cartVerifying'));
        } else {
            $cartVerifying = 0;
            return view('foods.food-details', compact('foodItem'));
        }
    }

    //cart
    public function cart(Request $request, $id)
    {
        // Get the first available food item or create a sample one
        $cart = Cart::create([
            'user_id' => $request->input('user_id'),
            'food_id' => $request->input('food_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $request->input('image'),
        ]);

        if ($cart){
            return redirect()->route('food.details', $id)->with('success', 'Food  added to cart successfully!');
        }


        // return view('foods.food-details', compact('foodItem'));
    }

    public function displayCartItems()
    {

        //verify if user added item to cart
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();

            //display price
            $price = Cart::where('user_id', Auth::user()->id)->sum('price');

            return view('foods.cart', compact('cartItems', 'price'));
        } else {
            abort(404);

        }

    }

    public function deleteCartItems($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('food.display.cart')->with('success', 'Item removed from cart successfully!');
        } else {
            return redirect()->route('food.display.cart')->with('error', 'Item not found in cart.');
        }
    }

        public function prepareCheckout(Request $request)
        {
            // Get the first available food item or create a sample one
            $value = $request->price;
            $price = Session::put('price', $value);
            $newPrice = Session::get('price');

            if($newPrice>0){
                if(Session::get('price') == 0){
            abort(403);
            }else{
                return view('foods.checkout', compact('price'));
            }
        }
        }
        public function checkout()
        {
            $price = Session::get('price');
            return view('foods.checkout', compact('price'));
        }

        public function storeCheckout(Request $request)
    {
        // Get the first available food item or create a sample one
        $checkout = checkout::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'town' => $request->town,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
            'price' => $request->price,
            // 'status' => 'Pending'
        ]);

        // echo "Go to Paypal to complete the payment process.";
        if ($checkout){
            if(Session::get('price') == 0){
            abort(403);
        }else{
            return redirect()->route('foods.pay');
        }
    }

        // return view('foods.food-details', compact('foodItem'));
    }

    public function payWithPaypal()
    {

        if(Session::get('price') == 0){
            abort(403);
        }else{
            return view('foods.pay');
        }
    }

    public function success()
    {
        // Clear the cart after successful payment
       $deleteItem = Cart::where('user_id', Auth::user()->id);
         $deleteItem->delete();
      

       if($deleteItem){
        if(Session::get('price') == 0){
            abort(403);
        }else
         Session::forget('price');
                return view('foods.success')->with('success', 'Payment successful!.');
        } 

    }

    public function bookingTables(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to make a booking.');
        }

        // Check if any required field is empty
        if (empty($request->name) || empty($request->email) || empty($request->num_people) || empty($request->date)) {
            return redirect()->route('home')->with('error', 'Some inputs are empty. Please fill in all required fields.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'num_people' => 'required',
            'date' => 'required',
            'request' => 'nullable|string|max:500',
        ]);

        // Get current date and time
        $current_date = now();
        $booking_date = \Carbon\Carbon::parse($request->date);
        
        // Check if the booking date is in the past
        if($booking_date->lessThanOrEqualTo($current_date)){
            return redirect()->route('home')->with('error','Please select a valid date and time for booking. The selected date is in the past.');
        }

        // Create the booking
        $bookingTables = Booking::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'num_people' => $request->num_people,
            'date' => $request->date,
            'request' => $request->input('request')
        ]);

        if ($bookingTables){
            return redirect()->route('home')->with('booked','You booked the table successfully');
        }
        
        return redirect()->route('home')->with('error','Booking failed. Please try again.');
    }


    public function menu()
    {
        $breakfastFoods = Food::select()->take(4)->where('category', 'Breakfast')->get();
        $lunchFoods = Food::select()->take(4)->where('category', 'Lunch')->get();
        $dinnerFoods = Food::select()->take(4)->where('category', 'Dinner')->get();
        return view('foods.menu', compact('breakfastFoods', 'lunchFoods', 'dinnerFoods'));
    }
}
