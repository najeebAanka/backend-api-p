<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Status extends JsonResource
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
        return $data->name;
    }
}
