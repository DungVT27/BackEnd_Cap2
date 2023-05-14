<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use App\Models\PersonalTours;
use App\Models\TripPlan;
use App\Models\Images;
use Illuminate\Http\Request;
use App\Http\Resources\HomepageToursResource;
use App\Http\Resources\TourDetailResource;


class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Tours::all());
    }

    /*
    ** Create a array Trip Schedlue with string 'schedule' get in form
    */
    public function arrayTripPlan($schedule)
    {
        $schedule = preg_replace('/\'/', '', trim($schedule));
        $schedule = json_decode(($schedule));
        return $schedule;
    }

    /*
    ** Create trip schedule for a insert tour
    */
    public function createTripPlanForTour($tripPlan, $tourId)
    {
        foreach($tripPlan as $tripPlanKey => $tripPlanValue){
            TripPlan::create([
                'name' => $tripPlanValue->name,
                'description' => $tripPlanValue->desc,
                'tour_id' => $tourId,
                'lat' => $tripPlanValue->lat,
                'lon' => $tripPlanValue->lon,
            ]);
        }
    }

    /*
    ** Create a array Trip Schedlue with string 'schedule' get in form
    */
    public function arrayImages($images)
    {
        $removeCharacter = ['\'', '[', ']', ' '];
        $images = str_replace($removeCharacter, '', trim($images));
        $images = explode(',', $images);
        return $images;
    }

    /*
    ** Create images for a insert tour
    */
    public function createImagesForTour($images, $tourId)
    {
        foreach($images as $imageValue){
            Images::create([
                'image_url' => $imageValue,
                'tour_id' => $tourId,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tour = Tours::create([
            'ts_id' => $request->ts_id,
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'price' => $request->price,
            'slot' => $request->slot,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tripPlan = $this->arrayTripPlan($request->schedule);
        $this->createTripPlanForTour($tripPlan, $tour->id);

        $images = $this->arrayImages($request->images);
        $this->createImagesForTour($images, $tour->id);

        return response()->json(['msg' => "Tạo tour thành công", 'status' => 200], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(Tours::find($id) == null){
            return response()->json(['msg' => "Tour không tồn tại", 'status' => 404], 404);
        }
        return new TourDetailResource(Tours::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tours $tours)
    {
        if(Tours::find($request->id) == null){
            return response()->json(['msg' => "Tour không tồn tại", 'status' => 404], 404);
        }
        else{
            if($request->ts_id != Tours::find($request->id)->ts_id){
                return response()->json(['msg' => "Đây không phải là tour của bạn", 'status' => 403], 403);
            }
            else{
                Tours::find($request->id)->update([
                    'ts_id' => $request->ts_id,
                    'name' => $request->name,
                    'address' => $request->address,
                    'description' => $request->description,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'price' => $request->price,
                    'slot' => $request->slot,
                ]);

                $tripPlan = $this->arrayTripPlan($request->schedule);
                TripPlan::where('tour_id', $request->id)->delete();
                $this->createTripPlanForTour($tripPlan, $request->id);

                $images = $this->arrayImages($request->images);
                Images::where('tour_id', $request->id)->delete();
                $this->createImagesForTour($images, $request->id);
                return response()->json(['msg' => "Update tour thành công", 'status' => 200], 200);
            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Tours $tours)
    {

        if(Tours::find($request->id) == null){
            return response()->json(['msg' => "Tour không tồn tại", 'status' => 404], 404);
        }
        else{
            if($request->ts_id != Tours::find($request->id)->ts_id){
                return response()->json(['msg' => "Đây không phải là tour của bạn", 'status' => 403], 403);
            }
            else{
                Tours::find($request->id)->delete();
                return response()->json(['msg' => "Delete tour thành công", 'status' => 200], 200);
            }
        }
    }

    public function homepageTours(){
        return HomepageToursResource::collection(Tours::where('from_date', '>=', date('y-m-d'))->get());
    }

    public function allTourOfTS(Request $request){
        return response()->json([
            'all_tour' => Tours::where('ts_id', $request->id)->get(),
            'status' => 200,
        ]);
    }

    public function search(Request $request)
    {
        return response()->json([
            'tours' => Tours::where('tours.name', 'like', "%" . $request->name. "%")
                ->join('ts_profiles', 'tours.ts_id', '=', 'ts_profiles.id')
                ->join('users', 'ts_profiles.user_id', '=', 'users.id')
                ->select('tours.*', 'users.name as travel_supplier_name')
                ->get(),
            'status' => 200,
        ]);
    }

    public function searchByAddress(Request $request)
    {
        $tsTour = Tours::where('tours.address', 'like', "%" . $request->place . "%")
            ->join('ts_profiles', 'tours.ts_id', '=', 'ts_profiles.id')
            ->join('users', 'ts_profiles.user_id', '=', 'users.id')
            ->select('tours.*', 'users.name as travel_supplier_name')
            ->get()
            ->toArray();
        foreach($tsTour as $key => $value){
            $tsTour[$key]['type_tour'] = "ts";
        }

        $psFromWhere = PersonalTours::where('personal_tours.from_where', 'like', "%" . $request->place . "%")
            ->join('users', 'personal_tours.owner_id', '=', 'users.id')
            ->select('personal_tours.*', 'users.name as owner_name')
            ->get()
            ->toArray();
        foreach($psFromWhere as $key => $value){
            $psFromWhere[$key]['type_tour'] = "ps";
        }

        $psToWhere = PersonalTours::where('personal_tours.to_where', 'like', "%" . $request->place . "%")
            ->join('users', 'personal_tours.owner_id', '=', 'users.id')
            ->select('personal_tours.*', 'users.name as owner_name')
            ->get()
            ->toArray();
        foreach($psToWhere as $key => $value){
            $psToWhere[$key]['type_tour'] = "ps";
        }

        return response()->json(array_merge($tsTour, $psFromWhere, $psToWhere));
    }
}
