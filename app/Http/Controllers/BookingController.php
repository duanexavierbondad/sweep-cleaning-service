<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Admin;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Customer;
use App\Models\Assigned_cleaner;
class BookingController extends Controller
{
    function admin_transaction(){
        //Retrieve Services Data from database  
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction', $data);
    }
    
    function customer_transaction(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_transaction', $data);
    }

    function customer_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_history', $data);
    }

    function cleaner_job(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_job', $data);
    }

    function cleaner_history(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('cleaner.cleaner_history', $data);
    }

    function updateStatus(Request $request){
 
        //Update data into database
        $updateStatus= Booking::Where('booking_id', $request->booking_id )->update(['status' => $request->status]);
      
       if($updateStatus){
           return back()->with('success', 'Booking Status Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    function cleaner(Request $request){
 
        //Update data into database
        $updateCleaner = Assigned_cleaner::Where('booking_id', '=', $request->booking_id )->Where('cleaner_id', '=', $request->cleaner_id )->update(['status'=> $request->status ] );

        if($updateCleaner){
           return back()->with('success', 'Booking Status Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
    function assignCleaner(Request $request){

        foreach($request->input('cleaner_id') AS $cleaner_id){
        $id = Cleaner::Where('user_id', $cleaner_id )->value('cleaner_id');
        $assigned_cleaners = new Assigned_cleaner();
        $assigned_cleaners->booking_id = $request->booking_id;
        $assigned_cleaners->status = $request->status;
        $assigned_cleaners->cleaner_id = $id;
        $assign = $assigned_cleaners->save();
        }
       if($assign){
           return back()->with('success', 'Booking Status Updated');
        }
        else {
          return back()->with('fail','Something went wrong, try again later ');
        }
    }

    function book(Request $request){
        
        //Validate Requests
        $request->validate([
            'property_type'=>'required',
            'schedule_date'=>'required',
            'schedule_time'=>'required',
        ]);
        
        $id = Customer::Where('user_id', $request->user_id )->value('customer_id');
        $bookings = new Booking();
        $bookings->service_id = $request->service_id;
        $bookings->customer_id = $id;
        $bookings->property_type = $request->property_type;
        $bookings->schedule_date = $request->schedule_date;
        $bookings->schedule_time = $request->schedule_time;
        $bookings->status = 'Pending';
        $bookings->is_paid = false;
        $book = $bookings->save();
        

        if($book){
            return back()->with('success', 'New Service has been successfuly added to database');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    
}
