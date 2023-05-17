<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tours;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TSTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return User::withWhereHas('tours')->get()[0]->tours;
        // $data = Tours::paginate(10);
        // return $data;
        return view('pages.tsTour', [
            'title' => 'List tours',
            'tours' => User::withWhereHas('tours')->paginate(10),
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tours $tour)
    {
        Tours::destroy($tour->id);

        return redirect()->route('tst.index')->with('success', 'Deleted successfully!');
    }
}
