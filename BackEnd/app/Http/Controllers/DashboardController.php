<?php

namespace App\Http\Controllers;
use App\Models\Ordereds;
use App\Models\Transactions;
use App\Models\PersonalTours;
use App\Models\User;
use Carbon\Carbon;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $revenueInMonth = Transactions::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->sum('amount');

        $numberOrderedInMonth = Ordereds::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();

        $newUserInMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();
        
        $orderedInMonth = Ordereds::whereMonth('ordereds.created_at', Carbon::now()->month)
            ->whereYear('ordereds.created_at', Carbon::now()->year)
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.*')
            ->paginate(5);

        $psTourStartToday = PersonalTours::where('from_date', date('Y-m-d'))
            ->join('users', 'personal_tours.owner_id', '=', 'users.id')
            ->select('personal_tours.*', 'users.name as owner_name')
            ->get();
        // dd($psTourStartToday);
        $psTourEndToday = PersonalTours::where('to_date', date('Y-m-d'))
            ->join('users', 'personal_tours.owner_id', '=', 'users.id')
            ->select('personal_tours.*', 'users.name as owner_name')
            ->get();

        $orderedToday = Ordereds::whereDate('ordereds.created_at', date('Y-m-d'))
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.*')
            ->get();
        
        return view('pages.dashboard', [
            'revenueInMonth' => $revenueInMonth + 0,
            'numberOrderedInMonth' => $numberOrderedInMonth,
            'newUserInMonth' => $newUserInMonth,
            'orderedsInMonth' => $orderedInMonth,
            'psTourStartToday' => $psTourStartToday,
            'psTourEndToday' => $psTourEndToday,
            'orderedToday' => $orderedToday,
        ]);
    }
}
