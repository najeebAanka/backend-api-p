<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandFull extends JsonResource
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
            'image' => getImageURL($data->image),
            'image_colored' => getImageURL($data->image_colored),
            'models' => Model::collection(\App\Models\Model::where('brand_id', $this->id)->get()),
            'url' => $data->url
        ];
    }
}
