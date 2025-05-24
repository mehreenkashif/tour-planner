<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Only allow admin users
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // 1. Bar Chart: Total Tours per Tour Planner (Admin only)
        $toursPerPlanner = User::where('role', 'tour_planner')
            ->withCount('tours')
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'tours_count' => $user->tours_count,
                ];
            });

        // 2. Pie Chart: Percentage of tours by status
        // Define status:
        // upcoming: start_date > today
        // ongoing: start_date <= today && end_date >= today
        // ended: end_date < today

        $today = Carbon::today();

        $toursByStatus = [
            'upcoming' => Tour::where('start_date', '>', $today)->count(),
            'ongoing' => Tour::where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->count(),
            'ended' => Tour::where('end_date', '<', $today)->count(),
        ];

        // 3. Line Chart: Tours created monthly (last 6 months)
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        $toursMonthly = Tour::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Format labels for last 6 months and counts (fill zero if no data)
        $months = [];
        $counts = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $sixMonthsAgo->copy()->addMonths($i)->format('Y-m');
            $months[] = $sixMonthsAgo->copy()->addMonths($i)->format('M Y');
            $counts[] = $toursMonthly->has($month) ? $toursMonthly[$month]->count : 0;
        }

        return view('dashboard.index', [
            'toursPerPlanner' => $toursPerPlanner,
            'toursByStatus' => $toursByStatus,
            'lineChartLabels' => $months,
            'lineChartData' => $counts,
        ]);
    }
}
