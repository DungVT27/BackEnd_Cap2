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
    private $transactions;
    private $ordereds;
    private $personalTour;
    private $user;

    public function __construct(
        Transactions $transactions, 
        Ordereds $ordereds,
        User $user,
        PersonalTours $personalTour
    )
    {
        $this->transactions = $transactions;
        $this->ordereds = $ordereds;
        $this->user = $user;
        $this->personalTour = $personalTour;
    }

    public function home(Request $request)
    {
        $monthNow = Carbon::now()->month;
        $yearNow = Carbon::now()->year;

        if($request->has('orderedLastMonth')){
            $numberOrderedInMonth = $this->ordereds->numberOrderedInMonth($monthNow - 1, $yearNow);
            $orderedTitle = "Last Month";
        }
        else{
            if($request->has('orderedToday')){
                $numberOrderedInMonth = $this->ordereds->numberOrderedInDate(date('Y-m-d'));
                $orderedTitle = "Today";
            }
            else{
                $numberOrderedInMonth = $this->ordereds->numberOrderedInMonth($monthNow, $yearNow);
                $orderedTitle = "This Month";
            }
        }

        if($request->has('revenueLastMonth')){
            $revenueInMonth = $this->transactions->revenueInMonth($monthNow - 1, $yearNow);
            $revenueTitle = "Last Month";
        }
        else{
            if($request->has('revenueToday')){
                $revenueInMonth = $this->transactions->revenueInDate(date('Y-m-d'));
                $revenueTitle = "Today";
            }
            else{
                $revenueInMonth = $this->transactions->revenueInMonth($monthNow, $yearNow);
                $revenueTitle = "This Month";
            }
        }

        if($request->has('customerLastMonth')){
            $newUserInMonth = $this->user->newUserInMonth($monthNow - 1, $yearNow);
            $newUserTitle = "Last Month";
        }
        else{
            $newUserInMonth = $this->user->newUserInMonth($monthNow, $yearNow);
            $newUserTitle = "This Month";
        }
        
        if($request->has('recentOrderLastMonth')){
            $orderedInMonth = $this->ordereds->orderedInMonth($monthNow - 1, $yearNow);
            $recentOrderedTitle = "Last Month";
        }
        else{
            $orderedInMonth = $this->ordereds->orderedInMonth($monthNow, $yearNow);
            $recentOrderedTitle = "This Month";
        }

        $psTourStartToday = $this->personalTour->psTourStartInDate(date('Y-m-d'));

        $psTourEndToday = $this->personalTour->psTourEndInDate(date('Y-m-d'));

        $orderedToday = $this->ordereds->orderInDate(date('Y-m-d'));

        $newUsers = $this->user->numberUserWithRole();
        
        $newRoleUser = $this->user->numberUserWithRole('user');
        $newRoleUser = $this->checkKeyInArray($newUsers, $newRoleUser);
        ksort($newRoleUser);
                
        $newRoleTs = $this->user->numberUserWithRole('ts');
        $newRoleTs = $this->checkKeyInArray($newUsers, $newRoleTs);
        ksort($newRoleTs);

        $numberOfUser = User::where('user_roles', 'user')->where('is_admin', false)->count();
        $numberOfTs = User::where('user_roles', 'ts')->where('is_admin', false)->count();
        
        if($request->has('topOwnerLastMonth')){
            $topUserWithMostBookedTour = $this->ordereds->topUserHasMostBookedTourInMonth($monthNow - 1, $yearNow);
            $topOwnerTitle = "Last month";
        }
        else{
            $topUserWithMostBookedTour = $this->ordereds->topUserHasMostBookedTourInMonth($monthNow, $yearNow);
            $topOwnerTitle = "This month";
        }

        return view('pages.dashboard', [
            'revenueInMonth' => $revenueInMonth + 0,
            'revenueTitle' => $revenueTitle,
            'numberOrderedInMonth' => $numberOrderedInMonth,
            'orderedTilte' => $orderedTitle,
            'newUserInMonth' => $newUserInMonth,
            'newUserTitle' => $newUserTitle,
            'orderedsInMonth' => $orderedInMonth,
            'recentOrderedTitle' => $recentOrderedTitle,
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
            'topOwnerTitle' => $topOwnerTitle,
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
