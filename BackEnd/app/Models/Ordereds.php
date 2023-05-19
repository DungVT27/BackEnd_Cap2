<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ordereds extends Model
{
    use HasFactory;

    protected $table = 'ordereds';

    protected $fillable = [
        'user_id',
        'tour_id',
        'price',
        'tickets',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function numberOrderedInDate($date)
    {
        return self::whereDate('created_at', $date)->count();
    }

    public function numberOrderedInMonth($month, $year)
    {
        return self::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)->count();
    }

    public function orderedInMonth($month, $year)
    {
        return self::whereMonth('ordereds.created_at', $month)
            ->whereYear('ordereds.created_at', $year)
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.*')
            ->paginate(5);
    }

    public function orderInDate($date)
    {
        return self::whereDate('ordereds.created_at', $date)
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.*')
            ->get();
    }

    public function topUserHasMostBookedTourInMonth($month, $year)
    {
        return self::whereMonth('ordereds.created_at', $month)
            ->whereYear('ordereds.created_at', $year)
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->join('ts_profiles', 'tours.ts_id', '=', 'ts_profiles.id')
            ->join('users', 'ts_profiles.user_id', '=', 'users.id')
            ->select('users.name as owner_name', 'ts_profiles.avatar as owner_avatar', 
                'users.email as owner_email', 'users.phone_number as phone_number', 
                DB::raw('COUNT(*) as amount'))
            ->groupBy('owner_name', 'owner_avatar', 'owner_email', 'phone_number')
            ->orderBy('amount', 'desc')
            ->paginate(5);
    }
}
