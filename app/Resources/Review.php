<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {


        $data = $this->translate(app()->getLocale(), 'fallbackLocale');

        return [
            'id' => $data->id,
            'title' => $data->name,
            'content' => $data->content,
            'rate' => $data->rate,
            'image' => getImageURL($data->image)
        ];
    }
}
