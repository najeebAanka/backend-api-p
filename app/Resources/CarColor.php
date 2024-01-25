<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarColor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'color' => $this->color,
            'name' => $this->name,
            'image' => getImageURL($this->image),
        ];
    }
}
