<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomepageToursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'price' => $this->price,
            'ts' => $this->tsProfile->user->name,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'images' => $this->images,
            'status' => 200,
        ];
    }
}
