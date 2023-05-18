<?php

namespace App\Http\Controllers;
use App\Models\Ordereds;
use App\Models\Transactions;
use App\Models\PersonalTours;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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

            $newUsers = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as new_users'))
            ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($query) {
                return [$query['month'] => $query['new_users']];
            })
            ->toArray();
        
        $newRoleUser = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as new_users'))
            ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->where('user_roles', 'user')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($query) {
                return [$query['month'] => $query['new_users']];
            })
            ->toArray();
        $newRoleUser = $this->checkKeyInArray($newUsers, $newRoleUser);
        ksort($newRoleUser);
                
        $newRoleTs = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as new_users'))
            ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->where('user_roles', 'ts')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($query) {
                return [$query['month'] => $query['new_users']];
            })
            ->toArray();
        $newRoleTs = $this->checkKeyInArray($newUsers, $newRoleTs);
        ksort($newRoleTs);

        $numberOfUser = User::where('user_roles', 'user')->where('is_admin', false)->count();
        $numberOfTs = User::where('user_roles', 'ts')->where('is_admin', false)->count();
        
        $topUserWithMostBookedTour = Ordereds::whereDate('ordereds.created_at', date('Y-m-d'))
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->join('ts_profiles', 'tours.ts_id', '=', 'ts_profiles.id')
            ->join('users', 'ts_profiles.user_id', '=', 'users.id')
            ->select('users.name as owner_name', 'ts_profiles.avatar as owner_avatar', 'users.email as owner_email', 'users.phone_number as phone_number', DB::raw('COUNT(*) as amount'))
            ->groupBy('owner_name', 'owner_avatar', 'owner_email', 'phone_number')
            ->orderBy('amount', 'desc')
            ->paginate(5);

        return view('pages.dashboard', [
            'revenueInMonth' => $revenueInMonth + 0,
            'numberOrderedInMonth' => $numberOrderedInMonth,
            'newUserInMonth' => $newUserInMonth,
            'orderedsInMonth' => $orderedInMonth,
            'psTourStartToday' => $psTourStartToday,
            'psTourEndToday' => $psTourEndToday,
            'orderedToday' => $orderedToday,
            'monthAvaiable' => array_keys($newUsers),
            'newUsers' => $newUsers,
            'newRoleUser' => $newRoleUser,
            'newRoleTs' => $newRoleTs,
            'numberOfUser' => $numberOfUser,
            'numberOfTs' => $numberOfTs,
            'topUserWithMostBookedTour' => $topUserWithMostBookedTour,
        ]);
    }

    public function checkKeyInArray($largeArray, $smallArray)
    {
        foreach ($largeArray as $key => $value) {
            if (!array_key_exists($key, $smallArray)) {
                $smallArray[$key] = 0;
            }
        }
        return $smallArray;
    }
}
