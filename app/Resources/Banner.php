<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
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
            'title' => $data->title,
            'sub_title' => $data->sub_title,
            'sub_sub_title' => $data->sub_sub_title,
            'link' => $data->link,
            'image' => getImageURL($data->image),
        ];
    }
}
