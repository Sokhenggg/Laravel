<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food\Food;
use App\Models\Food\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breakfastFoods = Food::select()->take(4)->where('category', 'Breakfast')->get();
        $lunchFoods = Food::select()->take(4)->where('category', 'Lunch')->get();
        $dinnerFoods = Food::select()->take(4)->where('category', 'Dinner')->get();
        $reviews = Review::select()->take(4)->get();
        return view('home', compact('breakfastFoods', 'lunchFoods', 'dinnerFoods', 'reviews'));
    }

    /**
     * Show food details page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function foodDetails($id)
    {
        $foodItem = Food::find($id);
        // If no food item found, create a sample object for demonstration
        return view('foods.food-details', compact('foodItem'));
    }

    public function about()
    {
        return view('pages.about');
    }
    public function service()
    {
        return view('pages.service');
    }
    public function contact()
    {
        return view('pages.contact');
    }
}
