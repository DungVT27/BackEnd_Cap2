<?php

namespace App\Http\Controllers;

use App\Models\Ordereds;
use Illuminate\Http\Request;

class OrderedsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordereds $ordereds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordereds $ordereds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordereds $ordereds)
    {
        //
    }

    public function historyOrderedOfUser(Request $request)
    {
        $userOrdereds = Ordereds::where('ordereds.user_id', $request->user_id)
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.price', 'ordereds.tickets', 'ordereds.created_at as date')
            ->get();
        
        return response()->json($userOrdereds);
    }

    public function searchUserOrdered(Request $request)
    {
        $userOrdereds = Ordereds::where('users.name', 'like', "%" . $request->name . "%")
            ->join('users', 'ordereds.user_id', '=', 'users.id')
            ->join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->select('users.name as user_name', 'tours.name as tour_name', 'ordereds.price', 'ordereds.tickets', 'ordereds.created_at as date')
            ->get();
        
        return response()->json($userOrdereds);
    }
}
