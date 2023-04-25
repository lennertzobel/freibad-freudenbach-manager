<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $date = is_null($request->input('date')) ? Date::now() : Date::parse($request->input('date'));
        $timeslot = is_null($request->input('timeslot')) ? $this->getTimeslot($date) : $request->input('timeslot');
        
        $search_params = [
            'date' => $date->format('d.m.Y'),
            'timeslot' => $timeslot,
        ];

        return view('booking/bookings', [
            'bookings' => $this->getBookings($date, $timeslot),
            'search_params' => $search_params,
            'timeslot' => $timeslot,
            'sum_of_people' => $this->getSumOfBookings($date, $timeslot)
        ]);
    }

    public function checkin(\App\Booking $booking) {
        $booking->confirmed = true;
        $booking->save();

        return back();
    }

    public function checkout(\App\Booking $booking) {
        $booking->confirmed = false;
        $booking->save();

        return back();
    }

    public function cancel(\App\Booking $booking) {
        $booking->delete();

        return back();
    }

    private function getTimeslot($date) {
        if($date > Date::parse('13:30')) {
            return 'noon_evening';
        } else {
            return 'morning';
        }
    }

    private function getBookings($date, $timeslot) {
        return Booking::where('date', $date->format('Y-m-d'))->where('timeslot', $timeslot)->orderBy('last_name','asc')->get();
    }

    private function getSumOfBookings($date, $timeslot) {
        return Booking::where('date', $date->format('Y-m-d'))->where('timeslot', $timeslot)->sum('amount_of_people');
    }
}
