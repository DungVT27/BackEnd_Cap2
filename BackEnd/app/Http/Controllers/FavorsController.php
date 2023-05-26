<?php

namespace App\Http\Controllers;

use App\Models\Favors;
use Illuminate\Http\Request;

class FavorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'Favors' => Favors::all(),
            'status' => 200
        ]);
    }
}
