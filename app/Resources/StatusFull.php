<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusFull extends JsonResource
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
            'id'=>$data->id,
            'name'=>$data->name
        ];
    }
}