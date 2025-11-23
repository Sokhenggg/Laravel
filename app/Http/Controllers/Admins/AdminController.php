<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Food;

use App\Models\Food\Booking;
use App\Models\Admin\Admin;
use App\Models\Food\Checkout;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function viewLogin()
    {
        return view('admins.login');
    }

    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            
            return redirect() -> route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {


        //foods count
        $foodCount = Food::select()->count();


        //orders or checkout
        $orderCount = checkout::select()->count();

        //bookings
        $bookingCount = Booking::select()->count();

        //admins count
        $adminCount = Admin::select()->count();


        return view('admins.index', compact('foodCount', 'bookingCount', 'adminCount', 'orderCount'));
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('view.login')->with('success', 'You have been logged out successfully');
    }

    //all admins
    public function allAdmins(){
        $allAdmins = Admin::select()->orderBy('id', 'desc')->get();
        return view('admins.allAdmins', compact('allAdmins'));
    }

    public function createAdmin(){
        return view('admins.createAdmins');
    }

    public function storeAdmin(Request $request){
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new admin
        $newAdmin = Admin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($newAdmin) {
            return redirect()->route('admins.all')->with('success', 'New admin created successfully!');
        }

        return redirect()->route('admins.create')->with('error', 'Failed to create new admin.');
    }

    //orders
    public function allOrders(){
        $allOrders = Checkout::select()->orderBy('id', 'desc')->get();
        return view('admins.allOrders', compact('allOrders'));
    }

    public function updateOrderStatus(Request $request, $id){
        $order = Checkout::find($id);
        if (!$order) {
            return redirect()->route('orders.all')->with('error', 'Order not found.');
        }

        $request->validate([
            'status' => 'required|in:processing,completed,canceled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.all')->with('success', 'Order status updated successfully!');
    }

    public function deleteOrder($id){
        $order = Checkout::find($id);
        if (!$order) {
            return redirect()->route('orders.all')->with('error', 'Order not found.');
        }

        $order->delete();
        return redirect()->route('orders.all')->with('success', 'Order deleted successfully!');
    }

    //bookings
    public function allBookings(){
        $allBookings = Booking::select()->orderBy('id', 'desc')->get();
        return view('admins.allBookings', compact('allBookings'));
    }

    public function updateBookingStatus(Request $request, $id){
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('bookings.all')->with('error', 'Booking not found.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,canceled'
        ]);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('bookings.all')->with('success', 'Booking status updated successfully!');
    }

    public function deleteBooking($id){
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('bookings.all')->with('error', 'Booking not found.');
        }

        $booking->delete();
        return redirect()->route('bookings.all')->with('success', 'Booking deleted successfully!');
    }

    //foods
    public function allFoods(){
        $allFoods = Food::select()->orderBy('id', 'desc')->get();
        return view('admins.allFoods', compact('allFoods'));
    }

    public function createFood(){
        return view('admins.createFood');
    }

    public function storeFood(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        $food = Food::create([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        if ($food) {
            return redirect()->route('foods.all')->with('success', 'Food item created successfully!');
        }

        return redirect()->route('foods.create')->with('error', 'Failed to create food item.');
    }

    public function editFood($id){
        $food = Food::find($id);
        if (!$food) {
            return redirect()->route('foods.all')->with('error', 'Food item not found.');
        }
        return view('admins.editFood', compact('food'));
    }

    public function updateFood(Request $request, $id){
        $food = Food::find($id);
        if (!$food) {
            return redirect()->route('foods.all')->with('error', 'Food item not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $food->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($food->image && file_exists(storage_path('app/public/' . $food->image))) {
                unlink(storage_path('app/public/' . $food->image));
            }
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        $food->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('foods.all')->with('success', 'Food item updated successfully!');
    }

    public function deleteFood($id){
        $food = Food::find($id);
        if (!$food) {
            return redirect()->route('foods.all')->with('error', 'Food item not found.');
        }

        // Delete image file if exists
        if ($food->image && file_exists(storage_path('app/public/' . $food->image))) {
            unlink(storage_path('app/public/' . $food->image));
        }

        $food->delete();
        return redirect()->route('foods.all')->with('success', 'Food item deleted successfully!');
    }
}
