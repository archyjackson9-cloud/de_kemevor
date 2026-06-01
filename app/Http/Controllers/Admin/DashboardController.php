<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd   = Carbon::now()->endOfWeek();

        $todayBookings    = Booking::whereDate('booking_date', $today)->count();
        $weekBookings     = Booking::whereBetween('booking_date', [$weekStart, $weekEnd])->count();
        $totalCustomers   = Customer::count();
        $pendingBookings  = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();

        $revenueThisMonth = Booking::whereMonth('booking_date', $today->month)
            ->whereYear('booking_date', $today->year)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('final_price');

        $recentBookings = Booking::with(['customer', 'service'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $upcomingBookings = Booking::with(['customer', 'service'])
            ->where('booking_date', '>=', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayBookings', 'weekBookings', 'totalCustomers',
            'pendingBookings', 'confirmedBookings', 'completedBookings',
            'revenueThisMonth', 'recentBookings', 'upcomingBookings'
        ));
    }
}
