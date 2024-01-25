<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Content extends JsonResource
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
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'image' => getImageURL($this->image)
        ];
    }
}
