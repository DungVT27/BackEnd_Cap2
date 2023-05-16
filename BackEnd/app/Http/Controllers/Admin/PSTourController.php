<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalTours;

class PSTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.psTour', [
            'title' => 'List tours',
            'tours' => PersonalTours::with(['user', 'room'])->paginate(10),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalTours $tour)
    {
        PersonalTours::destroy($tour->id);

        return redirect()->route('pst.index')->with('success', 'Deleted successfully!');
    }
}
