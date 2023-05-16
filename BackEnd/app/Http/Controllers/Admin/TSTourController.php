<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tours;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TSTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Tours::with(['tsProfile.user'])->paginate(10);
        // return $data;
        return view('pages.tsTour', [
            'title' => 'List tours',
            'tours' => Tours::with(['tsProfile'])->paginate(10),
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tours $tour)
    {
        Tours::destroy($tour->id);

        return redirect()->route('pst.index')->with('success', 'Deleted successfully!');
    }
}
