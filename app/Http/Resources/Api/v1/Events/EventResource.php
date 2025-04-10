<?php

namespace App\Http\Resources\Api\v1\Events;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\v1\Category\CategoryResource;

class EventResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->long_description,
            'date_time' => [
                'date'              => Carbon::parse($this->event_date)->format('Y-m-d'), 
                'formatted_date'    => Carbon::parse($this->event_date)->format('d F Y'),  
                'time'              => Carbon::parse($this->event_time)->format('H:i:s'),  
                'formatted_time'    => Carbon::parse($this->event_time)->format('h:i:s A'), 
                'full_date'         => Carbon::parse($this->event_date)->format('Y-m-d') . " " . Carbon::parse($this->event_time)->format('H:i:s'), 
                'full_date_formatted' => Carbon::parse($this->event_date)->format('d F Y') . " " . Carbon::parse($this->event_time)->format('h:i:s A')
            ],
            'location' => $this->location,
            'category' => $this->category ? new CategoryResource($this->category) : null
        ];
    }
}
