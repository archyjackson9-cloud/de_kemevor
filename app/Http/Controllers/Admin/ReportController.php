<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $year  = request('year', now()->year);
        $month = request('month', now()->month);

        // Monthly bookings by week
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $weeklyData = [];
        $weekNum    = 1;
        $current    = $startOfMonth->copy()->startOfWeek();

        while ($current->lte($endOfMonth)) {
            $weekEnd  = $current->copy()->endOfWeek();
            $count    = Booking::whereBetween('booking_date', [
                max($current->toDateString(), $startOfMonth->toDateString()),
                min($weekEnd->toDateString(), $endOfMonth->toDateString()),
            ])->count();
            $weeklyData[] = ['label' => "Week $weekNum", 'count' => $count];
            $current->addWeek();
            $weekNum++;
        }

        // Service popularity
        $servicePopularity = Booking::select('service_id', DB::raw('count(*) as total'))
            ->with('service')
            ->groupBy('service_id')
            ->orderByDesc('total')
            ->get()
            ->map(fn($b) => ['name' => $b->service->name ?? 'Unknown', 'total' => $b->total]);

        // New vs returning customers per month
        $allCustomers    = Customer::count();
        $newThisMonth    = Customer::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $returning       = $allCustomers - $newThisMonth;

        // Retention rate: customers with 2+ bookings / total
        $retentionCount  = Customer::where('total_bookings', '>=', 2)->count();
        $retentionRate   = $allCustomers > 0 ? round($retentionCount / $allCustomers * 100, 1) : 0;

        // Monthly revenue (last 6 months)
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $mo  = Carbon::now()->subMonths($i);
            $rev = Booking::whereMonth('booking_date', $mo->month)
                ->whereYear('booking_date', $mo->year)
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('final_price');
            $revenueData[] = ['label' => $mo->format('M Y'), 'revenue' => (float) $rev];
        }

        // Top 5 customers by bookings
        $topCustomers = Customer::orderByDesc('total_bookings')->limit(5)->get();

        return view('admin.reports.index', compact(
            'weeklyData', 'servicePopularity', 'newThisMonth', 'returning',
            'retentionRate', 'retentionCount', 'allCustomers', 'revenueData',
            'topCustomers', 'year', 'month'
        ));
    }
}
