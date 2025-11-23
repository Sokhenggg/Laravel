<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Food\checkout;
use App\Models\Food\Review;
class User extends Controller
{
    public function getBookings(){
        $allBookings = Booking::where('user_id', Auth::user()->id)->get();
        return view('users.bookings', compact('allBookings'));
    }

    public function getOrders(){
        $allOrders = checkout::where('user_id', Auth::user()->id)->get();
        return view('users.orders', compact('allOrders'));
    }

    public function viewReviews(){
        return view('users.writeReviews');
    }

    public function submitReview(){

         Request()->validate([
            'name' => 'required|string|max:255',
            'review' => 'required|string',
        ]);


        $submitReview = Review::create([
            'name' => request('name'),
            'review' => request('review')
        ]); 

        if ($submitReview) {
            return redirect()->route('users.reviews.create')->with('success', 'Review submitted successfully!');
        }

        return redirect()->route('home')->with('error', 'Failed to submit review.');
    }

}
