<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.room', [
            'title' => 'List rooms',
            'rooms' => Rooms::with('user')->paginate(10),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rooms $room)
    {
        Rooms::destroy($room->id);

        return redirect()->route('room.index')->with('success', 'Deleted successfully!');
    }
}
